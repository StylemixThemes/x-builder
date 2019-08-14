<?php
add_filter('x_get_elements', 'x_add_products_grid_carousel_element', 10, 2);

function x_add_products_grid_carousel_element($elements, $is_api)
{

    $elements[] = array(
        "module" => "x_products_grid_carousel",
        "name" => "Products Grid Carousel",
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
                    "typography" => array('.x_products_grid_carousel__title'),
                ),
            )
        )
    );

    return $elements;
}

add_action('wp_ajax_x_products_grid_carousel', 'x_products_grid_carousel');
add_action('wp_ajax_nopriv_x_products_grid_carousel', 'x_products_grid_carousel');

function x_products_grid_carousel()
{
    require_once STM_X_BUILDER_DIR . "/builder/template.Class.php";
    $module_id = (!empty($_GET['module_id'])) ? sanitize_text_field($_GET['module_id']) : '';

    $transient_name = "{$module_id}";

    if (false === ($r = get_transient($transient_name))) {

        $r = array();

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 8,
        );

        $images = array(
            '558x394',
            '207x277',
            '302x313',
            '560x360',
            '560x360',
            '558x394',
            '207x277',
            '302x313',
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

                $image_dimensions = explode('x', $images[$i]);

                $terms = implode(', ', array_slice(stm_x_get_post_terms_list($id,'product_cat'), 0, 2));

                //Image from Custom Options

                $image_id = get_post_meta($id, 'product_carousel_grid', true);
                if(empty($image_id)) $image_id = get_post_thumbnail_id();

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
                    'terms' => $terms,
                    'image' => stm_x_builder_get_cropped_image_url($image_id, $image_dimensions[0], $image_dimensions[1], false),
                    'buttons' => STM_X_Templates::load_x_template_legal('global/product_buttons', array('id' => $id)),
                    'excerpt' =>  force_balance_tags( html_entity_decode( wp_trim_words( htmlentities( get_the_excerpt() ), 25, '' ) ) )
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