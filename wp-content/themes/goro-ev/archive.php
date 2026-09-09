<?php
/**
 * to modify this main loop, see functions/pre_get_posts.php.
 */

// get_header
get_header();
?>

<!-- #content -->
<section id="content">
	<div class="wrapper">
		<div class="inner">

		<?php
				echo $posts ? "\t" . '<a href="' . esc_url(get_bloginfo('rss2_url')) . '?post_type=' . esc_attr($posts[0]->post_type) . '"><img src="' . esc_url(get_stylesheet_directory_uri()) . '/images/rss/feed-icon-14x14.png" alt="RSS"></a>' : '';

		if ($posts):

			$html = '';
			$html .= '<ul>';
			foreach ($posts as $item):
				$html .= '<li>';
				$html .= '<a href="' . esc_url(get_permalink($item->ID)) . '">';
				$html .= esc_html($item->post_title);
				$html .= '</a>';
				$html .= '</li>';
			endforeach;
			$html .= '</ul>';
			echo $html;

		endif;
		?>

		</div>
	</div>
</section><!-- /#content -->

<?php
the_posts_pagination();

// get_footer
get_footer();
