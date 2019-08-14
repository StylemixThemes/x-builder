(function ($) {
    $(document).ready(function () {

        $('.x_hot_deals').each(function () {

            let $this = $(this);
            let module_id = $(this).data('module');

            new VueW3CValid({
                el: `.${module_id}`
            });

            new Vue({
                el: $this[0],
                data: function () {
                    return {
                        categories: window[module_id]['categories'],
                        total: window[module_id]['total'],
                        per_row: window[module_id]['per_row'],
                        transient: window[module_id]['transient'],
                        active_category: '',
                        products: {},
                        loading: false,
                        hover: false
                    }
                },
                mounted: function () {
                    if (this.categories.length) {
                        this.getProducts(this.categories[0], this.transient);
                    }
                },
                methods: {

                    getProducts: function (category, transient) {
                        let _this = this;
                        _this.active_category = category.term_id;

                        if (typeof _this.products[_this.active_category] !== 'undefined') return false;

                        _this.loading = true;

                        _this.$set(_this.products, category.term_id, []);

                        let url = `${x_ajax_url}?action=x_get_hot_deals&term_id=${category.term_id}&total=${this.total}&module_id=${module_id}`;

                        if (typeof transient === 'object') {
                            _this.$set(_this.products, category.term_id, _this.transient);

                            _this.loading = false;
                        } else {
                            _this.$http.get(url).then(function (r) {
                                let products = r.body;
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