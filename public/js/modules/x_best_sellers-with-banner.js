"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

(function ($) {
  $(document).ready(function () {
    $('.x_best_sellers.with-banner').each(function () {
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
            rows: [[0, 1], [2, 3, 4], [5]],
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
          getProducts: function getProducts(category, transient) {
            var _this = this;

            _this.active_category = category.term_id;
            if (typeof _this.products[_this.active_category] !== 'undefined') return false;
            _this.loading = true;

            _this.$set(_this.products, category.term_id, []);

            var url = "".concat(x_ajax_url, "?action=stm_x_get_bestsellers&term_id=").concat(category.term_id, "&module_id=").concat(module_id, "&total=6&banner=&style=with_banner");

            if (_typeof(transient) === 'object') {
              _this.$set(_this.products, category.term_id, _this.transient);

              _this.loading = false;
            } else {
              _this.$http.get(url).then(function (r) {
                var products = r.body;

                _this.$set(_this.products, category.term_id, products);

                _this.loading = false;
              });
            }
          }
        }
      });
    });
  });
})(jQuery);