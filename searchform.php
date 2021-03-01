<form role="search" method="get" class="search" action="<?php echo home_url( '/' ) ?>" >
	<input type="text" class="search__input" placeholder="Поиск" name="search" value="<?php echo get_search_query() ?>" >
	<button type="submit" class="search__btn"></button>
</form>