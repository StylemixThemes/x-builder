"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

(function ($) {
  $(document).ready(function () {
    $('.x_products_sale_carousel').each(function () {
      var $this = $(this);
      var module_id = $(this).data('module');
      new VueW3CValid({
        el: ".".concat(module_id)
      });
      new Vue({
        el: $this[0],
        data: function data() {
          return {
            products: [],
            total: window[module_id]['number_of_items'],
            transient: window[module_id]['transient'],
            per_row: window[module_id]['per_row'],
            per_row_md: window[module_id]['per_row_md'],
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
            var url = "".concat(x_ajax_url, "?action=x_products_sale_carousel&module_id=").concat(module_id, "&total=").concat(this.total);

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
              var $carousels = $('.x_products_sale_carousel__products');
              var $carousel_prev = $(".".concat(module_id)).find('.prev');
              var $carousel_next = $(".".concat(module_id)).find('.next');
              $carousels.each(function () {
                var $carousel = $(this);
                if ($carousel.hasClass('owl-carousel')) return false;

                if ($carousel[0].childElementCount > 1) {
                  $carousel.addClass('owl-carousel');
                  $carousel.imagesLoaded(function () {
                    _this.loading = false;
                    $carousel.owlCarousel({
                      items: 3,
                      loop: false,
                      nav: false,
                      dots: true,
                      autoplay: false,
                      margin: 10,
                      autoplayHoverPause: true,
                      responsive: {
                        0: {
                          items: 1
                        },
                        768: {
                          items: 2
                        },
                        1120: {
                          items: _this.per_row_md
                        },
                        1400: {
                          items: _this.per_row
                        }
                      }
                    });
                    $carousel_prev.on('click', function () {
                      $carousel.trigger('prev.owl.carousel');
                    });
                    $carousel_next.on('click', function () {
                      $carousel.trigger('next.owl.carousel');
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