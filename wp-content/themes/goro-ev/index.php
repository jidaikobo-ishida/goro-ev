<?php
// get_header
get_header();
?>

<!-- #content -->
<section id="content">
<div class="wrapper">
<div class="inner">

<?php

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
</div>
</section><!-- /#content -->

<?php
// use main loop
the_posts_pagination();

// get_footer
get_footer();
