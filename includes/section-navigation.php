
<nav id="navigation" class="relative bg-gradient-to-b from-black/50 to-black/0 p-2"><!-- bg-transparent -->
  <div class="container mx-auto flex flex-wrap items-center justify-between">
    <?php if (has_custom_logo()) : ?>
      <?php the_custom_logo(); ?>
    <?php else : ?>
      <a href="<?= home_url(); ?>" class="text-white text-xl nav-link-bold-shadow">
        <?php bloginfo('name'); ?>
      </a>
    <?php endif; ?>
    <button type="button" class="text-white block lg:hidden" aria-expanded="false" aria-label="Toggle navigation" id="navbar-toggler">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
      </svg>
    </button>
    <div class="w-full lg:flex lg:items-center lg:w-auto hidden" id="navbar-collapse">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary',
        'container' => false,
        'menu_class' => 'lg:flex lg:items-center lg:justify-between text-white lg:space-x-4 nav-link-bold-shadow',
        'fallback_cb' => false,
        'depth' => 2,
        'walker' => new WP_Bootstrap_Navwalker(), // Optional: if you want to use a custom walker for Bootstrap compatibility
      ));
      ?>
    </div>
  </div>
</nav>
