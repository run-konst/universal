<?php

## отключаем создание миниатюр файлов для указанных размеров

add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}

// Добавляем миниатюры

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'homepage-thumb', 65, 65, true );
	add_image_size( 'small-thumb', 336, 195, true ); 
	add_image_size( 'smaller-thumb', 263, 180, true );
	add_image_size( 'medium-thumb', 1140, 600, true );
}
