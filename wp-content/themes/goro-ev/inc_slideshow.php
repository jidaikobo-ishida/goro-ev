<?php
/**
 * Mainvisual Slideshow Template
 */
$slides = get_posts(array(
	'post_type'      => 'slideshow',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'post_status'    => 'publish',
));

if (!empty($slides)):
	$slide_items = array();

	foreach ($slides as $slide) {
		$title = get_the_title($slide->ID);
		$url   = get_post_meta($slide->ID, 'slide_url', true);

		// 画像URLおよびメディア本体に登録された代替テキスト（alt）取得
		$img_meta = get_post_meta($slide->ID, 'slide_image', true);
		$img_url = '';
		$img_alt = '';

		if ($img_meta) {
			if (is_numeric($img_meta)) {
				$img_id  = (int)$img_meta;
				$img_url = wp_get_attachment_image_url($img_id, 'full');
				$img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
			} else {
				$img_url = $img_meta;
				$img_id  = attachment_url_to_postid($img_url);
				if ($img_id) {
					$img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
				}
			}
		}

		if (!$img_url) {
			continue;
		}

		$slide_items[] = array(
			'id'    => $slide->ID,
			'title' => $title,
			'url'   => $url,
			'img'   => $img_url,
			'alt'   => $img_alt,
		);
	}

	$original_count = count($slide_items);

	if ($original_count === 1):
		// 1枚のみの場合はスライド機能なしでそのまま表示
		$item = $slide_items[0];
		?>
		<div id="mainvisual" class="single-slide">
			<div class="mainvisual-inner">
				<?php if (!empty($item['url'])): ?>
					<a href="<?php echo esc_url($item['url']); ?>">
						<img src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr($item['alt']); ?>">
					</a>
				<?php else: ?>
					<img src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr($item['alt']); ?>">
				<?php endif; ?>
			</div>
		</div>
	<?php elseif ($original_count > 1):
		// 2〜3枚でも左右の移動が無限ループできるよう、スライド要素を多重化（クローン）して配置
		// 必要なループ長（最低5枚以上になるようセット数を算出）
		$repeat_count = ($original_count <= 2) ? 3 : (($original_count <= 4) ? 2 : 1);
		?>
		<!-- 複数枚ある場合のスライドショー（左右スライド・無限ループ） -->
		<div id="mainvisual" class="slideshow" aria-roledescription="carousel" aria-label="メインビジュアルスライドショー" data-original-count="<?php echo esc_attr($original_count); ?>" data-repeat-count="<?php echo esc_attr($repeat_count); ?>">
			<div class="slideshow-container">
				<ul class="slideshow-slides">
					<?php
					for ($r = 0; $r < $repeat_count; $r++):
						foreach ($slide_items as $index => $item):
							$is_clone = ($r > 0);
							$item_class = 'slide-item' . ($r === 0 && $index === 0 ? ' is-active' : '') . ($is_clone ? ' is-clone' : '');
							?>
							<li class="<?php echo esc_attr($item_class); ?>"
								data-index="<?php echo esc_attr($index); ?>"
								data-slide-no="<?php echo esc_attr($r * $original_count + $index); ?>"
								<?php if ($is_clone): ?>
									aria-hidden="true"
								<?php else: ?>
									aria-hidden="<?php echo $index === 0 ? 'false' : 'true'; ?>"
								<?php endif; ?>>
								<?php if (!empty($item['url'])): ?>
									<a href="<?php echo esc_url($item['url']); ?>"<?php echo $is_clone ? ' tabindex="-1" aria-hidden="true"' : ($index === 0 ? '' : ' tabindex="-1"'); ?>>
										<img src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr($item['alt']); ?>"<?php echo $is_clone ? ' aria-hidden="true"' : ''; ?>>
									</a>
								<?php else: ?>
									<img src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr($item['alt']); ?>"<?php echo $is_clone ? ' aria-hidden="true"' : ''; ?>>
								<?php endif; ?>
							</li>
							<?php
						endforeach;
					endfor;
					?>
				</ul>

				<!-- 次へ・戻るボタン -->
				<button type="button" class="slide-prev" aria-label="前のスライドへ">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
				</button>
				<button type="button" class="slide-next" aria-label="次のスライドへ">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
				</button>
			</div>

			<!-- スライドショー下の表示位置（ドット）および再生／一時停止コントロール（本来の枚数分のみ表示） -->
			<div class="slideshow-controls wrapper">
				<div class="slideshow-indicators" role="tablist">
					<?php for ($i = 0; $i < $original_count; $i++): ?>
						<button type="button" class="indicator-dot<?php echo $i === 0 ? ' is-active' : ''; ?>" role="tab" aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-label="スライド <?php echo $i + 1; ?>" data-slide-index="<?php echo $i; ?>"></button>
					<?php endfor; ?>
				</div>
				<div class="slideshow-playback">
					<button type="button" class="btn-pause is-active" aria-label="一時停止">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><rect x="6" y="4" width="4" height="16"></rect><rect x="14" y="4" width="4" height="16"></rect></svg>
					</button>
					<button type="button" class="btn-play" aria-label="再生">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
					</button>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
