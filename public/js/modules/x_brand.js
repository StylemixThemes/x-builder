"use strict";

(function ($) {
  $(document).ready(function () {
    $('.x_categories_carousel').each(function () {
      var $this = $(this);
      var module_id = $(this).data('module');
      new Vue({
        el: $this[0],
        data: function data() {
          return {
            data: window[module_id],
            categories: []
          };
        },
        mounted: function mounted() {
          this.getCategories();
        },
        methods: {
          getCategories: function getCategories() {
            var _this = this;

            _this.loading = true;

            _this.$http.post("".concat(x_ajax_url, "?action=x_get_product_categories"), _this.data).then(function (r) {
              _this.$set(_this, 'categories', r.body);

              _this.carousel();
            });
          },
          carousel: function carousel() {
            var _this = this;

            Vue.nextTick().then(function () {
              var $carousel = $(".".concat(module_id, " .x_categories_carousel__items"));

              if (_this.categories.length > 1) {
                $carousel.imagesLoaded(function () {
                  _this.loading = false;
                  $carousel.owlCarousel({
                    loop: false,
                    nav: false,
                    dots: true,
                    margin: 15,
                    autoWidth: true // autoplay: true,
                    // autoplayHoverPause: true,

                  });
                });
              } else {
                $carousel.removeClass('owl-carousel');
                _this.loading = false;
              }
            });
          }
        }
      });
    });
  });
})(jQuery);