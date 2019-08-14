(function ($) {
    $(document).ready(function () {

        $('.x_categories_grid').each(function () {

            let $this = $(this);
            let module_id = $(this).data('module');

            new Vue({
                el: $this[0],
                data: function () {
                    return {
                        data: window[module_id],
                        categories: []
                    }
                },
                mounted: function () {
                    this.getCategories();
                },
                methods: {
                    getCategories() {
                        let _this = this;

                        _this.loading = true;

                        _this.$http.post(`${x_ajax_url}?action=stm_x_get_product_categories_grid`, _this.data).then(function (r) {

                            _this.$set(_this, 'categories', r.body);

                            _this.loading = false;

                        });
                    },

                }
            });

        });
    });
})(jQuery);