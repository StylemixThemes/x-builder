<?php
add_filter('x_get_elements', 'x_add_grid_products_with_tabs_element', 10, 2);

function x_add_grid_products_with_tabs_element($elements, $is_api)
{

    $terms = ($is_api) ? stm_x_get_terms('product_cat') : array();

    $elements[] = array(
        "module" => "x_grid_products_with_tabs",
        "name" => "Products in tabs",
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
                    "label" => esc_html__("Module Title", 'x-builder'),
                    "value" => '',
                    "typography" => array('.x_grid_products_with_tabs__title')
                ),
                array(
                    "id" => "latest",
                    "type" => "checkbox",
                    "label" => "Include Latest Products",
                    "value" => false,
                ),
                array(
                    "id" => "last_chance",
                    "type" => "checkbox",
                    "label" => "Include Products with low quantity (<5)",
                    "value" => false,
                ),
                array(
                    "id" => "recently_viewed",
                    "type" => "checkbox",
                    "label" => "Include Recently Viewed Products",
                    "value" => false,
                ),
                array(
                    "id" => "carousel",
                    "type" => "checkbox",
                    "label" => "Show Products in carousel",
                    "value" => false,
                ),
                array(
                    "id" => "total",
                    "type" => "text",
                    "label" => "Total Products to show (8 by default)",
                    "value" => 8,
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
                    "id" => "product_view",
                    "type" => "select",
                    "label" => "Product view",
                    "options" => array(
                        'vertical' => esc_html__('Vertical', 'x-builder'),
                        'horizontal' => esc_html__('Horizontal', 'x-builder'),
                    ),
                    "value" => "vertical",
                ),
                array(
                    "id" => "categories",
                    "type" => "multiselect",
                    "label" => "Categories",
                    "value" => "",
                    "options" => $terms
                ),
                array(
                    "id" => "per_row_tablet_horizontal",
                    "type" => "select",
                    "label" => "Products Per Row in carousel Horizontal Tablet",
                    "options" => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    ),
                    "value" => "2",
                ),
                array(
                    "id" => "per_row_tablet_vertical",
                    "type" => "select",
                    "label" => "Products Per Row in carousel Vertical Tablet",
                    "options" => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    ),
                    "value" => "2",
                ),
                array(
                    "id" => "per_row_tablet_mobile",
                    "type" => "select",
                    "label" => "Products Per Row in carousel Mobile",
                    "options" => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    ),
                    "value" => "1",
                ),
            )
        )
    );

    return $elements;
}


add_action('wp_ajax_x_get_products', 'x_get_products');
add_action('wp_ajax_nopriv_x_get_products', 'x_get_products');

function x_get_products()
{
    require_once STM_X_BUILDER_DIR . "/builder/template.Class.php";

    $category = (!empty($_GET['term_id'])) ? sanitize_text_field($_GET['term_id']) : '';
    $posts_per_page = (!empty($_GET['total'])) ? intval($_GET['total']) : 8;
    $last_chance = (!empty($_GET['term_id']) and $_GET['term_id'] === 'last_chance') ? 'last_chance' : '';
    $recently_viewed = (!empty($_GET['term_id']) and $_GET['term_id'] === 'recently_viewed') ? 'recently_viewed' : '';
    $module_id = (!empty($_GET['module_id'])) ? sanitize_text_field($_GET['module_id']) : '';

    $transient_name = "{$module_id}-{$category}";

    $category = intval($category);

    if (false === ($r = get_transient($transient_name))) {

        $r = array();

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $posts_per_page,
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

        if (!empty($last_chance)) {
            $args['meta_query'] = array(
                'relation' => 'AND',
                array(
                    'key' => '_stock',
                    'value' => 5,
                    'compare' => '<='
                ),
                array(
                    'key' => '_stock',
                    'value' => 0,
                    'compare' => '>'
                )
            );
        }

        if (!empty($recently_viewed)) {
            $cookie_name = 'x_builder_viewed_products_' . get_current_blog_id();

            if (empty($_COOKIE[$cookie_name])) {
                $args['orderby'] = 'rand';
            } else {
                $args['orderby'] = 'post__in';
                $args['post__in'] = explode('|', sanitize_text_field($_COOKIE[$cookie_name]));
            }

        }

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

                $gallery = $_product->get_gallery_image_ids();
                $gallery = (!empty($gallery)) ? stm_x_builder_get_cropped_image_url($gallery[0], 241, 268) : '';

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
                    'image' => stm_x_builder_get_cropped_image_url(get_post_thumbnail_id(), 242, 269),
                    'buttons' => STM_X_Templates::load_x_template_legal('global/product_buttons', array('id' => $id)),
                    'gallery' => $gallery
                );

            }

            wp_reset_postdata();
        }

        if(empty($r)) {
            $r = array(
                'message' => esc_html__('No products in this category', 'x-builder')
            );
        }

        stm_x_set_transient($transient_name, $r);
    }

    if (!empty($recently_viewed)) {
        delete_transient($transient_name);
    }

    wp_send_json($r);
    exit;
}