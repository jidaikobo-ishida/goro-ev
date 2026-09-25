<?php
defined( 'ABSPATH' ) || exit;

/**
 * 個別リダイレクト
 */
add_action(
	'template_redirect',
	function()
	{
		global $post;
		if ( ! isset($post->ID)) return;
		$metas = get_post_meta($post->ID);
		if (is_single() && (isset($metas['url'][0]) && ! empty($metas['url'][0])))
		{
			wp_safe_redirect($metas['url'][0]);
			exit();
		}

		// attachment
		if (is_single() && $post->post_type == 'attachment')
		{
			wp_safe_redirect(home_url());
			exit();
		}
	}
);

/**
 * 本文／表題／カスタムフィールドの値を保存時に改変
 */
add_filter('dashi_save_post_value',
	function ($content, $post_type)
	{
    if ($post_type == 'kyoto-city')
    {
			return str_replace('、', '，', $content);
    }
    else
    {
      return $content;
    }
	},
  10,
  2
);

/**
 * 表題改変
 */
add_filter(
	'document_title_parts',
	function ($title)
	{
		return $title;
	});

add_filter(
	'document_title_separator',
	function ($sep)
	{
		$sep = '|';
		return $sep;
	});

/**
 * ログイン画面調整
 */
function custom_login_logo()
{
?>
<style>
body.login
{
	background-color: #f6f4e9;
	background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/bg.jpg);
}

.login #loginform
{
	 margin-top: 20px;
	 margin-left: 0;
	 padding: 26px 24px 46px;
	 background: #fff;
	 -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.4);
	 box-shadow: 0 1px 3px rgba(0,0,0,.4);
}

.login #login h1 a
{
	 width: 292px;
	 height: 105px;
	 background: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png) no-repeat 0 0;
	 background-size: contain;
}

.login #nav,
#login_error a
{
	 display: none;
}
</style>
<?php
}

function my_enqueue_styles() {
    $theme_dir = get_stylesheet_directory();
    $theme_uri = get_stylesheet_directory_uri();

    $path_base = '/css/common/base.css';
    wp_enqueue_style('my-base', $theme_uri . $path_base, [], filemtime($theme_dir . $path_base));

    $path_common_print = '/css/common/print.css';
    wp_enqueue_style('my-common-print', $theme_uri . $path_common_print, ['my-base'], filemtime($theme_dir . $path_common_print));

    $path_common_wp = '/css/common/wp.css';
    wp_enqueue_style('my-common-wp', $theme_uri . $path_common_wp, ['my-common-print'], filemtime($theme_dir . $path_common_wp));

    $path_layout = '/css/layout.css';
    wp_enqueue_style('my-layout', $theme_uri . $path_layout, ['my-common-wp'], filemtime($theme_dir . $path_layout));

    $path_wp = '/css/wp.css';
    wp_enqueue_style('my-wp', $theme_uri . $path_wp, ['my-layout'], filemtime($theme_dir . $path_wp));

    $path_print = '/css/print.css';
    wp_enqueue_style('my-print', $theme_uri . $path_print, ['my-wp'], filemtime($theme_dir . $path_print));

    wp_enqueue_style('my-main-style', get_stylesheet_uri(), ['my-print'], filemtime($theme_dir . '/style.css'));
}
add_action('wp_enqueue_scripts', 'my_enqueue_styles');

/**
 * 主要固定ページ（ヘッダーメニュー・トップページ共通）の情報取得
 *
 * @param array|null $slugs 取得対象スラッグ配列（null時は全6件）
 * @return array ページ情報の配列
 */
function goro_get_main_pages($slugs = null)
{
    static $cached_pages = null;

    if ($cached_pages === null) {
        $all_slugs = array('move', 'view', 'virtual', 'shop', 'explore', 'access', 'media');
        $cached_pages = array();

        foreach ($all_slugs as $slug) {
            $page_obj = get_page_by_path($slug);
            if ($page_obj) {
                $page_id = $page_obj->ID;
                $cf_menu_title = get_post_meta($page_id, 'menu_title', true);
                $menu_title = (!empty($cf_menu_title) || $cf_menu_title === '0') ? $cf_menu_title : get_the_title($page_id);

                $cached_pages[$slug] = array(
                    'id'             => $page_id,
                    'slug'           => $slug,
                    'pagename_upper' => strtoupper($slug),
                    'title'          => get_the_title($page_id),
                    'menu_title'     => $menu_title,
                    'link'           => get_permalink($page_id),
                    'excerpt'        => has_excerpt($page_id) ? get_the_excerpt($page_id) : wp_trim_words(strip_tags($page_obj->post_content), 100),
                    'has_thumbnail'  => has_post_thumbnail($page_id),
                    'post_object'    => $page_obj,
                );
            }
        }
    }

    if ($slugs === null) {
        return $cached_pages;
    }

    $result = array();
    foreach ($slugs as $slug) {
        if (isset($cached_pages[$slug])) {
            $result[$slug] = $cached_pages[$slug];
        }
    }
    return $result;
}

/**
 * 下層ページ用のメインビジュアル見出し情報（slug, title）を取得
 *
 * @return array|null array('slug' => '...', 'title' => '...')
 */
function goro_get_page_header_info()
{
    if (is_front_page() || is_home()) {
        return null;
    }

    $slug = '';
    $title = '';

    if (is_page()) {
        global $post;
        $slug = strtoupper($post->post_name);
        $cf_menu_title = get_post_meta($post->ID, 'menu_title', true);
        $title = (!empty($cf_menu_title) || $cf_menu_title === '0') ? $cf_menu_title : get_the_title();
    } elseif (is_post_type_archive('information')) {
        $slug = 'INFORMATION';
        $title = 'お知らせ・トピックス';
    } elseif (is_single()) {
        global $post;
        if ($post->post_type === 'information') {
            $slug = 'INFORMATION';
            $title = 'お知らせ・トピックス';
        } else {
            $slug = strtoupper($post->post_type);
            $title = get_the_title();
        }
    } elseif (is_archive()) {
        $slug = 'ARCHIVE';
        $title = get_the_archive_title();
    } elseif (is_search()) {
        $slug = 'SEARCH';
        $title = '検索結果';
    } elseif (is_404()) {
        $slug = '404 NOT FOUND';
        $title = 'ページが見つかりません';
    } else {
        $slug = '';
        $title = wp_get_document_title();
    }

    return array(
        'slug'  => $slug,
        'title' => $title,
    );
}

/**
 * 外部リンク（target="_blank"）にスクリーンリーダー用の通知テキストを自動付与
 * JIS X 8341-3 達成基準 3.2.5 対応
 */
add_filter('the_content', function ($content) {
    if (empty($content) || !is_string($content)) {
        return $content;
    }

    $pattern = '/<a\s+([^>]*target=["\']_blank["\'][^>]*)>(.*?)<\/a>/is';
    return preg_replace_callback($pattern, function ($matches) {
        $attrs = $matches[1];
        $inner = $matches[2];

        // 既に通知文言が含まれている場合は二重付与しない
        if (strpos($inner, "新しいタブ") !== false || strpos($inner, "別ウィンドウ") !== false || strpos($inner, "別タブ") !== false) {
            return $matches[0];
        }

        // rel属性に noopener noreferrer がなければ追加
        if (strpos($attrs, "rel=") === false) {
            $attrs .= ' rel="noopener noreferrer"';
        }

        return "<a " . $attrs . ">" . $inner . "<span class=\"skip\">（新しいタブで開きます）</span></a>";
    }, $content);
}, 20);

