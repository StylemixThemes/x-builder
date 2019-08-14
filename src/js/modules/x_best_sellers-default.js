(function ($) {
    $(document).ready(function () {

        $('.x_best_sellers.default').each(function () {

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
                        rows: [
                            [0, 7, 8],
                            [1, 2, 3],
                            [4, 5, 6],
                        ],
                        products: {},
                        loading: false,
                        hover: false,
                    }
                },
                mounted: function () {
                    if (this.categories.length) {
                        this.getProducts(this.categories[0], this.transient);
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
                    getProducts: function (category, transient) {
                        let _this = this;
                        _this.active_category = category.term_id;

                        if (typeof _this.products[_this.active_category] !== 'undefined') {
                            _this.reinitCarousel();
                            return false;
                        }

                        _this.loading = true;

                        _this.$set(_this.products, category.term_id, []);

                        let url = `${x_ajax_url}?action=stm_x_get_bestsellers&term_id=${category.term_id}&module_id=${module_id}&total=8&style=default`;

                        if(typeof transient === 'object') {
                            _this.$set(_this.products, category.term_id, transient);

                            _this.loading = false;

                            _this.initSmallCarousel();
                        } else {
                            _this.$http.get(url).then(function (r) {
                                let products = r.body;
                                _this.$set(_this.products, category.term_id, products);

                                _this.loading = false;

                                _this.initSmallCarousel();
                            });
                        }
                    },
                    reinitCarousel() {
                        Vue.nextTick()
                            .then(function () {
                                let $carousels = $('.default .x_best_sellers__products_rows1 .x_best_sellers__products');
                                $carousels.each(function() {
                                    let $carousel = $(this);

                                    $carousel.trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
                                    $carousel.find('.owl-stage-outer').children().unwrap();
                                    $carousel.find('.owl-item').each(function(){
                                        $(this).remove();
                                    });

                                    setTimeout(function(){
                                        if ($carousel[0].childElementCount > 1) {
                                            $carousel.addClass('owl-carousel');
                                            $carousel.imagesLoaded(function () {
                                                $carousel.owlCarousel({
                                                    items: 1,
                                                    loop: false,
                                                    nav: false,
                                                    dots: true,
                                                    autoplay: false,
                                                });
                                            });
                                        }
                                    }, 300);
                                });

                            });
                    },
                    initSmallCarousel() {
                        let _this = this;
                        Vue.nextTick()
                            .then(function () {
                                let $carousels = $('.default .x_best_sellers__products_rows1 .x_best_sellers__products');
                                $carousels.each(function() {
                                    let $carousel = $(this);

                                    if($carousel.hasClass('owl-carousel')) return false;

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