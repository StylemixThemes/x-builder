(function ($) {
    $(document).ready(function () {

        $('.x_grid_products_with_tabs').each(function () {

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
                        carousel: window[module_id]['carousel'],
                        per_row: window[module_id]['per_row'],
                        per_row_tablet_vertical: window[module_id]['per_row_tablet_vertical'],
                        per_row_tablet_horizontal: window[module_id]['per_row_tablet_horizontal'],
                        per_row_tablet_mobile: window[module_id]['per_row_tablet_mobile'],
                        transient: window[module_id]['transient'],
                        active_category: '',
                        products: {},
                        loading: false,
                        hover: false
                    }
                },
                mounted: function () {
                    if (this.categories.length) this.getProducts(this.categories[0], this.transient);
                },
                methods: {
                    getProducts: function (category, transient) {
                        let _this = this;

                        _this.$set(_this, 'active_category', category.term_id);
                        if (typeof _this.products[category.term_id] !== 'undefined' && !_this.carousel) {
                            return;
                        }

                        _this.loading = true;

                        _this.$set(_this.products, category.term_id, []);

                        let url = `${x_ajax_url}?action=x_get_products&term_id=${category.term_id}&total=${this.total}&module_id=${module_id}`;

                        if(typeof transient === 'object') {
                            _this.$set(_this.products, category.term_id, _this.transient);
                            _this.init_carousel();
                        } else {
                            _this.$http.get(url).then(function (r) {
                                let products = r.body;
                                _this.$set(_this.products, category.term_id, products);
                                _this.init_carousel();
                            });
                        }

                    },
                    init_carousel: function () {
                        let _this = this;
                        if (!_this.carousel) {
                            _this.loading = false;
                            return false;
                        }

                        Vue.nextTick()
                            .then(function () {
                                let $carousel = $(`.${module_id} .x_grid_products`);
                                let $carousel_prev = $(`.${module_id}`).find('.prev');
                                let $carousel_next = $(`.${module_id}`).find('.next');

                                if ($carousel.hasClass('owl-loaded')) {
                                    $carousel.find('.owl-item').remove();
                                    $carousel.owlCarousel('destroy');
                                }

                                if (_this.products[_this.active_category].length > 1) {
                                    $carousel.addClass('owl-carousel');
                                    _this.loading = false;
                                    $carousel.imagesLoaded(function () {
                                        $carousel.owlCarousel({
                                            loop: false,
                                            nav: false,
                                            dots: false,
                                            margin: 15,
                                            items: _this.per_row,
                                            autoplay: false,
                                            autoplayHoverPause: true,
                                            responsive: {
                                                0 : {
                                                    items : _this.per_row_tablet_mobile
                                                },
                                                768 : {
                                                    items : _this.per_row_tablet_vertical
                                                },
                                                992 : {
                                                    items : _this.per_row_tablet_horizontal
                                                },
                                                1025 : {
                                                    items : _this.per_row
                                                }
                                            }
                                        });

                                        $carousel_prev.click(function () {
                                            $carousel.trigger('prev.owl.carousel');
                                        });

                                        $carousel_next.click(function () {
                                            $carousel.trigger('next.owl.carousel');
                                        });

                                        if($carousel.find('.x_vertical_product').length <= parseInt(_this.per_row)) {
                                            $carousel_prev.hide();
                                            $carousel_next.hide();
                                        }

                                    });
                                } else {
                                    $carousel.removeClass('owl-carousel');
                                    $carousel_prev.hide();
                                    $carousel_next.hide();
                                    _this.loading = false;
                                }

                            });
                    }
                }
            });

        });
    });
})(jQuery);