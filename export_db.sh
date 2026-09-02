#!/usr/bin/env bash
set -e
echo "📦 Exporting database to latest_db.sql..."
docker compose run --rm wpcli wp db export latest_db.sql
docker compose cp wordpress:/var/www/html/latest_db.sql ./latest_db.sql
echo "✅ Database exported to latest_db.sql successfully."
