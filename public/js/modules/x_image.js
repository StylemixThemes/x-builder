"use strict";

(function ($) {
  $(window).load(function () {
    $('.x_parallax').each(function () {
      var $this = $(this);
      var module_id = $(this).data('module');
      var params = window[module_id];
      var speed = params.speed;
      var rellax = new Rellax("." + module_id, {
        speed: speed,
        center: true,
        vertical: true
      });
    });
  });
})(jQuery);