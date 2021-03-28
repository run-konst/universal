<?php

// Подключаем локализацию в самом конце подключаемых к выводу скриптов, чтобы скрипт
// 'twentyfifteen-script', к которому мы подключаемся, точно был добавлен в очередь на вывод.
// Заметка: код можно вставить в любое место functions.php темы

add_action( 'wp_enqueue_scripts', 'adminAjax_data', 99 );
function adminAjax_data(){

	// Первый параметр 'twentyfifteen-script' означает, что код будет прикреплен к скрипту с ID 'twentyfifteen-script'
	// 'twentyfifteen-script' должен быть добавлен в очередь на вывод, иначе WP не поймет куда вставлять код локализации
	// Заметка: обычно этот код нужно добавлять в functions.php в том месте где подключаются скрипты, после указанного скрипта
	wp_localize_script( 'jquery', 'adminAjax',
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);

}

add_action( 'wp_ajax_contacts_form', 'ajax_form' );
add_action( 'wp_ajax_nopriv_contacts_form', 'ajax_form' );
function ajax_form() {
	$name = $_POST['contact_name'];
	$email = $_POST['contact_email'];
	$comment = $_POST['contact_comment'];

    $message = 'Новый пользователь ' . $name . ', его почта ' . $email . ', задал вопрос: ' . $comment;

	$headers = 'From: Константин Руньковский <wordpress@universal.local>' . "\r\n";

    $sent_message = wp_mail('raitok@mail.ru', 'Новая заявка с сайта', $message, $headers);

    if($sent_message) {
        echo 'Все получилось';
    } else {
        echo 'Все не получилось';
    }

	// выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
	wp_die();
}