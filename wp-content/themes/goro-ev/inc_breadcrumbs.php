<p id="breadcrumbs" class="wrapper" aria-hidden="true" role="presentation">

	<?php
	$sep = '&nbsp;&gt;&nbsp;';

	// home
	if (is_front_page() || is_home()):
		echo 'トップページ';
	else:
		echo '<a href="' . esc_url(home_url('/')) . '">トップページ</a>';

		// search result
		if (is_search()) {
			echo $sep . esc_html(get_search_query()) . 'の検索結果';
		} elseif (is_page()) {
			global $post;
			$slug_upper = strtoupper($post->post_name);
			$page_title = get_the_title($post->ID);

			// 親ページがある場合
			if (isset($post->post_parent) && $post->post_parent != '0') {
				$parent = get_post($post->post_parent);
				$parent_slug = strtoupper($parent->post_name);
				$parent_title = get_the_title($parent->ID);
				echo $sep . '<a href="' . esc_url(get_permalink($parent->ID)) . '">' . esc_html($parent_slug) . '（' . esc_html($parent_title) . '）</a>';
			}

			echo $sep . esc_html($slug_upper) . '（' . esc_html($page_title) . '）';
		} elseif (is_post_type_archive('information')) {
			echo $sep . 'INFORMATION（お知らせ・トピックス）';
		} elseif (is_singular('information')) {
			echo $sep . '<a href="' . esc_url(get_post_type_archive_link('information')) . '">INFORMATION（お知らせ・トピックス）</a>';
			echo $sep . esc_html(get_the_title());
		} elseif (is_single()) {
			global $post;
			$post_type = get_post_type($post);
			$post_type_obj = get_post_type_object($post_type);
			if ($post_type_obj && $post_type !== 'post') {
				echo $sep . '<a href="' . esc_url(get_post_type_archive_link($post_type)) . '">' . esc_html($post_type_obj->label) . '</a>';
			}
			echo $sep . esc_html(get_the_title());
		} elseif (is_archive()) {
			echo $sep . esc_html(get_the_archive_title());
		} elseif (is_404()) {
			echo $sep . 'ページが見つかりません';
		} else {
			echo $sep . esc_html(wp_get_document_title());
		}
	endif;
	?>
</p><!--/#breadcrumbs-->
