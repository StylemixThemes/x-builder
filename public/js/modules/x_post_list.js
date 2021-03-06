"use strict";

(function ($) {
  $(document).ready(function () {
    $('.x_post_list_wrapper').each(function () {
      var $module_id = $(this).data('module');
      var carousel = window[$module_id]['carousel'];

      if ($(this).find('.x_post_list__item').length > 1 && carousel) {
        var $carousel = $(this).find('.x_post_list');
        var $carousel_prev = $(this).find('.prev');
        var $carousel_next = $(this).find('.next');
        $carousel = $carousel.owlCarousel({
          loop: false,
          nav: false,
          dots: false,
          items: 3,
          responsive: {
            0: {
              items: 1
            },
            991: {
              items: 2
            },
            1400: {
              items: 3
            }
          }
        });
        $carousel_prev.on('click', function () {
          $carousel.trigger('prev.owl.carousel');
        });
        $carousel_next.on('click', function () {
          $carousel.trigger('next.owl.carousel');
        });
      }
    });
  });
})(jQuery);