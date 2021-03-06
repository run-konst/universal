<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package universal-example
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php

// Функция вывода комментариев

function universal_theme_comment( $comment, $args, $depth ) {
	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}

	$classes = ' ' . comment_class( empty( $args['has_children'] ) ? '' : 'parent', null, null, false );
	?>

	<<?php echo $tag, $classes; ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) { ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment__body"><?php
	} ?>

    <div class="comment__avatar">
        <?php
        if ( $args['avatar_size'] != 0 ) {
            echo get_avatar( $comment, $args['avatar_size'] );
        }
        ?>
    </div>
    <div class="comment__main">
        <?php
        printf(
            __( '<cite class="comment__author">%s</cite>' ),
            get_comment_author_link()
        );
        ?>
        <span class="comment__meta commentmetadata">
            <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                <?php
                printf(
                    __( '%1$s, %2$s' ),
                    get_comment_date('F jS'),
                    get_comment_time()
                ); ?>
            </a>

            <?php edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
        </span>

        <?php if ( $comment->comment_approved == '0' ) { ?>
            <em class="comment-awaiting-moderation">
                <?php _e( 'Your comment is awaiting moderation.' ); ?>
            </em><br/>
        <?php } ?>

        <?php comment_text(); ?>

        <div class="comment-reply">
            <svg class="reply-icon">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#comment"></use>
            </svg>
            <?php
            comment_reply_link(
                array_merge(
                    $args,
                    array(
                        'add_below' => $add_below,
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth']
                    )
                )
            ); ?>
        </div>
    </div>

	<?php if ( 'div' != $args['style'] ) { ?>
		</div>
	<?php }
} ?>

<div class="container">

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) {
		?>
        <div class="comments__header">
            <h2 class="comments__title">
                <?php echo 'Комментарии ' . '<span class="comments__number">' . get_comments_number() . '</span>'; ?>
            </h2>
            <a href="#commentform" class="comments__add-link">
                <svg class="pencil-icon">
                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#pencil"></use>
                </svg>
                <span>Добавить комментарий</span>   
            </a>

        </div>

		<?php the_comments_navigation(); ?>

		<ul class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ul',
					'short_ping' => true,
                    'callback' => 'universal_theme_comment',
                    'login_text' => 'Зарегестрируйтесь, если хотите прокомментировать.',
				)
			);
			?>
		</ul><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'universaltheme' ); ?></p>
			<?php
		endif;

    } else {
        ?>
        <h3 class="no-comments">Комментариев нет</h3>
        <?php
    }; // Check for have_comments().

	comment_form(array(
        'title_reply'          => '',
        'comment_field'        => '
        <label class="comment-form__label" for="comment">Что вы думаете на этот счет?</label>        
        <div class="comment-form__comment">
            <div class="comment-form__avatar">' . get_avatar( get_current_user_id() ) . '</div>
            <div class="comment-form__textarea-wrapper">
                <textarea id="comment" name="comment" cols="45" rows="8"  aria-required="true" required="required"></textarea>
            </div>            
        </div>',
        'must_log_in'          => '<p class="must-log-in">' . 
             sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '
         </p>',
        'logged_in_as'         => '',
        'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="comment__submit-btn" value="Отправить" />', 
        )
    );
	?>

</div><!-- #comments -->

</div>

