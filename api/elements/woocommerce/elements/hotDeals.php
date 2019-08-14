<?php
add_filter('x_get_elements', 'x_add_hot_deals_element', 10, 2);

function x_add_hot_deals_element($elements, $is_api)
{

    $terms = ($is_api) ? stm_x_get_terms('product_cat') : array();

    $elements[] = array(
        "module" => "x_hot_deals",
        "name" => "Hot Deals",
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
                    "value" => "Hot Deals",
                    "typography" => array('.title')
                ),
                array(
                    "id" => "categories",
                    "type" => "multiselect",
                    "label" => "Categories",
                    "value" => "",
                    "options" => $terms
                ),
                array(
                    "id" => "total",
                    "type" => "text",
                    "label" => "Total Products to show (12 by default)",
                    "value" => 12,
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
                    "value" => "3",
                ),
            )
        )
    );

    return $elements;
}


add_action('wp_ajax_x_get_hot_deals', 'x_get_hot_deals');
add_action('wp_ajax_nopriv_x_get_hot_deals', 'x_get_hot_deals');

function x_get_hot_deals()
{
    require_once STM_X_BUILDER_DIR . "/builder/template.Class.php";
    $r = array();
    $category = (!empty($_GET['term_id'])) ? sanitize_text_field($_GET['term_id']) : '';
    $posts_per_page = (!empty($_GET['total'])) ? intval($_GET['total']) : 8;
    $module_id = (!empty($_GET['module_id'])) ? sanitize_text_field($_GET['module_id']) : '';

    $transient_name = "{$module_id}-{$category}";

    $category = intval($category);

    if (false === ($r = get_transient($transient_name))) {

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $posts_per_page,
            'post__in' => array_merge(array(0), wc_get_product_ids_on_sale())
        );

        if (!empty($category)) {
            $args['tax_query'] = array(
                array(
                    'field' => 'term_id',
                    'taxonomy' => 'product_cat',
                    'terms' => $category
                )
            );
        }

        $q = new WP_Query($args);

        if ($q->have_posts()) {
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

                /*Brands*/
                $brand = array();
                $brands = wp_get_post_terms($id, 'stmt_brand_taxonomy');
                if (!empty($brands) and !is_wp_error($brands)) {
                    $brand = wp_list_pluck($brands, 'name');
                }

                $gallery = $_product->get_gallery_image_ids();
                $gallery = (!empty($gallery)) ? stm_x_builder_get_cropped_image_url($gallery[0], 160, 160) : '';

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
                    'brands' => implode(', ', $brand),
                    'image' => stm_x_builder_get_cropped_image_url(get_post_thumbnail_id(), 160, 160),
                    'buttons' => STM_X_Templates::load_x_template_legal('global/product_buttons', array('id' => $id)),
                    'gallery' => $gallery
                );
            }

            wp_reset_postdata();
        }

        stm_x_set_transient($transient_name, $r);
    }

    wp_send_json($r);
    exit;
}