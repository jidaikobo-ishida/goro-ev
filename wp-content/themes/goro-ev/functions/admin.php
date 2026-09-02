<?php
defined( 'ABSPATH' ) || exit;

/*
 * 管理画面向け注意書き
 */
add_action(
	'admin_notices',
	function ()
	{
		if ( ! is_admin()) return;
		//	echo '<div class="notice notice-info is-dismissible"><p></p></div>';
	}
);

/*
 * 管理画面から取り除く項目
 */
add_action(
	'admin_menu',
	function ()
	{
		//	remove_menu_page('edit.php?post_type=page'); // 固定ページ
		remove_menu_page('edit.php'); // 投稿
		remove_menu_page('edit-comments.php'); // comments
	}
);

/*
 * 管理バーから取り除く項目
 */
add_action(
	'admin_bar_menu',
	function ($wp_admin_bar)
	{
		$wp_admin_bar->remove_menu('wp-logo'); // W ロゴ
		$wp_admin_bar->remove_menu('comments'); // コメント
		$wp_admin_bar->remove_menu('new-post'); // 新規 -> 投稿
		$wp_admin_bar->remove_menu('new-media'); // 新規 -> メディア
		$wp_admin_bar->remove_menu('new-page'); // 新規 -> 固定ページ
		$wp_admin_bar->remove_menu('new-user'); // 新規 -> ユーザー
		$wp_admin_bar->remove_menu('customize'); //カスタマイズ
	},
	201
);

/*
 * ダッシュボードから取り除く項目
 */
add_action(
	'wp_dashboard_setup',
	function ()
	{
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

		// SEO最新情報
		if (isset($wp_meta_boxes['dashboard']['normal']['core']['semperplugins-rss-feed']))
		{
			unset($wp_meta_boxes['dashboard']['normal']['core']['semperplugins-rss-feed']);
		}
	}
);
