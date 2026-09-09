<?php
/**
 * スライドショー投稿タイプでタイトルが空の場合に自動補完する
 */
add_filter('wp_insert_post_data', function ($data, $postarr) {
	if (isset($data['post_type']) && $data['post_type'] === 'slideshow') {
		// タイトルが空、または空白のみの場合
		if (empty(trim((string)$data['post_title']))) {
			$img = isset($_POST['slide_image']) ? sanitize_text_field($_POST['slide_image']) : '';
			$alt = '';

			if (!empty($img)) {
				$att_id = attachment_url_to_postid($img);
				if ($att_id) {
					$alt = get_post_meta($att_id, '_wp_attachment_image_alt', true);
				}
			}

			if (!empty($alt)) {
				$data['post_title'] = $alt;
			} elseif (!empty($img)) {
				$data['post_title'] = basename(parse_url($img, PHP_URL_PATH));
			} else {
				$data['post_title'] = 'スライド（' . date('Y-m-d H:i') . '）';
			}
		}
	}
	return $data;
}, 10, 2);

/**
 * メディアアップローダー用iframe（media-upload.php）にも管理者CSSを適用
 */
add_action('admin_print_styles-media-upload-popup', function () {
	wp_enqueue_style(
		'tare-admin-css-popup',
		get_theme_file_uri('css/admin.css'),
		array(),
		filemtime(get_theme_file_path('css/admin.css'))
	);
});
