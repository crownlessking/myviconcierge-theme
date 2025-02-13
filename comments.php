<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage MyViconcierge_Theme
 * @since MyViconcierge Theme 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet entered the password
 * we will return early without loading the comments.
 */
if ( post_password_required() ) {
  return;
}
?>

<div id="comments" class="comments-area">

  <?php if ( have_comments() ) : ?>
    <h2 class="comments-title">
      <?php
      $comments_number = get_comments_number();
      if ( '1' === $comments_number ) {
        printf( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'myviconcierge-theme' ), get_the_title() );
      } else {
        printf(
          _nx(
            '%1$s thought on &ldquo;%2$s&rdquo;',
            '%1$s thoughts on &ldquo;%2$s&rdquo;',
            $comments_number,
            'comments title',
            'myviconcierge-theme'
          ),
          number_format_i18n( $comments_number ),
          get_the_title()
        );
      }
      ?>
    </h2>

    <ol class="comment-list">
      <?php
      wp_list_comments(
        array(
          'style'      => 'ol',
          'short_ping' => true,
        )
      );
      ?>
    </ol><!-- .comment-list -->

    <?php the_comments_navigation(); ?>

    <?php if ( ! comments_open() ) : ?>
      <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'myviconcierge-theme' ); ?></p>
    <?php endif; ?>

  <?php endif; ?>

  <?php comment_form(); ?>

</div><!-- #comments -->