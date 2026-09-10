<?php
/**
 * Archive Information Template
 */

// get_header
get_header();
?>

<!-- #content -->
<section id="content">
	<div class="wrapper">
		<h2 class="skip">お知らせ一覧</h2>
		<?php if (have_posts()): ?>

			<ul class="flex c3">
				<?php while (have_posts()): the_post(); ?>
					<?php include('inc_cardlist.php'); ?>
				<?php endwhile; ?>
			</ul>

			<?php the_posts_pagination(); ?>

		<?php else: ?>
			<p>現在、お知らせ・トピックスはありません。</p>
		<?php endif; ?>
	</div>
</section><!-- /#content -->

<?php
// get_footer
get_footer();
