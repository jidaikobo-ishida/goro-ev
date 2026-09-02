<?php
defined( 'ABSPATH' ) || exit;

/**
 * ブロック用JS読み込み
 */
add_action(
	'init',
	function ()
	{
		wp_enqueue_script(
			'tare-block-editor-js',
			get_theme_file_uri('/js/block_editor.js'),
			[
				'wp-blocks',
				'wp-element',
				'wp-components',
				'wp-block-editor',
			]
		);

		//ブロックタイプの登録
		register_block_type(
			// "namespace/blockname"
			'tare-blocks/tare-sample-block',
			[
				'editor_script' => 'tare-block-editor-js',
			]
		);
	}
);
