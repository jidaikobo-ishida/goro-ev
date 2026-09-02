# Windows PowerShell用 WordPress初期セットアップスクリプト

if (-not (Test-Path .env)) {
    Write-Host "📄 .env not found. Copying from .env.example..." -ForegroundColor Cyan
    Copy-Item .env.example .env
}

# .envファイルの読み込み
Get-Content .env | Where-Object { $_ -match '^[^#].+=.+' } | ForEach-Object {
    $key, $value = $_.Split('=', 2)
    $val = $value.Trim().Trim('"').Trim("'")
    [System.Environment]::SetEnvironmentVariable($key.Trim(), $val, "Process")
}

Write-Host "🚀 Starting WordPress Docker containers..." -ForegroundColor Green
docker compose up -d

Write-Host "⏳ Waiting for Database to be ready..." -ForegroundColor Yellow
$retries = 0
while ($retries -lt 20) {
    $dbCheck = docker compose run --rm wpcli wp db check 2>&1
    if ($LASTEXITCODE -eq 0) {
        break
    }
    Write-Host "  Waiting for DB connection... ($retries)"
    Start-Sleep -Seconds 3
    $retries++
}

Write-Host "🔍 Checking WordPress installation status..." -ForegroundColor Cyan
docker compose run --rm wpcli wp core is-installed 2>&1 | Out-Null

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ WordPress is already installed." -ForegroundColor Green
} else {
    if (Test-Path latest_db.sql) {
        Write-Host "📥 Found latest_db.sql. Importing database dump..." -ForegroundColor Cyan
        docker compose cp ./latest_db.sql wordpress:/var/www/html/latest_db.sql
        docker compose run --rm wpcli wp db import latest_db.sql
        docker compose exec wordpress rm -f /var/www/html/latest_db.sql
        docker compose run --rm wpcli wp rewrite flush --hard
        Write-Host "✅ Database restored from latest_db.sql." -ForegroundColor Green
    } else {
        Write-Host "⚙️ Installing clean WordPress..." -ForegroundColor Cyan
        $wpUrl = $env:WP_URL; if (-not $wpUrl) { $wpUrl = "http://localhost:8080" }
        $wpTitle = $env:WP_TITLE; if (-not $wpTitle) { $wpTitle = "Goro ev station" }
        $wpAdmin = $env:WP_ADMIN_USER; if (-not $wpAdmin) { $wpAdmin = "goroadmev" }
        $wpPass = $env:WP_ADMIN_PASSWORD; if (-not $wpPass) { $wpPass = "zovukqGGds2PNHEb" }
        $wpEmail = $env:WP_ADMIN_EMAIL; if (-not $wpEmail) { $wpEmail = "admin@goro-ev.local" }

        docker compose run --rm wpcli wp core install --url=$wpUrl --title=$wpTitle --admin_user=$wpAdmin --admin_password=$wpPass --admin_email=$wpEmail --skip-email

        Write-Host "🌐 Setting site language to Japanese (ja)..." -ForegroundColor Cyan
        docker compose run --rm wpcli wp language core install ja
        docker compose run --rm wpcli wp site switch-language ja
    }

    $wpUrl = $env:WP_URL; if (-not $wpUrl) { $wpUrl = "http://localhost:8080" }
    $wpAdmin = $env:WP_ADMIN_USER; if (-not $wpAdmin) { $wpAdmin = "goroadmev" }
    $wpPass = $env:WP_ADMIN_PASSWORD; if (-not $wpPass) { $wpPass = "zovukqGGds2PNHEb" }

    Write-Host "==================================================" -ForegroundColor Green
    Write-Host "🎉 WordPress setup completed successfully!" -ForegroundColor Green
    Write-Host "Site URL    : $wpUrl"
    Write-Host "Admin URL   : $wpUrl/login_00731"
    Write-Host "Username    : $wpAdmin"
    Write-Host "Password    : $wpPass"
    Write-Host "==================================================" -ForegroundColor Green
}
