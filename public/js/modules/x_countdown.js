"use strict";

(function ($) {
  $(document).ready(function () {
    $('.x_countdown').each(function () {
      var $this = $(this);
      var module_id = $(this).data('module');
      new Vue({
        el: $this[0],
        data: function data() {
          return {
            categories: ''
          };
        },
        mounted: function mounted() {},
        methods: {}
      });
    });
  });
})(jQuery);