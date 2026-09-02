# WordPressテーマ「tare」セキュリティチェック・修正計画

WordPressベーステーマ「tare」のセキュリティ監査を行い、発見された脆弱性（主にXSS）の修正およびセキュリティ強化を提案します。

## ユーザーレビューが必要な項目

> [!IMPORTANT]
> セキュリティ強化のため、テンプレートファイル内の多数の箇所でエスケープ関数（`esc_html`, `esc_url`, `esc_attr`）を追加します。これにより表示に影響が出ることは稀ですが、意図的にHTMLタグを許可している箇所がある場合は注意が必要です。

## 発見された主な問題点

1. **反射型XSS (Reflected XSS)**:
   - 検索フォーム（`inc_searchform.php`）で、検索クエリ（`get_search_query()`）が属性値（`value`）として出力される際に適切なエスケープ（`esc_attr`）が不足しています。
2. **メタタグ注入 / ホストヘッダー攻撃のリスク**:
   - `header.php` で `$_SERVER["HTTP_HOST"]` をそのまま使用して `canonical` リンクを生成しています。これは偽装されたホストヘッダーによる意図しないURLの出力に繋がる可能性があります。
3. **広範囲なエスケープの不足**:
   - `home_url()`, `get_permalink()`, `get_bloginfo('name')`, ポストタイトルなどが、テンプレートの各所でエスケープされずに出力されています。これらは悪意のあるプラグインや設定、古いDBコンテンツからXSSを誘発する可能性があります。

---

## 提案される変更内容

### 1. テンプレートファイルのエスケープ強化

以下のファイルの `echo` 出力箇所に適切なエスケープ関数を適用します。

#### [MODIFY] [header.php](file:///Users/admin/.gemini/antigravity/playground/tare/header.php)
- `canonical` リンクの生成方法を `wp_get_canonical_url()` または適切なエスケープ処理に変更。
- `home_url()` への `esc_url()` 適用。
- `bloginfo('name')` の出力を `esc_html(get_bloginfo('name'))` 相当に変更。

#### [MODIFY] [inc_searchform.php](file:///Users/admin/.gemini/antigravity/playground/tare/inc_searchform.php)
- `get_search_query()` に `esc_attr()` を適用。
- `home_url()` に `esc_url()` を適用。

#### [MODIFY] [inc_breadcrumbs.php](file:///Users/admin/.gemini/antigravity/playground/tare/inc_breadcrumbs.php)
- パンくずリスト内のリンク（`get_permalink`, `get_post_type_archive_link`）に `esc_url()` を適用。
- タイトルやラベル（`$post_type_obj->label`, `$parent->post_title`）に `esc_html()` を適用。

#### [MODIFY] [home.php](file:///Users/admin/.gemini/antigravity/playground/tare/home.php)
- ニュース一覧などの出力において、リンクや属性値（`alt`等）のエスケープを徹底。

#### [MODIFY] [page.php](file:///Users/admin/.gemini/antigravity/playground/tare/page.php) & [single.php](file:///Users/admin/.gemini/antigravity/playground/tare/single.php)
- タイトル出力箇所の `echo` に `esc_html()` を適用。

### 2. OGPタグの修正

#### [MODIFY] [ogp_twitter.php](file:///Users/admin/.gemini/antigravity/playground/tare/functions/ogp_twitter.php)
- 残っている生出力箇所（`$ogp_type`, `$twitter`, `$app_id`）にエスケープ処理を追加。

---

## オープンな質問

> [!NOTE]
> `canonical` URLの生成について、現在は `$_SERVER` 変数から自作していますが、WordPress標準の `rel_canonical()` や `wp_get_canonical_url()` を使用する形に変更してもよろしいでしょうか？（より安全で標準的な方法です）

## 検証プラン

### 手動検証
1. 検索フォームに `<script>alert(1)</script>` などの文字列を入力し、ソースコード上で適切にエスケープされているか確認。
2. 各ページ（トップ、固定ページ、投稿、アーカイブ）のHTMLソースを表示し、`href` 属性やメタタグが正しく出力されているか確認。
3. OGPタグが正しくレンダリングされているか確認。
