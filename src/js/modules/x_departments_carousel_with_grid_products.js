(function ($) {
    $(document).ready(function () {

        $('.x_departments_carousel_with_grid_products').each(function () {

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
                        transient: window[module_id]['transient'],
                        active_category: '',
                        products: {},
                        loading: false,
                        hover: false,
                    }
                },
                mounted: function () {
                    this.initCarousel();
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

                        let url = `${x_ajax_url}?action=x_get_products_departments&term_id=${category.term_id}&module_id=${module_id}`;

                        if(typeof transient === 'object') {
                            _this.$set(_this.products, category.term_id, this.transient);
                        } else {
                            _this.$http.get(url).then(function (r) {
                                let products = r.body;
                                _this.$set(_this.products, category.term_id, products);
                                if (!products.length) {
                                    _this.$set(_this.products, category.term_id, 'empty');
                                }
                            });
                        }

                    },
                    initCarousel: function () {
                        let _this = this;

                        Vue.nextTick()
                            .then(function () {
                                let $carousel = $(`.${module_id} .x_departments_carousel_with_grid_products__categories`);

                                $carousel.addClass('owl-carousel');
                                _this.loading = false;
                                $carousel.owlCarousel({
                                    loop: true,
                                    nav: true,
                                    dots: false,
                                    margin: 0,
                                    slideBy : 1,
                                    items: _this.per_row,
                                    responsive : {
                                        0 : {
                                            items : 2,
                                            margin: 0,
                                        },
                                        600 : {
                                            items : 4,
                                            margin: 0,
                                        },
                                        800 : {
                                            items : 5,
                                            margin: 0,
                                        },
                                        1000 : {
                                            items : 6,
                                            margin: 0,
                                        },
                                        1200 : {
                                            items : 7,
                                            margin: 0,
                                        },
                                        1300 : {
                                            items : 8,
                                            margin: 0,
                                        },
                                        1440 : {
                                            items : 9,
                                            margin: 0,
                                        },
                                        1800: {
                                            items : 10,
                                            margin: 0,
                                        },
                                        1900: {
                                            items : 11,
                                            margin: 0,
                                        }
                                    }
                                });

                            });
                    }
                }
            });

        });
    });
})(jQuery);