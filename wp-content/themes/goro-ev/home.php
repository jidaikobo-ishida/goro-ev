<?php
// get_header
get_header();
?>

<section id="concept">
	<div class="wrapper">
		<?php echo do_shortcode('[get_pagepart slug=concept]'); ?>
	</div>
</section>

<section id="content">
	<h2 class="nd">GORO-EV.comのコンテンツ</h2>
	<div class="wrapper">
		<?php
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
					<h3><?php echo esc_html($item['pagename_upper']); ?><span><?php echo esc_html($item['title']); ?></span></h3>
					<p><?php echo nl2br(esc_html($item['excerpt'])); ?></p>
					<p><a href="<?php echo esc_url($item['link']); ?>">詳しく見る</a></p>
				</div>
			</div>
			<?php
		endforeach;
		?>
	</div>
</section>

<?php
$post_type = 'information';
$items = tare_get_post_stickies($post_type, 5);
if ($items):
	?>
	<section id="information">
		<div class="wrapper">
			<h2>News & Topics <span>お知らせ・トピックス</span></h2>
			<ul class="information_list">
				<?php foreach ($items as $item): ?>
					<li>
						<a href="<?php echo esc_url(get_permalink($item->ID)); ?>">
							<time class="date" datetime="<?php echo esc_attr($item->post_date); ?>"><?php echo date('Y.m.d', strtotime($item->post_date)); ?></time>
							<span class="title"><?php echo esc_html($item->post_title); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>

<section id="about">
	<div class="wrapper">
		<?php echo do_shortcode('[get_pagepart slug=about]'); ?>
	</div>
</section>

<?php
// get_footer
get_footer();
