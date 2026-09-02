<?php
namespace Dashi\Posttype;

class Information extends \Dashi\Core\Posttype\Base
{
	public static function __init ()
	{
		static::set('name', 'お知らせ');
		static::set('order', 40);

		// capabilities
		// static::set('plural', 'informations');
		// static::set('capability_type', array('information', 'informations'));
		// static::set('map_meta_cap', true);

		static::set('is_use_force_ascii_slug', true);

		static::set('is_use_sticky', false);
		static::set('is_sticky_admin_only', false);

    static::set('allow_post_by_public_form', false);
		static::set('is_store_contact_number', false);
		static::set('is_store_contact_information', false);

    static::set('enter_title_here', 'イベント名');
		static::set('sitemap_depth', 0);

		static::set('allow_move_meta_boxes', false);
		static::set('hierarchical', true);
		static::set('show_in_rest', true);

		// supports
		static::set('supports', array(
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'revisions',
				'page-attributes',
			));

		// taxonomies
		// static::set('taxonomies', array(
		// 		'skelton_category' => array(
		// 			'label'        => '分野',
		// 			'public'       => true,
		// 			'show_ui'      => true,
		// 			'hierarchical' => true,
		// 		),
		// 	));

		// custom fields
		static::set('custom_fields', array(

				'information_url' => array(
					'type' => 'text',
					'label' => '転送URL',
					'description' => 'ここに書かれたアドレスに転送されます',
				),

			));
	}
}
