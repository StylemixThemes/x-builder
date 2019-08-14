(function ($) {
    $(window).load(function () {

        $('.x_parallax').each(function () {

            let $this = $(this);
            let module_id = $(this).data('module');
            let params = window[module_id];
            let speed = params.speed;

            let rellax = new Rellax("." + module_id, {
                speed: speed,
                center: true,
                vertical: true,
            });

        });
    });
})(jQuery);