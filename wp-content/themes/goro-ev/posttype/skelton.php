<?php
namespace Dashi\Posttype;

class Skelton extends \Dashi\Core\Posttype\Base
{
	public static function __init ()
	{
		static::set('name', 'リネーム用骨組み');
		static::set('order', 40);

		// capabilities
		// static::set('plural', 'events');
		// static::set('capability_type', array('event', 'events'));
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

				'genre' => array(
					'type' => 'radio',
					'label' => '種別',
					'description' => '',
					'options' => array(
						0 => '告知',
						1 => '報告',
					),
					'add_column' => 1,
					'add_restriction' => true,
					'value' => 2,
					'attrs' => array(
						'required' => 'required',
						'cols' => 50,
						'rows' => 5,
					)
				),

				'url' => array(
					'type' => 'text',
					'label' => '転送URL',
					'description' => 'ここに書かれたアドレスに転送されます',
				),

				'event_file' => array(
					'label' => 'ファイル',
					'description' => '説明テキストを入れてね。',
					'duplicate' => true,
					'fields' => array(
						'file_path' => array(
							'type' => 'file',
							'label' => 'ファイル',
							'description' => '',
							'attrs' => array(),
							'validations' => array(
								'url',
							),
							'filters' => array(
								'trim',
							),
						)
					)
				),

				'event_date' => array(
					'type' => 'text',
					'label' => '開始日',
					'description' => '',
					'filters' => array(
					),
          'validations' => array(
//            'Mailaddress',
//            'Sb',
//            'Alnum',
//            'Alnumplus',
//            'Alnumfilename',
//            'Image',
//            'Katakana',
//            'Hiragana',
//            'Uploadable',
          ),
					'attrs' => array(
						'required' => 'required',
						'class' => 'datetime dashi_datetimepicker',
						'data-dashi_timeformat' => 'HH:mm',
						'data-dashi_stepminute' => '15',
					)
				),

/*
				'attachment_image'   => array(
          'label'       => '添付画像',
					'context'  => 'side',
					'priority' => 'low',
          'callback'    => array('\\Dashi\\Posttype\\Lecture', 'attachment_images'),
				),
				'attachment_images_hidden'   => array(
          'type'    => 'hidden',
				),
*/

			));
	}
}
