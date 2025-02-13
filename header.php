<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <div id="mvic-map-canvas" class="absolute z-[-50] w-full h-full"></div>
  <?php get_template_part('includes/section', 'navigation'); ?>
