
<?php wp_footer(); ?>
<script>
  jQuery(document).ready(function($) {
    $.ajax({
      url: '<?php echo admin_url('admin-ajax.php'); ?>',
      type: 'POST',
      data: {
        action: 'mvic_get_random_background_image'
      },
      success: function(response) {
        const img = new Image();
        img.src = response;
        if (img.addEventListener) {
          img.addEventListener('load', function() {
            $('#mvic-map-canvas').css({
              'display': 'none',
              'background-image': `url(${img.src})`,
              'background-position': 'center',
              'background-size': 'cover',
              'background-repeat': 'no-repeat'
            })
            .fadeIn('slow');
          }, false);
        } else {
          img.onload = function() {
            $('#mvic-map-canvas').css({
              'display': 'none',
              'background-position': 'center',
              'background-size': '100%',
              'background-repeat': 'no-repeat'
            })
            .fadeIn('slow');
          };
          $('#mvic-map-canvas').css('background-image', `url(${img.src})`);
        }
      },
      error: function(error) {
        console.log('No background images found!');
      }
    });
  });
</script>
</body>
</html>
