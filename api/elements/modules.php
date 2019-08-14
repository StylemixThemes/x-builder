<?php

add_action('init', 'x_load_builder_modules');

function x_load_builder_modules()
{
	$woo_modules = array(
		'gridProductsWithTabs',
        'dealOfTheDay',
        'categoriesCarousel',
        'categoriesGrid',
        'hotDeals',
        'bestSellers',
        'featuredProducts',
        'categoryBanner',
        'productsGridCarousel',
        'productsSaleCarousel',
        'productsFilterGrid',
        'departmentsCarouselWithGridProducts',
        'productGridWithSyncCarousel',
        'productHintImage',
        'productsCarousel',
	);

	if (class_exists('WooCommerce')) {

		foreach ($woo_modules as $module) {
			require_once STM_X_BUILDER_DIR . "/api/elements/woocommerce/elements/{$module}.php";
		}

	}

    if(class_exists('RevSliderFront')) {
        require_once STM_X_BUILDER_DIR . "/api/elements/revslider.php";
    }

    if(defined('WPCF7_VERSION')) {
        require_once STM_X_BUILDER_DIR . "/api/elements/contact_form.php";
    }

}