"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

(function ($) {
  $(document).ready(function () {
    $('.x_featured_products').each(function () {
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
            products: [],
            rows: {
              1: [0],
              2: [1, 2, 3, 4],
              3: [5]
            },
            hover: false
          };
        },
        mounted: function mounted() {
          this.getProducts();
        },
        methods: {
          getProducts: function getProducts() {
            var _this = this;

            _this.loading = true;

            if (_typeof(_this.transient) === 'object') {
              _this.$set(_this, 'products', _this.transient);
            } else {
              _this.$http.post("".concat(x_ajax_url, "?action=x_get_featured_products&module_id=").concat(module_id), _this.posts).then(function (r) {
                _this.$set(_this, 'products', r.body);
              });
            }
          }
        }
      });
    });
  });
})(jQuery);