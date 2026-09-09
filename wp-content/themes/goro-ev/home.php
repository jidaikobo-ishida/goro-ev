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
		$count = 1;
		foreach (goro_get_main_pages($top_slugs) as $item) :
			$img_url = get_theme_file_uri('images/top_content' . $count . '.png');
			$count++;
			?>
			<div class="contentbox">
				<div class="imgbox">
					<img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($item['title']); ?>">
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
$items = tare_get_post_stickies($post_type, 3);
if ($items):
	?>
	<section id="information">
		<div class="wrapper">
			<h2>News & Topics <span>お知らせ・トピックス</span></h2>
			<ul class="flex c3">
				<?php foreach ($items as $item): ?>
					<?php include('inc_cardlist.php'); ?>
				<?php endforeach; ?>
			</ul>
			<p class="more-link">
				<a href="<?php echo esc_url(get_post_type_archive_link('information')); ?>" class="btn-more">お知らせの一覧を見る <span class="arrow">&gt;</span></a>
			</p>
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
