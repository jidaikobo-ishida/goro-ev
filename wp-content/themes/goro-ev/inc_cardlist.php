<?php
/**
 * 汎用カードアイテム コンポーネント
 *
 * ループ内（have_posts()）、または $item（WP_Post）が渡された場合の双方に対応
 */
$post_id    = isset($item) ? $item->ID : get_the_ID();
$post_type  = isset($item) ? $item->post_type : get_post_type($post_id);
$post_date  = isset($item) ? $item->post_date : get_the_date('c', $post_id);
$post_title = isset($item) ? $item->post_title : get_the_title($post_id);
$permalink  = isset($item) ? get_permalink($item->ID) : get_permalink($post_id);
$has_thumb  = has_post_thumbnail($post_id);
?>
<li class="card-item card-<?php echo esc_attr($post_type); ?>">
	<a href="<?php echo esc_url($permalink); ?>">
		<div class="thumbnail">
			<?php if ($has_thumb): ?>
				<?php echo get_the_post_thumbnail($post_id, 'medium'); ?>
			<?php else: ?>
				<div class="noimage">イメージ</div>
			<?php endif; ?>
		</div>
		<div class="card-body">
			<time class="date" datetime="<?php echo esc_attr($post_date); ?>"><?php echo date('Y年m月d日更新', strtotime($post_date)); ?></time>
			<h3 class="card-title"><?php echo esc_html($post_title); ?></h3>
			<span class="card-arrow" aria-hidden="true">&rarr;</span>
		</div>
	</a>
</li>
