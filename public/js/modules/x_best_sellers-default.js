"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

(function ($) {
  $(document).ready(function () {
    $('.x_best_sellers.default').each(function () {
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
            transient: window[module_id]['transient'],
            active_category: '',
            rows: [[0, 7, 8], [1, 2, 3], [4, 5, 6]],
            products: {},
            loading: false,
            hover: false
          };
        },
        mounted: function mounted() {
          if (this.categories.length) {
            this.getProducts(this.categories[0], this.transient);
          }
        },
        methods: {
          rowClasses: function rowClasses(row_num) {
            var _this = this;

            var classes = ['x_best_sellers__products_rows' + (row_num + 1)];
            /*get Row 1 items*/

            var count = 0;

            _this.rows[row_num].forEach(function (product_index) {
              if (typeof _this.products[_this.active_category][product_index] !== 'undefined') count++;
            });

            classes.push("row_items_".concat(count));
            return classes;
          },
          getProducts: function getProducts(category, transient) {
            var _this = this;

            _this.active_category = category.term_id;

            if (typeof _this.products[_this.active_category] !== 'undefined') {
              _this.reinitCarousel();

              return false;
            }

            _this.loading = true;

            _this.$set(_this.products, category.term_id, []);

            var url = "".concat(x_ajax_url, "?action=stm_x_get_bestsellers&term_id=").concat(category.term_id, "&module_id=").concat(module_id, "&total=8&style=default");

            if (_typeof(transient) === 'object') {
              _this.$set(_this.products, category.term_id, transient);

              _this.loading = false;

              _this.initSmallCarousel();
            } else {
              _this.$http.get(url).then(function (r) {
                var products = r.body;

                _this.$set(_this.products, category.term_id, products);

                _this.loading = false;

                _this.initSmallCarousel();
              });
            }
          },
          reinitCarousel: function reinitCarousel() {
            Vue.nextTick().then(function () {
              var $carousels = $('.default .x_best_sellers__products_rows1 .x_best_sellers__products');
              $carousels.each(function () {
                var $carousel = $(this);
                $carousel.trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
                $carousel.find('.owl-stage-outer').children().unwrap();
                $carousel.find('.owl-item').each(function () {
                  $(this).remove();
                });
                setTimeout(function () {
                  if ($carousel[0].childElementCount > 1) {
                    $carousel.addClass('owl-carousel');
                    $carousel.imagesLoaded(function () {
                      $carousel.owlCarousel({
                        items: 1,
                        loop: false,
                        nav: false,
                        dots: true,
                        autoplay: false
                      });
                    });
                  }
                }, 300);
              });
            });
          },
          initSmallCarousel: function initSmallCarousel() {
            var _this = this;

            Vue.nextTick().then(function () {
              var $carousels = $('.default .x_best_sellers__products_rows1 .x_best_sellers__products');
              $carousels.each(function () {
                var $carousel = $(this);
                if ($carousel.hasClass('owl-carousel')) return false;

                if ($carousel[0].childElementCount > 1) {
                  $carousel.addClass('owl-carousel');
                  $carousel.imagesLoaded(function () {
                    _this.loading = false;
                    $carousel.owlCarousel({
                      items: 1,
                      loop: false,
                      nav: false,
                      dots: true,
                      autoplay: false
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