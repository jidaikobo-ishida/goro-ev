<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url()) ?>">
	<label>
		<span class="skip">サイト内検索</span>
		<input type="text" role="searchbox" class="search-field" value="<?php echo esc_attr(get_search_query()) ?>" name="s" />
	</label>
	<button type="submit" class="submit search-submit"><span class="icon icon_search" role="presentation" aria-hidden="true"></span>検索</button>
</form>
