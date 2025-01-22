<div id="main" class="container justify-self-center relative flex articulated">
  <div id="content" class="w-full flex flex-col h-auto">
    <div class="overflow-auto text-gray-200 content-scrollable">
      <h1 class="text-center text-4xl mt-5 mb-20 tracking-wide leading-tight border-b-2 pb-2 font-thin">
        <?php the_title(); ?>
      </h1>
      <div class="w-100 h-auto mb-20">

        <!-- Information Menu -->
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
        <article class="relative prose">
          <div class="restaurant-profile">
            <h3 class="profile-title">Business hours</h3>
            <ul>
              <li>Sun: <span class="font-bold">Closed</li>
              <li>Mon: <span class="font-bold">11:30am - 10pm</span></li>
              <li>Tue: <span class="font-bold">11:30am - 10pm</span></li>
              <li>Wed: <span class="font-bold">11:30am - 10pm</span></li>
              <li>Thu: <span class="font-bold">11:30am - 10pm</span></li>
              <li>Fri: <span class="font-bold">11:30am - 10pm</span></li>
              <li>Sat: <br/>~Brunch~ <span class="font-bold">10am - 3pm</span><br/>
                      ~Dinner~ <span class="font-bold">5pm - 10pm</span>
              </li>
            </ul>
            <h3 class="profile-title">Restaurant Profile</h3>
            <ul>
              <li><i class="fa-solid fa-phone"></i> Phone: <span class="font-bold"><a href="tel:3407744349">(340) 774-4349</a></span></li>
              <li><i class="fa-solid fa-earth-americas"></i> <a href="https://restaurant-name.com">Website</a></li>
              <li><i class="fa-solid fa-utensils"></i> Cuisine: <span class="font-bold">Caribbean</span></li>
              <li><i class="fa-solid fa-money-bill"></i> Cost: <span class="themed-profile-cost">$31-60</span></li>
              <li><i class="fa-solid fa-people-roof"></i> Ambience: <span class="font-bold">Indoors</span></li>
              <li><i class="fa-solid fa-user"></i> Suitable for: <span class="font-bold">All</span></li>
              <li><i class="fa-solid fa-shirt"></i> Attire: <span class="font-bold">Casual</span></li>
              <li><i class="fa-solid fa-volume-low"></i> Noise level: <span class="font-bold">Average</span></li>
              <li><i class="fa-solid fa-wine-glass"></i> Alcohol: <span class="font-bold">Full bar</span></li>
              <li><i class="fa-solid fa-envelope"></i> Takes reservations: <span class="themed-profile-yes">Yes</span></li>
              <li><span class="themed-profile-unavailable"><i class="fa-solid fa-truck"></i> Delivers: No</span></li>
              <li><i class="fa-solid fa-gift"></i> Can take out: <span class="themed-profile-yes">Yes</span></li>
              <li><i class="fa-solid fa-credit-card"></i> Accepts credit cards: <span class="themed-profile-yes">Yes</span></li>
              <li><span class="themed-profile-unavailable"><i class="fa-solid fa-square-parking"></i> Private parking lot: No</span></li>
              <li><span class="themed-profile-unavailable"><i class="fa-brands fa-accessible-icon"></i> Wheelchair accessible: No</span></li>
              <li><i class="fa-solid fa-child"></i> Kids friendly: <span class="themed-profile-yes">Yes</span></li>
              <li><i class="fa-solid fa-people-group"></i> Group friendly: <span class="themed-profile-yes">Yes</span></li>
              <li><span class="themed-profile-unavailable"><i class="fa-solid fa-chair"></i> Outdoor seats: No</span></li>
              <li><span class="themed-profile-unavailable"><i class="fa-solid fa-wifi"></i> Has WI-FI: No</span></li>
              <li><i class="fa-solid fa-tv"></i> Has TV: <span class="themed-profile-yes">Yes</span></li>
              <li><i class="fa-solid fa-bell-concierge"></i> Waiter Service: <span class="themed-profile-yes">Yes</span></li>
              <li><span class="themed-profile-unavailable"><i class="fa-solid fa-restroom"></i> Has restrooms: No</span></li>
            </ul>
          </div>
          <?php if ( have_posts() ): while( have_posts() ): the_post();?>
            <?php the_content(); ?>
          <?php endwhile; else: endif;?>
        </article>
      </div>

      <!-- Sidebar -->
      <aside></aside>
      <footer class="clear-both py-4 text-center bg-gray-900 text-white">
        <div class="flex flex-col">
          <p class="m-0">&copy; <?php echo date('Y'); ?> Riviere King. All rights reserved.</p>
          <?php
          // <ul class="flex list-none p-0 gap-2 mt-2 footer-links">
          //   <li><a class="hover:underline text-white" href="#">Privacy Policy</a></li>
          //   <li><a class="hover:underline text-white" href="#">Terms of Service</a></li>
          //   <li><a class="hover:underline text-white" href="#">Contact</a></li>
          // </ul>
          ?>
        </div>
      </footer>
    </div>
  </div>
  <div id="mvic-close-button-wrapper" class="absolute inset-x-0 mx-auto w-36 h-6 bottom-3.5">
    <button type="button" id="close-button" class="h-6 w-36 font-sans font-bold not-italic no-underline text-center text-white rounded-2xl close-button">
      Close
    </button>
  </div>
</div>

<!-- MAP Panel -->
<div id="map-panel" class="map-panel bg-cover bg-center bg-no-repeat flex absolute overflow-x-hidden rounded-2xl text-gray-200 text-sm" style="display: none;">
  <div id="map-panel-header" class="map-panel-header"></div>
  <div id="map-panel-scrollable" class="map-panel-scrollable">
    <div class="mvic-ui-wrap-link">
      <div id="block-mvicapp-open-content" class="block block-mvicapp first odd">
        <a id="mvic-ui-open-content" href="#">|open content|</a>
      </div>
    </div>
    <div class="map-panel-content">
      <div class="map-panel-inner-content">
        <h2>Map Panel Content</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac neque vitae quam mollis viverra.</p>
        <p>Interdum et malesuada fames ac ante ipsum primis in faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
    </div>
  </div>
</div>

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
