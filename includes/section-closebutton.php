<?php
/*
 * Close button
 */
?>
<?php
$post_type = get_post_type();
$button_text = 'Close';

if (in_array($post_type, ['restaurant', 'beach', 'accommodation'])) {
  $button_text = 'Show on map';
}
?>

<div id="mvic-close-button-wrapper" class="absolute inset-x-0 mx-auto w-36 h-6 bottom-[.277rem]">
  <button type="button" id="close-button" class="h-6 w-36 font-sans font-bold not-italic no-underline text-center text-white rounded-2xl close-button">
  <?= $button_text; ?>
  </button>
</div>