"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

(function ($) {
  $(document).ready(function () {
    $('.x_deal_of_the_day').each(function () {
      var $this = $(this);
      var module_id = $(this).data('module');
      new VueW3CValid({
        el: ".".concat(module_id)
      });
      new Vue({
        el: $this[0],
        data: function data() {
          return {
            posts: window[module_id]['posts'],
            transient: window[module_id]['transient'],
            products: []
          };
        },
        mounted: function mounted() {
          this.getProducts(this.transient);
        },
        methods: {
          getProducts: function getProducts(transient) {
            var _this = this;

            _this.loading = true;
            var data = {
              'posts': _this.posts,
              'module_id': module_id
            };

            if (_typeof(transient) === 'object') {
              _this.$set(_this, 'products', transient);

              _this.carousel();
            } else {
              _this.$http.post("".concat(x_ajax_url, "?action=x_deal_of_the_day"), data).then(function (r) {
                _this.$set(_this, 'products', r.body);

                _this.carousel();
              });
            }
          },
          carousel: function carousel() {
            var _this = this;

            Vue.nextTick().then(function () {
              var $carousel = $(".".concat(module_id, " .x_deal_of_the_day__posts"));

              if (_this.products.length > 1) {
                $carousel.imagesLoaded(function () {
                  $carousel.owlCarousel({
                    loop: true,
                    nav: false,
                    dots: true,
                    items: 1,
                    margin: 15,
                    autoplay: true,
                    autoplayHoverPause: true,
                    singleItem: true,
                    autoHeight: true
                  });
                });
              } else {
                $carousel.removeClass('owl-carousel');
              }

              _this.loading = false;
            });
          }
        }
      });
    });
  });
})(jQuery);