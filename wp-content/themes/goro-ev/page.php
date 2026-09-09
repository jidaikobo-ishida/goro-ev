<?php
// get_header
get_header();
?>

<!-- #content -->
<section id="content">
<div class="wrapper">
<div class="inner">
<?php
// echo '<p class="date">'.__('Last updated').'<time datetime="'.date('Y-m-d', strtotime($post->post_date)).'">'.date('Y年n月j日', strtotime($post->post_date)).'</time></p>';

if ( ! post_password_required($post->ID)) :
	echo apply_filters('the_content', $post->post_content);
else :
	echo get_the_password_form();
endif;
?>
</div>
</div>
</section><!-- /#content -->

<?php
// echo '<section>';
// previous_post_link();
// next_post_link();
// echo '</section>';

// get_footer
get_footer();
