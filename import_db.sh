#!/usr/bin/env bash
set -e
if [ ! -f latest_db.sql ]; then
  echo "❌ latest_db.sql not found."
  exit 1
fi
echo "📥 Importing latest_db.sql into database..."
docker compose cp ./latest_db.sql wordpress:/var/www/html/latest_db.sql
docker compose run --rm wpcli wp db import latest_db.sql
docker compose exec wordpress rm -f /var/www/html/latest_db.sql
docker compose run --rm wpcli wp rewrite flush --hard || true
echo "✅ Database imported successfully."
