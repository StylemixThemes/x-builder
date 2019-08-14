(function ($) {
    $(document).ready(function () {

        $('.x_best_sellers.eight-products').each(function () {

            let $this = $(this);
            let module_id = $(this).data('module');

            new Vue({
                el: $this[0],
                data: function () {
                    return {
                        categories: window[module_id]['categories'],
                        active_category: '',
                        rows: [
                            [0, 1, 2, 3],
                            [4, 5, 6, 7],
                        ],
                        products: {},
                        loading: false,
                        hover: false,
                    }
                },
                mounted: function () {
                    if (this.categories.length) {
                        this.getProducts(this.categories[0]);
                    }
                },
                methods: {
	                rowClasses(row_num) {
	                    let _this = this;
	                    let classes = ['x_best_sellers__products_rows' + (row_num + 1)];

	                    /*get Row 1 items*/
                        let count = 0;
                        _this.rows[row_num].forEach(function(product_index) {
                            if(typeof _this.products[_this.active_category][product_index] !== 'undefined') count++;
                        });

                        classes.push(`row_items_${count}`);

	                    return classes;
                    },
                    getProducts: function (category) {
                        let _this = this;
                        _this.active_category = category.term_id;

                        if (typeof _this.products[_this.active_category] !== 'undefined') {
                            _this.reinitCarousel();
                            return false;
                        }

                        _this.loading = true;

                        _this.$set(_this.products, category.term_id, []);

                        let url = `${x_ajax_url}?action=stm_x_get_bestsellers&term_id=${category.term_id}&module_id=${module_id}&total=8&style=eight_products`;

                        _this.$http.get(url).then(function (r) {
                            let products = r.body;
                            _this.$set(_this.products, category.term_id, products);

                            _this.loading = false;

                        });
                    },
                }
            });

        });
    });
})(jQuery);