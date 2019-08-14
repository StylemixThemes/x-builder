(function ($) {
	$(document).ready(function () {

		$('.x_post_list_carousel.owl-carousel').each(function () {
			if($(this).find('.x_post_list_carousel__item').length > 1){
				$(this).owlCarousel({
					loop: false,
					nav: true,
					dots: false,
					items: 1,
					autoHeight: true
				});
			}
		});
	});
})(jQuery);