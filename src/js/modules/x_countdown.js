(function ($) {
    $(document).ready(function () {

        $('.x_countdown').each(function () {

            let $this = $(this);
            let module_id = $(this).data('module');

            new Vue({
                el: $this[0],
                data: function () {
                    return {
                        categories: '',
                    }
                },
                mounted: function () {

                },
                methods: {

                }
            });

        });
    });
})(jQuery);