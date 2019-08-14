(function ($) {

    $(document).ready(function () {

        $('.x_hint_images').each(function () {
            let $container = $(this);
            $container.imagesLoaded(function () {
                let $pckry = $container.packery({
                    // options
                    itemSelector: '.x_hint_image',
                    vertical: true,
                    percentPosition: true,
                });

            });
        });

    });

})(jQuery);
