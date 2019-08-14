"use strict";

(function ($) {
  $(document).ready(function () {
    $('.x_hint_images').each(function () {
      var $container = $(this);
      $container.imagesLoaded(function () {
        var $pckry = $container.packery({
          // options
          itemSelector: '.x_hint_image',
          vertical: true,
          percentPosition: true
        });
      });
    });
  });
})(jQuery);