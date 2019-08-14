(function ($) {
    $(document).ready(function () {

        $('.x_products_sale_carousel').each(function () {

            let $this = $(this);
            let module_id = $(this).data('module');

            new VueW3CValid({
                el: `.${module_id}`
            });

            new Vue({
                el: $this[0],
                data: function () {
                    return {
                        products: [],
                        total: window[module_id]['number_of_items'],
                        transient: window[module_id]['transient'],
                        per_row: window[module_id]['per_row'],
                        per_row_md: window[module_id]['per_row_md'],
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

                        let url = `${x_ajax_url}?action=x_products_sale_carousel&module_id=${module_id}&total=${this.total}`;

                        if (typeof _this.transient === 'object') {
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
                                let $carousels = $('.x_products_sale_carousel__products');
                                let $carousel_prev = $(`.${module_id}`).find('.prev');
                                let $carousel_next = $(`.${module_id}`).find('.next');

                                $carousels.each(function () {
                                    let $carousel = $(this);

                                    if ($carousel.hasClass('owl-carousel')) return false;

                                    if ($carousel[0].childElementCount > 1) {
                                        $carousel.addClass('owl-carousel');
                                        $carousel.imagesLoaded(function () {
                                            _this.loading = false;
                                            $carousel.owlCarousel({
                                                items: 3,
                                                loop: false,
                                                nav: false,
                                                dots: true,
                                                autoplay: false,
                                                margin: 10,
                                                autoplayHoverPause: true,
                                                responsive: {
                                                    0: {
                                                        items: 1,
                                                    },
                                                    768: {
                                                        items: 2
                                                    },
                                                    1120: {
                                                        items: _this.per_row_md
                                                    },
                                                    1400: {
                                                        items: _this.per_row
                                                    }
                                                }
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