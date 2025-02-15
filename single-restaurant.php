<?php get_header('header'); ?>

<!-- Main Content Area -->
<main id="main" class="light">
  <div id="articulated" class="container justify-self-center relative flex main-content">
    <div id="content" class="w-full flex flex-col h-auto">
      <div class="overflow-auto text-gray-200 content-scrollable">

        <div class="max-w-[1000px] mx-auto mb-20">
          <?php get_template_part('includes/section', 'restaurant'); ?>
        </div>

        <?php get_template_part('includes/section', 'innerfooter'); ?>
      </div>
    </div>
    <?php get_template_part('includes/section', 'closebutton'); ?>
  </div>
</main>
<?php get_template_part('includes/section', 'mappanel'); ?>

<?php get_footer(); ?>