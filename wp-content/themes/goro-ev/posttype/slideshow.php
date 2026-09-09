<?php
namespace Dashi\Posttype;

class Slideshow extends \Dashi\Core\Posttype\Base
{
	public static function __init ()
	{
		static::set('name', 'スライドショー');
		static::set('order', 30);

		static::set('is_use_force_ascii_slug', true);

		static::set('is_use_sticky', false);
		static::set('is_sticky_admin_only', false);

		static::set('allow_post_by_public_form', false);
		static::set('is_store_contact_number', false);
		static::set('is_store_contact_information', false);

		static::set('enter_title_here', 'スライド管理用タイトル（例：スライド1など）');
		static::set('sitemap_depth', 0);

		static::set('allow_move_meta_boxes', false);
		static::set('hierarchical', false);
		static::set('show_in_rest', true);

		// supports: 本文(editor)やexcerptは不要。titleとmenu_order(page-attributes)を有効に
		static::set('supports', array(
			'title',
			'page-attributes',
		));

		// custom fields: 画像アップロードとリンクURL入力欄
		static::set('custom_fields', array(
			'slide_image' => array(
				'type' => 'file',
				'label' => 'スライド画像',
				'description' => 'スライド画像をアップロードしてください。',
			),
			'slide_url' => array(
				'type' => 'text',
				'label' => 'リンク先URL',
				'description' => 'クリック時のリンク先URLがある場合に入力してください。',
			),
		));
	}
}
