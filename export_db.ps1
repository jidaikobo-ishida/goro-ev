# Windows PowerShell用 DBエクスポートスクリプト
Write-Host "📦 Exporting database to latest_db.sql..." -ForegroundColor Cyan
docker compose run --rm wpcli wp db export latest_db.sql
docker compose cp wordpress:/var/www/html/latest_db.sql ./latest_db.sql
Write-Host "✅ Database exported to latest_db.sql successfully." -ForegroundColor Green
