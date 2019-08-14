(function ($) {
    $(document).ready(function () {

        $('.x_product_grid_with_sync_carousel').each(function () {

            let $this = $(this);
            let module_id = $(this).data('module');

            new Vue({
                el: $this[0],
                data: function () {
                    return {
                        module_id : module_id,
                        products: [],
                        total: window[module_id]['number_of_items'],
                        sort_by: window[module_id]['sort_by'],
                        loading: false,
                        hover: false,
                    }
                },
                computed: {
                    productsRows: function () {
                        let _this = this;
                        let productsLength = _this.products.length;
                        let rows = [];

                        let i,j,chunk = 3;
                        for (i=0,j=productsLength; i<j; i+=chunk) {
                            rows.push(_this.products.slice(i,i+chunk));
                        }

                        return rows;
                    }
                },
                mounted: function () {
                    this.getProducts();
                },
                methods: {
                    getProducts: function (category) {
                        let _this = this;

                        _this.loading = true;

                        let url = `${x_ajax_url}?action=x_product_grid_with_sync_carousel&module_id=${module_id}&total=${this.total}&sort_by=${this.sort_by}`;

                        _this.$http.get(url).then(function (r) {
                            let products = r.body;
                            _this.$set(_this, 'products', products);

                            _this.loading = false;

                            _this.initCarousel();
                        });
                    },
                    initCarousel() {
                        let _this = this;
                        let module_id = $('.' + _this.module_id);

                        Vue.nextTick()
                            .then(function () {
                                let $carousels = $('.x_product_grid_with_sync_carousel__products');
                                let $carousel_prev = module_id.find('.prev');
                                let $carousel_next = module_id.find('.next');

                                $carousels.each(function () {
                                    let $carousel = $(this);

                                    if ($carousel.hasClass('owl-carousel')) return true;

                                    if ($carousel[0].childElementCount > 1) {
                                        $carousel.addClass('owl-carousel');
                                        $carousel.imagesLoaded(function () {
                                            _this.loading = false;
                                            $carousel.owlCarousel({
                                                items: 1,
                                                loop: false,
                                                nav: false,
                                                dots: true,
                                                autoplay: false,
                                                autoplayHoverPause: true,
                                            });

                                            $carousel_prev.on('click', function () {
                                                $carousel.trigger('prev.owl.carousel');
                                            });

                                            $carousel_next.on('click', function () {
                                                $carousel.trigger('next.owl.carousel');
                                            })

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