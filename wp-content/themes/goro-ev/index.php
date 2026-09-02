<?php
// get_header
get_header();
?>

<!-- #content -->
<section id="content">
<div class="wrapper">

<?php
// h1
echo '<h1>'.esc_html(wp_get_document_title()).'</h1>';

if ($posts):
?>

<ul>
	<?php
	foreach ($posts as $item):
	?>
	<li><a href="<?php echo esc_url(get_permalink($item->ID)); ?>"><?php echo esc_html($item->post_title); ?></a> <span class="date">(<?php echo esc_html($item->post_date); ?>)</span></li>
	<?php
	endforeach;
	?>
</ul>

<?php endif; ?>

</div>
</section><!-- /#content -->

<?php
// use main loop
the_posts_pagination();

// get_footer
get_footer();
