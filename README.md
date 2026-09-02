# Goro ev station - WordPress Docker 開発環境

Docker Compose を利用した WordPress 開発環境です。  
Mac および Windows (PowerShell / WSL2) の両環境で完全に同じ状態で共同作業ができるように設計されています。

---

## 🚀 クイックスタート（Windows / Mac 共通）

### 前提条件
- **Docker Desktop** がインストールされ、起動していること
- **Git** がインストールされていること

---

### 1. リポジトリのクローン
```bash
git clone <GitHubのリポジトリURL> goro-ev
cd goro-ev
```

---

### 2. 環境の起動とセットアップ

#### 🪟 Windows (PowerShell) の場合
```powershell
# スクリプト実行ポリシーを一時的に許可して実行
Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass
.\init-wp.ps1
```

#### 🍎 macOS / Linux の場合
```bash
./init-wp.sh
```

※ 初回起動時に `latest_db.sql`（データベース状態）が自動インポートされ、すべての固定ページ・プラグイン設定・テーマが即座に復元されます。

---

### 3. アクセス確認

- **サイトトップ**: [http://localhost:8080](http://localhost:8080)
- **管理画面ログイン**: [http://localhost:8080/login_00731](http://localhost:8080/login_00731)
  *(SiteGuardセキュリティプラグインによりログインURLが保護されています)*

#### ログイン情報
| 項目 | 設定値 |
|---|---|
| **サイト名** | Goro ev station |
| **ユーザー名 (ID)** | `goroadmev` |
| **パスワード** | `zovukqGGds2PNHEb` |

---

## 🔄 共同作業時のGit & DB同期フロー

テーマファイルやコードの変更だけでなく、**管理画面でページを追加・変更したデータ（DB）も簡単に同期**できます。

### 【変更をGitHubに送るとき】（作業完了時）
```bash
# 1. 最新のデータベース状態を latest_db.sql に書き出す
# Macの場合:
./export_db.sh
# Windows (PowerShell) の場合:
.\export_db.ps1

# 2. GitでコミットしてGitHubへプッシュ
git add .
git commit -m "update: テーマ修正およびコンテンツ更新"
git push origin main
```

### 【他の端末で最新状態を取り込むとき】（作業開始時）
```bash
# 1. GitHubから最新コード・DBを取得
git pull origin main

# 2. 最新のDB状態をコンテナに反映
# Macの場合:
./import_db.sh
# Windows (PowerShell) の場合:
.\import_db.ps1
```

---

## 🛠️ 日常の操作コマンド

### コンテナの起動・停止
```bash
# 起動（バックグラウンド）
docker compose up -d

# 停止
docker compose stop

# コンテナ削除（※DBデータは保持されます）
docker compose down
```

---

## 📁 ディレクトリ構成
```
.
├── .env.example          # 環境変数のテンプレート
├── .gitattributes        # 改行コード(LF)の正規化設定
├── .gitignore            # Git除外設定
├── docker-compose.yml    # コンテナ定義 (WordPress / MariaDB / WP-CLI)
├── init-wp.sh / .ps1     # 初回セットアップスクリプト (Mac / Win)
├── export_db.sh / .ps1   # DBエクスポートスクリプト (Mac / Win)
├── import_db.sh / .ps1   # DBインポートスクリプト (Mac / Win)
├── latest_db.sql         # 共有用データベースダンプ
├── README.md             # 本ドキュメント
├── wp-content/           # テーマ・プラグインのソースコード管理ディレクトリ
│   ├── themes/goro-ev/   # 自作テーマ
│   └── plugins/          # プラグイン一式
└── docs/                 # 仕様書・ドキュメント類
```
