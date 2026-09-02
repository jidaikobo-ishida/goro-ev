<?php
defined( 'ABSPATH' ) || exit;

function my_pre_get_posts($query)
{
	if (is_admin() || ! $query->is_main_query()) return;

	 	$query->set('orderby', 'menu_order');
	 	$query->set('order', 'ASC');
	 	$query->set('posts_per_page', 30);

	// archive.php
	// if ($query->is_post_type_archive('project'))
	// {
	// 	$query->set('orderby', 'menu_order');
	// 	$query->set('order', 'ASC');
	// 	$query->set('posts_per_page', 30);
	// }

	// 検索結果
	// if($query->is_search())
	// {
	// 	$query -> set('post_type', array('articles'));
	// }

	// 複数のpost_type
	// $query->set('post_type', array('material', 'lecture'));

	// meta_key
	// $query->set('meta_key', 'foo');
	// $query->set('meta_value', 2);

	// meta_query
	// $meta_query = array(
	// 	'relation' => 'OR',
	// 	array(
	// 		'key'     => 'lecture_type',
	// 		'value'   => '2',
	// 		'compare' => '!=',
	// 	),
	// 	array(
	// 		'key'     => 'material_get_is_free',
	// 		'value'   => '10',
	// 		'compare' => '<',
	// 		'type'    => 'numeric',
	// 	),
	// );
	// $query->set('meta_query', $meta_query);

	// taxonomy
	// if (is_tax())
	// {
	// 	$query->set('tax_query', array(
	// 			'relation' => 'OR',
	// 			array(
	// 				'taxonomy' => 'foo_category',
	// 				'field'    => 'slug',
	// 				'terms'    => array('foo'),
	// 			)
	// 		));
	// }
}
add_action('pre_get_posts','my_pre_get_posts');
