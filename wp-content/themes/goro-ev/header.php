<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon-precomposed" href="/favicon.png">
	<?php
	if (!is_404()):
		$current_url = wp_get_canonical_url();
		if (!$current_url) {
			$current_url = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}
		echo '<link rel="canonical" href="' . esc_url($current_url) . '">';
	endif;
	?>

	<?php
	if (is_singular()) {
		wp_enqueue_script('comment-reply');
	}
	?>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Timmana&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>
<?php
$body_class = ''; // IPによる条件分岐を廃止
?>

<body <?php body_class(); ?>>

	<!-- #container -->
	<div id="container">

		<header id="site-header" class="flex wrapper">

			<?php
			$blogname = get_bloginfo('name');
			$logoimg = '<img src="' . get_theme_file_uri('images/logo.png') . '" alt="' . $blogname . '">';
			if (is_front_page() && is_home()):
				$logo = '<h1 id="logo">' . $logoimg . '</h1>';
			else:
				$logo = '<p id="logo"><a href="' . esc_url(home_url()) . '">' . $logoimg . '</a></p>';
			endif;
			echo $logo;
			?>

			<nav id="mainmenu" aria-label="メインメニュー">
				<button id="ocbt" class="sp"><span class="bar"></span><em>メニュー</em><em>とじる</em></button>
				<div class="spbox">
					<ul class="menu">
					<li>
						<a href="<?php echo esc_url(home_url('/')); ?>"<?php echo (is_front_page() || is_home()) ? ' class="current"' : ''; ?>>
							<span class="eng">TOP</span>
							<span class="jp">トップページ</span>
						</a>
					</li>
					<?php foreach (goro_get_main_pages() as $item) : ?>
						<li>
							<a href="<?php echo esc_url($item['link']); ?>"<?php echo is_page($item['id']) ? ' class="current"' : ''; ?>>
								<span class="eng"><?php echo esc_html($item['pagename_upper']); ?></span>
								<span class="jp"><?php echo esc_html($item['menu_title']); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
			</nav>
		</header>

		<?php if (is_front_page() && is_home()): ?>
			<?php include(get_theme_file_path("inc_slideshow.php")); ?>
		<?php else: ?>
			<?php $header_info = goro_get_page_header_info(); ?>
			<?php if ($header_info): ?>
				<div id="mainvisual">
					<div class="wrapper">
						<h1 class="page-title">
							<span class="eng"><?php echo esc_html($header_info['slug']); ?></span>
							<span class="jp"><?php echo esc_html($header_info['title']); ?></span>
						</h1>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php
		include('inc_breadcrumbs.php');
		?>

		<a id="CONTENT_AREA" tabindex="-1" class="skip">ここから本文です。</a>

		<div id="site-content">
			<!-- #main -->
			<main id="main">
