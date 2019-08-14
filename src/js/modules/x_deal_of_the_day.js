(function ($) {
    $(document).ready(function () {

        $('.x_deal_of_the_day').each(function () {

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
                        products: []
                    }
                },
                mounted: function () {
                    this.getProducts(this.transient);
                },
                methods: {
                    getProducts(transient) {
                        let _this = this;

                        _this.loading = true;

                        let data = {
                            'posts': _this.posts,
                            'module_id': module_id
                        };

                        if (typeof transient === 'object') {
                            _this.$set(_this, 'products', transient);
                            _this.carousel();
                        } else {
                            _this.$http.post(`${x_ajax_url}?action=x_deal_of_the_day`, data).then(function (r) {
                                _this.$set(_this, 'products', r.body);
                                _this.carousel();
                            });
                        }
                    },
                    carousel() {
                        let _this = this;
                        Vue.nextTick()
                            .then(function () {
                                let $carousel = $(`.${module_id} .x_deal_of_the_day__posts`);

                                if (_this.products.length > 1) {
                                    $carousel.imagesLoaded(function () {
                                        $carousel.owlCarousel({
                                            loop: true,
                                            nav: false,
                                            dots: true,
                                            items: 1,
                                            margin: 15,
                                            autoplay: true,
                                            autoplayHoverPause: true,
                                            singleItem: true,
                                            autoHeight: true
                                        });
                                    });
                                } else {
                                    $carousel.removeClass('owl-carousel');
                                }

                                _this.loading = false;
                            });

                    }
                }
            });

        });
    });
})(jQuery);