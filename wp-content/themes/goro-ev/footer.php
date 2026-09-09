	<div id="gopagetop" class="wrapper">
		<a href="#container"><img src="<?php echo esc_url(get_theme_file_uri('images/pagetop.svg')); ?>" alt="ページの先頭へ" width="50" height="50"></a>
	</div>
</main><!-- /#main -->

<?php get_sidebar(); ?>

</div><!-- /#site-contents -->

<footer id="site-footer">
    <div class="bgblue">
        <div class="wrapper">
            <?php echo do_shortcode('[get_pagepart slug=footer]'); ?>
            <nav id="footmenu" aria-label="フッターメニュー">
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/sitepolicy/')); ?>">サイトポリシー</a></li>
                    <li><a href="<?php echo esc_url(home_url('/accessibility/')); ?>">アクセシビリティ</a></li>
                    <li><a href="<?php echo esc_url(home_url('/sitemap/')); ?>">サイトマップ</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="wrapper">
        <?php echo do_shortcode('[get_pagepart slug=subsidy]'); ?>
    </div>
</footer>

</div><!-- /#container -->

<?php wp_footer(); ?>

</body>

</html>
