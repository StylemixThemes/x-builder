(function ($) {
    $(document).ready(function () {

        $('.x_categories_carousel').each(function () {

            let $this = $(this);
            let module_id = $(this).data('module');

            new VueW3CValid({
                el: `.${module_id}`
            });

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

                        _this.$http.post(`${x_ajax_url}?action=x_get_product_categories`, _this.data).then(function (r) {

                            _this.$set(_this, 'categories', r.body);
                            _this.carousel();
                        });
                    },
                    carousel() {
                        let _this = this;
                        Vue.nextTick()
                            .then(function () {

                                _this.loading = true;

                                let $carousel = $(`.${module_id} .x_categories_carousel__items`);

                                if (_this.categories.length > 1) {
                                    $carousel.imagesLoaded(function () {
                                        _this.loading = false;
                                        $carousel.owlCarousel({
                                            loop: false,
                                            nav: true,
                                            dots: true,
                                            margin: 15,
                                            autoplay: false,
                                            autoplayHoverPause: true,
                                            responsive: {
                                                0: {
                                                    items: 1,
                                                    margin: 10,
                                                    autoHeight: true,
                                                    autoWidth: false,
                                                },
                                                767: {
                                                    autoHeight: false,
                                                    autoWidth: true,
                                                }
                                            }
                                        });
                                    });
                                } else {
                                    $carousel.removeClass('owl-carousel');
                                    _this.loading = false;
                                }
                            });
                    }
                }
            });

        });
    });
})(jQuery);