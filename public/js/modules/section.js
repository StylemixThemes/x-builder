"use strict";

(function ($) {
  $(document).ready(function () {
    sectionFullwidth();
  });
  $(window).load(function () {
    sectionFullwidth();
  });
  $(window).resize(function () {
    sectionFullwidth();
  });

  function sectionFullwidth() {
    $('.x_section__fullwidth, .x_section__fullwidth-no-padding').each(function () {
      var _this = $(this);

      var _wWidth = $(window).width();

      var $page_content = $('.page-content');

      var _width = $page_content.length ? $page_content.width() : $(this).parent().width();

      var _quarterWidth = (_wWidth - _width) / 2;

      _this.css({
        width: "".concat(_wWidth, "px"),
        left: "-".concat(_quarterWidth, "px")
      });
    });
  }
})(jQuery);