
<article <?php post_class(); ?>>
  <?php if ( have_posts() ): while( have_posts() ): the_post();?>
    <?php the_content(); ?>

    <footer class="entry-footer">
      <?php edit_post_link( __( 'Edit', 'textdomain' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-footer -->
  <?php endwhile; else: endif;?>
</article>
