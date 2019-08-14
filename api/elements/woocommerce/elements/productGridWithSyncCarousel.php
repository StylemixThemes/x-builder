<?php
add_filter('x_get_elements', 'x_add_product_grid_with_sync_carousel', 10, 2);

function x_add_product_grid_with_sync_carousel($elements, $is_api)
{

    $elements[] = array(
        "module" => "x_product_grid_with_sync_carousel",
        "name" => "Product Grid With Sync Carousel",
        "group" => "WooCommerce",
        "show_params" => array(
            'title' => array(
                'pre' => esc_html__('Title: ', 'x-builder')
            ),
        ),
        "params" => array(
            "fields" => array(
                array(
                    "id" => "title",
                    "type" => "text",
                    "label" => "Title",
                    "typography" => array('.x_product_grid_with_sync_carousel__title'),
                ),
                array(
                    "id" => "number",
                    "type" => "number",
                    "label" => "Number of items",
                    "value" => 6,
                ),
                array(
                    "id" => "sort_by",
                    "type" => "select",
                    "label" => "Sort by",
                    "options" => array(
                        'latest' => esc_html__('Latest', 'x-builder'),
                        'trending' => esc_html__('Trending', 'x-builder'),
                        'bestsellers' => esc_html__('Bestsellers', 'x-builder'),
                        'rating' => esc_html__('Rating', 'x-builder'),
                    )
                ),
            )
        )
    );

    return $elements;
}

add_action('wp_ajax_x_product_grid_with_sync_carousel', 'x_product_grid_with_sync_carousel');
add_action('wp_ajax_nopriv_x_product_grid_with_sync_carousel', 'x_product_grid_with_sync_carousel');

function x_product_grid_with_sync_carousel()
{

    $module_id = (!empty($_GET['module_id'])) ? sanitize_text_field($_GET['module_id']) : '';
    $per_row = (!empty($_GET['total'])) ? intval($_GET['total']) : 6;

    $sort_by = '';
    if(!empty($_GET['sort_by']) and $_GET['sort_by'] === 'trending') $sort_by = 'trending';
    if(!empty($_GET['sort_by']) and $_GET['sort_by'] === 'rating') $sort_by = 'rating';
    if(!empty($_GET['sort_by']) and $_GET['sort_by'] === 'bestsellers') $sort_by = 'bestsellers';

    $transient_name = "{$module_id}-{$per_row}-{$sort_by}";

    if (false === ($r = get_transient($transient_name))) {

        require_once STM_X_BUILDER_DIR . "/builder/template.Class.php";

        $r = array();

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $per_row,
        );

        if ($sort_by == 'bestsellers') {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        }

        if ($sort_by == 'rating') {
            $args['meta_key'] = '_wc_average_rating';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        }

        if ($sort_by == 'trending') {

            $week_key = "x_builder_product_views_" . stm_x_get_current_week();

            $args['orderby'] = 'meta_value_num';

            $args['meta_query'] = array(
                'relation' => 'OR',
                array(
                    'key' => $week_key,
                    'compare' => 'NOT EXISTS'
                ),
                array(
                    'key' => $week_key,
                    'compare' => 'EXISTS'
                )
            );
        }

        $q = new WP_Query($args);

        if ($q->have_posts()) {
            $i = 0;
            while ($q->have_posts()) {
                $q->the_post();
                $id = get_the_ID();
                $_product = wc_get_product($id);

                $price = $_product->get_price();
                $regular_price = $_product->get_regular_price();
                $sale_price = $_product->get_sale_price();

                $discount = (!empty($sale_price) && !empty($regular_price)) ? intval(100 - ($sale_price * 100 / $regular_price)) : '';

                $sale_price = (!empty($sale_price)) ? strip_tags(wc_price($_product->get_sale_price())) : '';
                $sale_to = $_product->get_date_on_sale_to();
                if (!empty($sale_to)) {
                    $current_time = time();
                    $sale_to = strtotime($sale_to);
                    $sale_to = ($current_time < $sale_to) ? date('M j, Y G:i:s', $sale_to) : null;
                }

                $image_id = get_post_thumbnail_id();
                $image = (!empty($image_id)) ? stm_x_builder_get_cropped_image_url($image_id, 125, 160) : '';

                $gallery = $_product->get_gallery_image_ids();
                $gallery = (!empty($gallery)) ? stm_x_builder_get_cropped_image_url($gallery[0], 125, 160) : '';


                $r[] = array(
                    'id' => $id,
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'price' => strip_tags(wc_price($price)),
                    'regular_price' => strip_tags(wc_price($regular_price)),
                    'sale_price' => $sale_price,
                    'quantity' => $_product->get_stock_quantity(),
                    'sale_to' => $sale_to,
                    'discount' => $discount,
                    'gallery' => $gallery,
                    'img_id' => $image_id,
                    'image' => $image,
                    'buttons' => STM_X_Templates::load_x_template_legal('global/product_buttons', array('id' => $id)),
                );

                $i++;
            }

            wp_reset_postdata();
        }

        stm_x_set_transient($transient_name, $r);
    }

    wp_send_json($r);
    exit;
}