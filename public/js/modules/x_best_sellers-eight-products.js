"use strict";

(function ($) {
  $(document).ready(function () {
    $('.x_best_sellers.eight-products').each(function () {
      var $this = $(this);
      var module_id = $(this).data('module');
      new Vue({
        el: $this[0],
        data: function data() {
          return {
            categories: window[module_id]['categories'],
            active_category: '',
            rows: [[0, 1, 2, 3], [4, 5, 6, 7]],
            products: {},
            loading: false,
            hover: false
          };
        },
        mounted: function mounted() {
          if (this.categories.length) {
            this.getProducts(this.categories[0]);
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
          getProducts: function getProducts(category) {
            var _this = this;

            _this.active_category = category.term_id;

            if (typeof _this.products[_this.active_category] !== 'undefined') {
              _this.reinitCarousel();

              return false;
            }

            _this.loading = true;

            _this.$set(_this.products, category.term_id, []);

            var url = "".concat(x_ajax_url, "?action=stm_x_get_bestsellers&term_id=").concat(category.term_id, "&module_id=").concat(module_id, "&total=8&style=eight_products");

            _this.$http.get(url).then(function (r) {
              var products = r.body;

              _this.$set(_this.products, category.term_id, products);

              _this.loading = false;
            });
          }
        }
      });
    });
  });
})(jQuery);