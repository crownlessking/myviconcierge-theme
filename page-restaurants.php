<?php
/*
Template Name: Restaurants
*/
?>

<?php get_header('header'); ?>

<!-- Main Content Area -->
<main id="main" class="light">
  <div id="articulated" class="container justify-self-center relative flex main-content">
    <div id="content" class="w-full flex flex-col h-auto">
      <div class="overflow-auto text-gray-200 content-scrollable">
        <h1 class="text-center text-4xl mt-5 mb-20 tracking-wide leading-tight border-b-2 pb-2 font-thin">
          <?php the_title(); ?>
        </h1>

        <div class="max-w-[1000px] mx-auto mb-20">
          <div class="flex items-center justify-center">
            <div class="flex flex-col h-full md:flex-row space-y-4 md:space-x-4 md:space-y-0">

              <?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
                <aside class="profile flex-grow">
                  <?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
                    <?php dynamic_sidebar( 'primary-sidebar' ); ?>
                  <?php endif; ?>
                </aside><!-- .entry-sidebar -->
              <?php endif; ?>

              <div class="article-text">
                <?php
                // Fetch all restaurants
                $args = array(
                  'post_type' => 'restaurant',
                  'posts_per_page' => -1
                );
                $restaurants = new WP_Query($args);

                if ($restaurants->have_posts()) : ?>
                  <div class="w-100 h-auto mb-20">
                    <div class="flex flex-wrap gap-5 justify-center p-5">
                      <?php while ($restaurants->have_posts()) : $restaurants->the_post(); ?>
                        <?php $has_thumbnail = has_post_thumbnail(); ?>

                        <a href="<?php the_permalink(); ?>">
                          <?php if (has_post_thumbnail()) : ?>
                            <div class="relative hover:scale-110 transition-transform duration-300 shadow-2xl w-80 h-52 overflow-hidden">
                              <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover">
                              <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                                <span class="text-white text-[1.5rem] font-bold tracking-wider information-menu-text-shadow"><?php the_title(); ?></span>
                              </div>
                            </div>
                          <?php else : ?>
                            <div class="relative hover:scale-110 transition-transform duration-300 shadow-2xl w-80 h-52 overflow-hidden bg-gray-400">
                              <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                                <span class="text-white text-[1.5rem] font-bold tracking-wider information-menu-text-shadow"><?php the_title(); ?></span>
                              </div>
                            </div>
                          <?php endif; ?>
                        </a>

                      <?php endwhile; ?>
                    </div>
                  </div>
                  <?php wp_reset_postdata(); ?>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>
                <script>
                  var restaurantHours = [];
                  <?php
                  $restaurants = new WP_Query($args);
                  while ($restaurants->have_posts()) : $restaurants->the_post(); ?>
                    restaurantHours.push({
                      id: <?php echo get_the_ID(); ?>,
                      hours: <?php echo json_encode(get_post_meta(get_the_ID(), '_restaurant_business_hours_meta_key', true)); ?>
                    });
                  <?php endwhile; ?>
                  console.log(restaurantHours);
                </script>
                <?php wp_reset_postdata(); ?>
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
        </div>

        <?php get_sidebar(); ?>
      </div>
    </div>
    <?php get_template_part('includes/section', 'closebutton'); ?>
  </div>
</main>
<?php get_template_part('includes/section', 'mappanel'); ?>

<?php get_footer(); ?>
