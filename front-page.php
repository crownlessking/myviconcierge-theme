  <?php get_header('header'); ?>

  <!-- Main Content Area -->
  <main class="light">
    <div id="main" class="container justify-self-center relative flex articulated">
      <div id="content" class="w-full flex flex-col h-auto">
        <div class="overflow-auto text-gray-200 content-scrollable">
          <h1 class="text-center text-4xl mt-5 mb-20 tracking-wide leading-tight border-b-2 pb-2 font-thin">
            <?php the_title(); ?>
          </h1>

          <!-- Information Menu -->
          <div class="w-100 h-auto mb-20">
            <div class="flex flex-wrap gap-5 justify-center p-5">
              <a href="#">
                <div class="relative hover:scale-110 transition-transform duration-300 shadow-2xl w-80 h-52 overflow-hidden">
                  <img src="<?= get_template_directory_uri() . '/images/imm-restaurant.jpg'; ?>" alt="restaurants" class="w-full h-full object-cover">
                  <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                    <span class="text-white text-[1.5rem] font-bold tracking-wider information-menu-text-shadow">Restaurants</span>
                  </div>
                </div>
              </a>
              <a href="#">
                <div class="relative hover:scale-110 transition-transform duration-300 shadow-2xl w-80 h-52 overflow-hidden">
                  <img src="<?= get_template_directory_uri() . '/images/imm-beach.jpg'; ?>" alt="beaches" class="w-full h-full object-cover">
                  <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                    <span class="text-white text-[1.5rem] font-bold tracking-wider information-menu-text-shadow">Beaches</span>
                  </div>
                </div>
              </a>
              <a href="#">
                <div class="relative hover:scale-110 transition-transform duration-300 shadow-2xl w-80 h-52 overflow-hidden">
                  <img src="<?= get_template_directory_uri() . '/images/imm-resort.jpg'; ?>" alt="resorts and hotels" class="w-full h-full object-cover">
                  <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                    <span class="text-white text-[1.5rem] font-bold tracking-wider information-menu-text-shadow">Hotels <br />&<br /> Resorts</span>
                  </div>
                </div>
              </a>
            </div>
          </div>

          <div class="max-w-[1000px] mx-auto mb-20">
            <?php get_template_part('includes/section', 'frontpage'); ?>
          </div>

          <?php get_sidebar(); ?>
        </div>
      </div>
      <?php get_template_part('includes/section', 'closebutton'); ?>
    </div>
    <?php get_template_part('includes/section', 'mappanel'); ?>
  </main>

  <?php get_footer(); ?>
