# Windows PowerShell用 DBインポートスクリプト
if (-not (Test-Path latest_db.sql)) {
    Write-Host "❌ latest_db.sql not found." -ForegroundColor Red
    exit 1
}
Write-Host "📥 Importing latest_db.sql into database..." -ForegroundColor Cyan
docker compose cp ./latest_db.sql wordpress:/var/www/html/latest_db.sql
docker compose run --rm wpcli wp db import latest_db.sql
docker compose exec wordpress rm -f /var/www/html/latest_db.sql
docker compose run --rm wpcli wp rewrite flush --hard
Write-Host "✅ Database imported successfully." -ForegroundColor Green
