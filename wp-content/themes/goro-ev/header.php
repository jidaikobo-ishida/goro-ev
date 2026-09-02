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

	<?php wp_head(); ?>
</head>
<?php
$body_class = ''; // IPによる条件分岐を廃止
?>

<body <?php body_class(); ?>>

	<!-- #container -->
	<div id="container">

		<header id="site-header">

			<?php
			$blogname = get_bloginfo('name');
			$logoimg = '<img src="' . get_theme_file_uri('images/logo.png') . '" alt="' . $blogname . '">';
			$ocbt = '<button id="ocbt"><span class="bar"></span><em>Menu</em><em>Close</em></button>';
			if (is_front_page() && is_home()):
				$logo = '<h1 id="logo" class="flex">' . $logoimg . $ocbt . '</h1>';
			else:
				$logo = '<p id="logo" class="flex"><a href="' . esc_url(home_url()) . '">' . $logoimg . '</a>' . $ocbt . '</p>';
			endif;
			echo $logo;
			?>

			<nav id="mainmenu" aria-label="メインメニュー">
				<ul>
					<?php foreach (goro_get_main_pages() as $item) : ?>
						<li>
							<a href="<?php echo esc_url($item['link']); ?>">
								<span class="en"><?php echo esc_html($item['pagename_upper']); ?></span>
								<span class="ja"><?php echo esc_html($item['title']); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		</header>

		<?php
		include('inc_breadcrumbs.php');
		?>

		<a id="CONTENT_AREA" tabindex="-1" class="skip">ここから本文です。</a>

		<div id="site-content">
			<!-- #main -->
			<main id="main">
