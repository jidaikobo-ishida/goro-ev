<?php
defined( 'ABSPATH' ) || exit;

/**
 * 原則、このファイルは編集しないでください。
 * サイト固有の設定についてはmain.phpおよびadmin.phpを編集してください。
 */

/**
 * Stickyと混ぜて記事を取得する
 */
function tare_get_post_stickies($post_type, $max = 0)
{
	$sticky_posts = get_option('sticky_posts');

	$items = array();
	if ($sticky_posts) {
		$args  = array(
			'post_type' => $post_type,
			'post__in'  => $sticky_posts,
		);
		$query = new WP_Query($args);
		$items = $query->posts;
	}

	// get not stickies
	$args  = array(
		'post_type'    => $post_type,
		'post__not_in' => $sticky_posts,
	);
	$query = new WP_Query($args);
	$items = array_merge($items, $query->posts);

	// top hits
	$max = $max == 0 ? get_option('posts_per_page') : $max ;
	return array_slice($items, 0, $max);
}

/**
 * JavaScriptのtypeを消す
 */
add_filter(
	'script_loader_tag',
	function ($tag)
	{
		return str_replace(
			array(
				"type='text/javascript' ",
				"type='text/javascript'>",
				'type="text/javascript" ',
				'type="text/javascript">',
			),
			// array(
			// 	"async='async' ",
			// 	">",
			// 	'async="async" ',
			// 	">",
			// ),
			array(
				"",
				">",
				'',
				">",
			),
			$tag);
	}
);

/**
 * headから不要な項目を取り除く
 */
remove_action('wp_head', 'wp_generator'); // WordPress version
remove_action('wp_head', 'rsd_link'); // xmlrpc
remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

/**
 * add_filter
 */
add_filter('the_content', 'make_clickable');

/**
 * add_theme_support()
 */

// render title by wp_head()
add_theme_support('title-tag');

// use eye-catch
add_theme_support('post-thumbnails');

// theme support for html5 markup
add_theme_support('html5', array(
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption'
));

/**
 * 編集画面でのCSS適用
 */
// add_editor_style(array('editor-style.css', 'css/layout.css'));

/**
 * JavaScriptとCSSの追加
 */
add_action(
	'wp_enqueue_scripts',
	function ()
	{
		$theme_dir = get_stylesheet_directory();
		$theme_uri = get_stylesheet_directory_uri();

		$path_common_jquery = '/js/common/jquery.inc.js';
		wp_enqueue_script(
			'tare-common-jquery-inc',
			$theme_uri . $path_common_jquery,
			array('jquery'),
			filemtime($theme_dir . $path_common_jquery)
		);

		$path_jquery = '/js/jquery.inc.js';
		wp_enqueue_script(
			'tare-jquery-inc',
			$theme_uri . $path_jquery,
			array('jquery'),
			filemtime($theme_dir . $path_jquery)
		);
	}
);

add_action(
	'admin_enqueue_scripts',
	function ()
	{
		$theme_dir = get_stylesheet_directory();
		$theme_uri = get_stylesheet_directory_uri();

		$path_common_admin_css = '/css/common/admin.css';
		wp_enqueue_style(
			'tare-common-admin-css',
			$theme_uri . $path_common_admin_css,
			array(),
			filemtime($theme_dir . $path_common_admin_css)
		);

		$path_admin_css = '/css/admin.css';
		wp_enqueue_style(
			'tare-admin-css',
			$theme_uri . $path_admin_css,
			array(),
			filemtime($theme_dir . $path_admin_css)
		);

		// $path_layout_css = '/css/layout.css';
		// wp_enqueue_style(
		// 	'tare-admin-layout-css',
		// 	$theme_uri . $path_layout_css,
		// 	array(),
		// 	filemtime($theme_dir . $path_layout_css)
		// );

		$path_common_admin_js = '/js/common/jquery.inc.admin.js';
		wp_enqueue_script(
			'tare-common-jquery-inc-admin',
			$theme_uri . $path_common_admin_js,
			array('jquery'),
			filemtime($theme_dir . $path_common_admin_js)
		);

		$path_admin_js = '/js/jquery.inc.admin.js';
		wp_enqueue_script(
			'tare-jquery-inc-admin',
			$theme_uri . $path_admin_js,
			array('jquery'),
			filemtime($theme_dir . $path_admin_js)
		);
	});

/**
 * for h1
 */
add_filter(
	'document_title_parts',
	function ($title)
	{
		if( ! doing_action('wp_head'))
		{
			$title['tagline'] = '';
			$title['site'] = '';
		}

		if (isset($_GET['preview']))
		{
			$title['tagline'] = __('Preview');
		}
		return $title;
	}
);

/**
 * 管理者向けにtitleに投稿の状態を追加
 */
add_filter(
	'document_title_parts',
	function ($title, $post_status = null)
	{
		if (is_user_logged_in() && ! doing_action('wp_head'))
		{
			if ( ! $post_status)
			{
				global $post;
				$post_status = isset($post->post_status) ? $post->post_status : '';
			}
			if (is_singular() && $post_status != 'publish' && $post_status)
			{
				$post_status_arr = array(
					'private' => '【非公開記事】',
					'future' => '【予約記事】',
					'draft' => '【下書き】'
				);
				$title['title'].= $post_status_arr[$post_status];
			}
		}
		return $title;
	}
);

/*
 * TinyMCEのtable幅設定を無効に
 * https://masshiro.blog/tinymce-table-resize/
 */
add_filter(
	'tiny_mce_before_init',
	function ($mceInit)
	{
		$mceInit['table_resize_bars'] = false;
		$mceInit['object_resizing'] = "img";
		return $mceInit;
	},
	0
);

/**
 * wrapper get_the_posts_pagination and the_posts_pagination
 */
if (
	! function_exists('my_get_the_posts_pagination') &&
	! function_exists('my_the_posts_pagination')
)
{
	function my_get_the_posts_pagination (WP_Query $wp_query_obj, $args = array())
	{
		$tmp_obj = $GLOBALS['wp_query'];
		$GLOBALS['wp_query'] = $wp_query_obj;
		$navigation = get_the_posts_pagination($args);
		$GLOBALS['wp_query'] = $tmp_obj;
		return $navigation;
	}

	function my_the_posts_pagination (WP_Query $wp_query_obj, $args = array())
	{
		echo my_get_the_posts_pagination($wp_query_obj, $args);
	}
}
