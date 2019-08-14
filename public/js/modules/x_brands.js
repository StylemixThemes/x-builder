"use strict";

(function ($) {
  $(document).ready(function () {
    $('.x_brands.owl-carousel').each(function () {
      var $this = $(this);
      var module_id = $(this).data('module');
      var $carousel = $this;

      if ($carousel.find('a').length > 1) {
        $carousel.imagesLoaded(function () {
          $carousel.owlCarousel({
            items: 5,
            loop: false,
            nav: false,
            dots: false,
            margin: 15,
            // autoplay: true,
            // autoplayHoverPause: true,
            responsive: {
              0: {
                items: 2
              },
              480: {
                items: 3
              },
              768: {
                items: 4
              },
              992: {
                items: 5
              },
              1025: {
                items: 5
              }
            }
          });
        });
      }
    });
  });
})(jQuery);