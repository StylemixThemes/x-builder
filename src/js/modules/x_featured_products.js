(function ($) {
    $(document).ready(function () {

        $('.x_featured_products').each(function () {

            let $this = $(this);
            let module_id = $(this).data('module');

            new VueW3CValid({
                el: `.${module_id}`
            });

            new Vue({
                el: $this[0],
                data: function () {
                    return {
                        posts: window[module_id]['posts'],
                        transient: window[module_id]['transient'],
                        products: [],
                        rows : {
                            1 : [0],
                            2 : [1, 2, 3, 4],
                            3 : [5],
                        },
                        hover: false
                    }
                },
                mounted: function () {
                    this.getProducts();
                },
                methods: {
                    getProducts() {
                        let _this = this;

                        _this.loading = true;

                        if(typeof _this.transient === 'object') {
                            _this.$set(_this, 'products', _this.transient);
                        } else {
                            _this.$http.post(`${x_ajax_url}?action=x_get_featured_products&module_id=${module_id}`, _this.posts).then(function (r) {
                                _this.$set(_this, 'products', r.body);
                            });
                        }
                    },
                }
            });

        });
    });
})(jQuery);