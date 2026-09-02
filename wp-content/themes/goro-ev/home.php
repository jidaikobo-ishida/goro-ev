<?php
// get_header
get_header();
?>

<!-- #content -->
<section id="content">
	<div class="wrapper">
	<?php

	// get parts (GORO EV STATION について)
	echo do_shortcode('[get_pagepart slug=intro]');

	// 各固定ページの紹介ボックス (move, view, virtual, shop, explore)
	$top_slugs = array('move', 'view', 'virtual', 'shop', 'explore');
	foreach (goro_get_main_pages($top_slugs) as $item) :
		?>
		<div class="contentbox">
			<div class="imgbox">
				<?php if ($item['has_thumbnail']) : ?>
					<?php echo get_the_post_thumbnail($item['id'], 'large', array('alt' => esc_attr($item['title']))); ?>
				<?php else : ?>
					<img src="ファイル名：<?php echo esc_attr($item['slug']); ?>_thumbとしてください。数字でもいいです。" alt="<?php echo esc_attr($item['title']); ?>">
				<?php endif; ?>
			</div>
			<div class="txtbox">
				<h3><?php echo esc_html($item['pagename_upper'] . '：' . $item['title']); ?></h3>
				<p><?php echo nl2br(esc_html($item['excerpt'])); ?></p>
				<p><a href="<?php echo esc_url($item['link']); ?>">詳しく見る</a></p>
			</div>
		</div>
		<?php
	endforeach;

	// get stickies - see functions/common.php
	$post_type = 'information';
	$items = tare_get_post_stickies($post_type, 5);
	if ($items):
		?>

		<h2>お知らせ・トピックス</h2>
		<?php
		$html = '';
		$html .= '<ul class="information_list">';
		foreach ($items as $item):
			$html .= '<li>';
			$html .= '<a href="' . esc_url(get_permalink($item->ID)) . '">';
			$html .= '<time class="date" datetime="' . esc_attr($item->post_date) . '">' . date('Y.m.d', strtotime($item->post_date)) . '</time>';
			$html .= '<span class="title">' . esc_html($item->post_title) . '</span>';
			$html .= '</a>';
			$html .= '</li>';
		endforeach;
		$html .= '</ul>';
		echo $html;
		?>

	<?php endif; ?>
	</div>
</section><!-- /#content -->

<?php
// get_footer
get_footer();
