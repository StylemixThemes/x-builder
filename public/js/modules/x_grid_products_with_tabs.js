"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

(function ($) {
  $(document).ready(function () {
    $('.x_grid_products_with_tabs').each(function () {
      var $this = $(this);
      var module_id = $(this).data('module');
      new VueW3CValid({
        el: ".".concat(module_id)
      });
      new Vue({
        el: $this[0],
        data: function data() {
          return {
            categories: window[module_id]['categories'],
            total: window[module_id]['total'],
            carousel: window[module_id]['carousel'],
            per_row: window[module_id]['per_row'],
            per_row_tablet_vertical: window[module_id]['per_row_tablet_vertical'],
            per_row_tablet_horizontal: window[module_id]['per_row_tablet_horizontal'],
            per_row_tablet_mobile: window[module_id]['per_row_tablet_mobile'],
            transient: window[module_id]['transient'],
            active_category: '',
            products: {},
            loading: false,
            hover: false
          };
        },
        mounted: function mounted() {
          if (this.categories.length) this.getProducts(this.categories[0], this.transient);
        },
        methods: {
          getProducts: function getProducts(category, transient) {
            var _this = this;

            _this.$set(_this, 'active_category', category.term_id);

            if (typeof _this.products[category.term_id] !== 'undefined' && !_this.carousel) {
              return;
            }

            _this.loading = true;

            _this.$set(_this.products, category.term_id, []);

            var url = "".concat(x_ajax_url, "?action=x_get_products&term_id=").concat(category.term_id, "&total=").concat(this.total, "&module_id=").concat(module_id);

            if (_typeof(transient) === 'object') {
              _this.$set(_this.products, category.term_id, _this.transient);

              _this.init_carousel();
            } else {
              _this.$http.get(url).then(function (r) {
                var products = r.body;

                _this.$set(_this.products, category.term_id, products);

                _this.init_carousel();
              });
            }
          },
          init_carousel: function init_carousel() {
            var _this = this;

            if (!_this.carousel) {
              _this.loading = false;
              return false;
            }

            Vue.nextTick().then(function () {
              var $carousel = $(".".concat(module_id, " .x_grid_products"));
              var $carousel_prev = $(".".concat(module_id)).find('.prev');
              var $carousel_next = $(".".concat(module_id)).find('.next');

              if ($carousel.hasClass('owl-loaded')) {
                $carousel.find('.owl-item').remove();
                $carousel.owlCarousel('destroy');
              }

              if (_this.products[_this.active_category].length > 1) {
                $carousel.addClass('owl-carousel');
                _this.loading = false;
                $carousel.imagesLoaded(function () {
                  $carousel.owlCarousel({
                    loop: false,
                    nav: false,
                    dots: false,
                    margin: 15,
                    items: _this.per_row,
                    autoplay: false,
                    autoplayHoverPause: true,
                    responsive: {
                      0: {
                        items: _this.per_row_tablet_mobile
                      },
                      768: {
                        items: _this.per_row_tablet_vertical
                      },
                      992: {
                        items: _this.per_row_tablet_horizontal
                      },
                      1025: {
                        items: _this.per_row
                      }
                    }
                  });
                  $carousel_prev.click(function () {
                    $carousel.trigger('prev.owl.carousel');
                  });
                  $carousel_next.click(function () {
                    $carousel.trigger('next.owl.carousel');
                  });

                  if ($carousel.find('.x_vertical_product').length <= parseInt(_this.per_row)) {
                    $carousel_prev.hide();
                    $carousel_next.hide();
                  }
                });
              } else {
                $carousel.removeClass('owl-carousel');
                $carousel_prev.hide();
                $carousel_next.hide();
                _this.loading = false;
              }
            });
          }
        }
      });
    });
  });
})(jQuery);