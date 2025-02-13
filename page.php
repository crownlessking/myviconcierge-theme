<?php
/**
 * The template for displaying all pages.
 * 
 * @package myviconcierge-theme
 */
get_header('header');
?>

<!-- Main Content Area -->
<main class="light">
  <div id="main" class="container justify-self-center relative flex articulated">
    <div id="content" class="w-full flex flex-col h-auto">
      <div class="overflow-auto text-gray-200 content-scrollable">

        <div class="max-w-[1000px] mx-auto mb-20">
          <?php get_template_part('includes/section', 'page_content'); ?>
        </div>

        <?php get_template_part('includes/section', 'innerfooter'); ?>
      </div>
    </div>
    <?php get_template_part('includes/section', 'closebutton'); ?>
  </div>
  <?php get_template_part('includes/section', 'mappanel'); ?>
</main>

<?php get_footer(); ?>
