# WordPress Docker環境構築およびGit/GitHub管理計画

## 概要
Docker Composeを使用してローカル環境で手軽に動作・確認できるWordPress環境を構築します。
MacおよびWindows環境の両方でGitHubからクローンしてスムーズに起動できるようにGit設定（改行コード設定、`.gitignore`等）および環境変数設定（`.env.example`）を整備します。

---

## 主な仕様と設定値
- **サイト名**: `Goro ev station`
- **管理者ID**: `goroadmev`
- **パスワード**: `zovukqGGds2PNHEb`
- **管理者メールアドレス**: `admin@goro-ev.local`
- **Webサーバーポート**: `8080`（`http://localhost:8080` でアクセス可能）
- **データベース**: MariaDB 10.11
- **コンテナ構成**:
  - `wordpress` (WordPress最新版, Apache + PHP)
  - `db` (MariaDB 10.11)
  - `wpcli` (WordPress CLI)

---

## ファイル構成
- `docker-compose.yml`: WordPressおよびMySQLコンテナの構成定義
- `.env.example` / `.env`: データベース接続情報、WordPressポート、初期管理者情報の定義
- `init-wp.sh`: macOS / Linux用 自動インストールスクリプト
- `init-wp.ps1`: Windows PowerShell用 自動インストールスクリプト
- `.gitignore`: データベースの実データや機密ファイル（`.env`）を除外
- `.gitattributes`: 改行コードの差分事故を防ぐための `eol=lf` 設定
- `README.md`: Mac / Windows（PowerShell / WSL）での起動・停止・管理手順を解説
- `wp-content/`: カスタムテーマ・プラグイン管理用ディレクトリ
