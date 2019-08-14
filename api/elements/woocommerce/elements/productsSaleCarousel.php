<?php
add_filter('x_get_elements', 'x_add_products_sale_carousel_element', 10, 2);

function x_add_products_sale_carousel_element($elements, $is_api)
{

    $elements[] = array(
        "module" => "x_products_sale_carousel",
        "name" => "Products Sale Carousel",
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
                    "typography" => array('.x_products_sale_carousel__title'),
                ),
                array(
                    "id" => "per_row",
                    "type" => "select",
                    "label" => "Products Per Row",
                    "options" => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    ),
                    "value" => "4",
                ),
                array(
                    "id" => "per_row_md",
                    "type" => "select",
                    "label" => "Products Per Row Notebook",
                    "options" => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    ),
                    "value" => "3",
                ),
                array(
                    "id" => "number",
                    "type" => "number",
                    "label" => "Number of items",
                    "value" => 6,
                ),
            )
        )
    );

    return $elements;
}

add_action('wp_ajax_x_products_sale_carousel', 'x_products_sale_carousel');
add_action('wp_ajax_nopriv_x_products_sale_carousel', 'x_products_sale_carousel');

function x_products_sale_carousel()
{
    $module_id = (!empty($_GET['module_id'])) ? sanitize_text_field($_GET['module_id']) : '';
    $per_row = (!empty($_GET['total'])) ? intval($_GET['total']) : 6;

    $transient_name = "{$module_id}-{$per_row}";

    if (false === ($r = get_transient($transient_name))) {

        $r = array();

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $per_row,
        );

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
                    'image' => stm_x_builder_get_cropped_image_url($image_id, 220, 276),
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