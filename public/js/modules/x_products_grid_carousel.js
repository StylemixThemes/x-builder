"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

(function ($) {
  $(document).ready(function () {
    $('.x_products_grid_carousel').each(function () {
      var $this = $(this);
      var module_id = $(this).data('module');
      new VueW3CValid({
        el: ".".concat(module_id)
      });
      new Vue({
        el: $this[0],
        data: function data() {
          return {
            transient: window[module_id]['transient'],
            products: [],
            rows: [[0], [1, 2, 3], [5], [6, 7, 4]],
            loading: false
          };
        },
        mounted: function mounted() {
          this.getProducts();
        },
        methods: {
          getProducts: function getProducts(category) {
            var _this = this;

            _this.loading = true;
            var url = "".concat(x_ajax_url, "?action=x_products_grid_carousel&module_id=").concat(module_id);

            if (_typeof(_this.transient) === 'object') {
              _this.$set(_this, 'products', _this.transient);

              _this.loading = false;

              _this.initCarousel();
            } else {
              _this.$http.get(url).then(function (r) {
                var products = r.body;

                _this.$set(_this, 'products', products);

                _this.loading = false;

                _this.initCarousel();
              });
            }
          },
          initCarousel: function initCarousel() {
            var _this = this;

            Vue.nextTick().then(function () {
              var $carousels = $('.x_products_grid_carousel__rows');
              $carousels.each(function () {
                var $carousel = $(this);
                if ($carousel.hasClass('owl-carousel')) return false;

                if ($carousel[0].childElementCount > 1) {
                  $carousel.addClass('owl-carousel');
                  $carousel.imagesLoaded(function () {
                    _this.loading = false;
                    $carousel.owlCarousel({
                      loop: false,
                      nav: false,
                      dots: true,
                      autoWidth: true,
                      autoplay: false,
                      responsive: {
                        0: {
                          autoWidth: false,
                          autoHeight: true,
                          items: 1,
                          margin: 0
                        },
                        800: {
                          autoWidth: true,
                          autoHeight: false
                        }
                      }
                    });
                  });
                }
              });
            });
          }
        }
      });
    });
  });
})(jQuery);