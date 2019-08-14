(function ($) {
	$(document).ready(function () {

		$('.x_products_filter_grid').each(function () {

			let $this = $(this);
			let module_id = $(this).data('module');

			new Vue({
				el: $this[0],
				data: function () {
					return {
						categories: window[module_id]['categories'],
						banner: window[module_id]['banner'],
						products: {},
						active_category: '',
						rows: [
							[0, 1, 2],
							[3, 4]
						],
						loading: true,
						hover: true,
					}
				},
				mounted: function () {
					if (this.categories.length) this.getProducts(this.categories[0].term_id);
				},
				methods: {
					getProducts: function (category) {
						let _this = this;
						_this.active_category = category;
						if (typeof _this.products[_this.active_category] !== 'undefined') return false;
						_this.loading = true;
						let url = `${x_ajax_url}?action=x_products_filter_grid&term_id=${category}`;

						_this.$http.get(url).then(function (r) {
							let products = r.body;
							_this.$set(_this.products, category, products);
							_this.loading = false;
						});

					},

				}
			});

		});
	});
})(jQuery);