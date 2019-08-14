(function ($) {
    $(document).ready(function () {

        $('.x_products_grid_carousel').each(function () {

            let $this = $(this);
            let module_id = $(this).data('module');

            new VueW3CValid({
                el: `.${module_id}`
            });

            new Vue({
                el: $this[0],
                data: function () {
                    return {
                        transient: window[module_id]['transient'],
                        products: [],
                        rows: [
                            [0],
                            [1, 2, 3],
                            [5],
                            [6, 7, 4],
                        ],
                        loading: false
                    }
                },
                mounted: function () {
                    this.getProducts();
                },
                methods: {
                    getProducts: function (category) {
                        let _this = this;

                        _this.loading = true;


                        let url = `${x_ajax_url}?action=x_products_grid_carousel&module_id=${module_id}`;

                        if(typeof _this.transient === 'object') {
                            _this.$set(_this, 'products', _this.transient);

                            _this.loading = false;

                            _this.initCarousel();
                        } else {
                            _this.$http.get(url).then(function (r) {
                                let products = r.body;
                                _this.$set(_this, 'products', products);

                                _this.loading = false;

                                _this.initCarousel();
                            });
                        }
                    },
                    initCarousel() {
                        let _this = this;

                        Vue.nextTick()
                            .then(function () {
                                let $carousels = $('.x_products_grid_carousel__rows');
                                $carousels.each(function () {
                                    let $carousel = $(this);

                                    if ($carousel.hasClass('owl-carousel')) return false;

                                    if ($carousel[0].childElementCount > 1) {
                                        $carousel.addClass('owl-carousel');
                                        $carousel.imagesLoaded(function () {
                                            _this.loading = false;
                                            $carousel.owlCarousel({
                                                loop: false,
                                                nav: false,
                                                dots: true,
                                                autoWidth: true,
                                                autoplay: false,
                                                responsive : {
                                                    0 : {
                                                        autoWidth: false,
                                                        autoHeight: true,
                                                        items : 1,
                                                        margin: 0
                                                    },
                                                    800 : {
                                                        autoWidth: true,
                                                        autoHeight: false,
                                                    }
                                                }
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