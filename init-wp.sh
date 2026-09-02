#!/usr/bin/env bash
set -e

# .envが存在しない場合は.env.exampleからコピー
if [ ! -f .env ]; then
  echo "📄 .env not found. Copying from .env.example..."
  cp .env.example .env
fi

# 環境変数の読み込み
set -a
source .env
set +a

echo "🚀 Starting WordPress Docker containers..."
docker compose up -d

echo "⏳ Waiting for Database to be ready..."
until docker compose run --rm wpcli wp db check > /dev/null 2>&1; do
  echo "  Waiting for DB connection..."
  sleep 3
done

echo "🔍 Checking WordPress installation status..."
if docker compose run --rm wpcli wp core is-installed > /dev/null 2>&1; then
  echo "✅ WordPress is already installed."
else
  if [ -f latest_db.sql ]; then
    echo "📥 Found latest_db.sql. Importing database dump..."
    docker compose cp ./latest_db.sql wordpress:/var/www/html/latest_db.sql
    docker compose run --rm wpcli wp db import latest_db.sql
    docker compose exec wordpress rm -f /var/www/html/latest_db.sql
    docker compose run --rm wpcli wp rewrite flush --hard || true
    echo "✅ Database restored from latest_db.sql."
  else
    echo "⚙️ Installing clean WordPress..."
    docker compose run --rm wpcli wp core install \
      --url="${WP_URL:-http://localhost:8080}" \
      --title="${WP_TITLE:-Goro ev station}" \
      --admin_user="${WP_ADMIN_USER:-goroadmev}" \
      --admin_password="${WP_ADMIN_PASSWORD:-zovukqGGds2PNHEb}" \
      --admin_email="${WP_ADMIN_EMAIL:-admin@goro-ev.local}" \
      --skip-email

    echo "🌐 Setting site language to Japanese (ja)..."
    docker compose run --rm wpcli wp language core install ja || true
    docker compose run --rm wpcli wp site switch-language ja || true
  fi

  echo "=================================================="
  echo "🎉 WordPress setup completed successfully!"
  echo "Site URL    : ${WP_URL:-http://localhost:8080}"
  echo "Admin URL   : ${WP_URL:-http://localhost:8080}/login_00731"
  echo "Username    : ${WP_ADMIN_USER:-goroadmev}"
  echo "Password    : ${WP_ADMIN_PASSWORD:-zovukqGGds2PNHEb}"
  echo "=================================================="
fi
