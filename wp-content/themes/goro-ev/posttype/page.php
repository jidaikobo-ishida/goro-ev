<?php
namespace Dashi\Posttype;

class Page extends \Dashi\Core\Posttype\Base
{
	public static function __init ()
	{
		static::set('name', '固定ページ');

		// custom fields
		static::set('custom_fields', array(
			'menu_title' => array(
				'type' => 'text',
				'label' => 'メニュー用タイトル',
				'description' => '',
			),
		));
	}
}
