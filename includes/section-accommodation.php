<?php

require_once plugin_dir_path(__FILE__) . '../common/logic.php';

while ( have_posts() ) :
  the_post();
  ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="relative">
      <?php the_title( '<h1 class="entry-title text-center text-4xl mt-5 mb-20 tracking-wide leading-tight border-b-2 pb-2 font-thin"><span>', '</h1>' ); ?>
      <div class="absolute inset-0 top-[4rem] mx-auto text-center font-bold w-100">
        <span id="bh-status"></span>
      </div>
    </header><!-- .entry-header -->

    <div class="flex items-center justify-center">
      <div class="flex flex-col h-full md:flex-row space-y-4 md:space-x-4 md:space-y-0">

        <aside class="profile flex-grow">
          <?php get_template_part('includes/section', 'map_icon'); ?>
          <?php get_template_part('includes/section', 'accommodation_profile'); ?>
          <?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
            <?php dynamic_sidebar( 'primary-sidebar' ); ?>
          <?php endif; ?>
        </aside><!-- .entry-sidebar -->
    
        <div class="article-text">
          <?php the_content(); ?><!-- .entry-content -->
  
          <footer class="entry-footer">
            <?php edit_post_link( __( 'Edit', 'textdomain' ), '<span class="edit-link">', '</span>' ); ?>
          </footer><!-- .entry-footer -->
          <?php
          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
              comments_template();
          endif;
          ?>
        </div>
      </div>
    </div>

  </article><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; /* End of the loop. */ ?>