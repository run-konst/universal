<form role="search" method="get" class="search" action="<?php echo home_url( '/' ) ?>" >
	<input type="text" class="search__input" placeholder="<?php _ex( 'Search', 'search', 'universaltheme' ); ?>" name="s" id="s" value="<?php echo get_search_query() ?>" >
	<button type="submit" class="search__btn"></button>
</form>