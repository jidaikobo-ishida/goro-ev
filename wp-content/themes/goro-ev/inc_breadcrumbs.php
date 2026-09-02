<p id="breadcrumbs" class="wrapper" aria-hidden="true" role="presentation">

	<?php
	// home
	if (is_home()):
		echo 'トップページ';
	else:
		echo '<a href="' . esc_url(home_url()) . '">トップページ</a>';
	endif;

	// search result
	if (is_search()) {
		echo '&nbsp;»&nbsp;' . esc_html(get_search_query()) . 'の検索結果';
	} else {
		// link to archive
		global $post;
		$post_type = get_post_type($post);
		$post_type_obj = $post_type ? get_post_type_object($post_type) : null;

		if ($post_type_obj):
			if (is_archive()):
				echo '&nbsp;»&nbsp;' . esc_html(wp_get_document_title());
			elseif ($post_type != 'page'):
				echo '&nbsp;»&nbsp;<a href="' . esc_url(get_post_type_archive_link($post_type)) . '">' . esc_html($post_type_obj->label) . '</a>';
			endif;
		endif;

		// link to parent
		if (isset($post->post_parent) && $post->post_parent != '0' && is_singular()):
			$parent = get_post($post->post_parent);
			echo '&nbsp;»&nbsp;<a href="' . esc_url(get_permalink($parent->ID)) . '">' . esc_html($parent->post_title) . '</a>';
		endif;

		// current page
		if (is_single() or is_page()):
			echo '&nbsp;»&nbsp;' . esc_html(wp_get_document_title());
		endif;
	}
	?>
</p><!--/#breadcrumbs-->