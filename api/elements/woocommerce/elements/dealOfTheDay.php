<?php
add_filter('x_get_elements', 'stm_x_add_deal_of_the_day_element', 10, 2);

function stm_x_add_deal_of_the_day_element($elements, $is_api)
{

    $posts = (!$is_api) ? array() : stm_x_get_posts('product');

	$elements[] = array(
		"module" => "x_deal_of_the_day",
		"name"   => "Deal Of The Day",
        "group" => "WooCommerce",
        "show_params" => array(
            'title' => array(
                'pre' => esc_html__('Title: ', 'x-builder')
            ),
        ),
		"params" => array(
			"fields" => array(
				array(
					"id"    => "title",
					"type"  => "text",
					"label" => "Title",
					"value" => "Deal Of The Day",
                    "typography" => array('.title')
				),
                array(
                    "id"    => "posts",
                    "type"  => "multiselect",
                    "label" => "Posts To Show",
                    "value" => "",
                    "options" => $posts
                )
			)
		)
	);

	return $elements;
}

add_action('wp_ajax_x_deal_of_the_day', 'x_deal_of_the_day');
add_action('wp_ajax_nopriv_x_deal_of_the_day', 'x_deal_of_the_day');

function x_deal_of_the_day() {
    $r = array();


    global $wp_filesystem;

    if (empty($wp_filesystem)) {
        require_once (ABSPATH . '/wp-admin/includes/file.php');
        WP_Filesystem();
    }

    $data = json_decode($wp_filesystem->get_contents('php://input'), true);

    $posts = $data['posts'];
    $module_id = $data['module_id'];
    $transient_name = "{$module_id}";

    if (false === ($r = get_transient($transient_name))) {
        $args = array(
            'post_type' => 'product',
            'post__in' => wp_list_pluck($posts, 'term_id'),
            'orderby' => 'post__in',
            'posts_per_page' => count($posts)
        );

        $q = new WP_Query($args);

        if ($q->have_posts()) {
            while ($q->have_posts()) {
                $q->the_post();
                $id = get_the_ID();
                $_product = wc_get_product($id);

                $sale_price = $_product->get_sale_price();
                $sale_price = (!empty($sale_price)) ? strip_tags(wc_price($_product->get_sale_price())) : '';
                $sale_to = $_product->get_date_on_sale_to();
                if (!empty($sale_to)) {
                    $current_time = time();
                    $sale_to = strtotime($sale_to);
                    $sale_to = ($current_time < $sale_to) ? date('M j, Y G:i:s', $sale_to) : null;
                }

                /*Brands*/
                $brand = array();
                $brands = wp_get_post_terms($id, 'stmt_brand_taxonomy');
                if (!empty($brands) and !is_wp_error($brands)) {
                    $brand = wp_list_pluck($brands, 'name');
                }

                $r[] = array(
                    'id' => $id,
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'price' => strip_tags(wc_price($_product->get_price())),
                    'regular_price' => strip_tags(wc_price($_product->get_regular_price())),
                    'sale_price' => $sale_price,
                    'quantity' => $_product->get_stock_quantity(),
                    'sale_to' => $sale_to,
                    'brands' => implode(', ', $brand),
                    'image' => stm_x_builder_get_cropped_image_url(get_post_thumbnail_id(), 410, 530),
                );

            }

            wp_reset_postdata();
        }

        stm_x_set_transient($transient_name, $r);
    }

    wp_send_json($r);
}