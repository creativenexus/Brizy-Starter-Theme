<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 */

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="<?php echo comments_open() ? 'comments-area' : 'comments-area comments-closed'; ?>">

    <?php if ( have_comments() ) : ?>
        <h3 class="comments-title">
            <?php printf( _n( 'One Response', '%1$s Responses', get_comments_number(), 'creativenexus-visual' ), number_format_i18n( get_comments_number() ), get_the_title() ); ?>
        </h3>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 60,
            ) );
            ?>
        </ol><!-- .comment-list -->

        <?php the_comments_navigation(); ?>

    <?php endif; // Check for have_comments(). ?>

    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments"><?php _e( 'Comments are closed.', 'creativenexus-visual' ); ?></p>
    <?php endif; ?>

    <?php
    comment_form( array(
        'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
        'title_reply_after'  => '</h2>',
    ) );
    ?>

</section><!-- #comments -->
