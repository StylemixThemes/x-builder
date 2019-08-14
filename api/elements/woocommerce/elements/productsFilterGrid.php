<?php
add_filter('x_get_elements', 'x_add_products_filter_grid', 10, 2);
function x_add_products_filter_grid($elements, $is_api)
{
    $terms = ($is_api) ? stm_x_get_terms('product_cat') : array();
    $banners = ($is_api) ? stm_x_get_posts_select('stmt-banners') : array();
    $elements[] = array(
        "module" => "x_products_filter_grid",
        "name" => "Products grid with categories",
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
                    "typography" => array('.title'),
                ),
                array(
                    "id" => "categories",
                    "type" => "multiselect",
                    "label" => "Categories",
                    "value" => "",
                    "options" => $terms
                ),
                array(
                    "id" => "card_bg",
                    "type" => "color",
                    "label" => esc_html__("Product Card Background", 'x-builder'),
                ),
                array(
                    "id" => "banner",
                    "type" => "select",
                    "label" => "Banners",
                    "value" => "",
                    "options" => $banners
                )
            )
        )
    );

    return $elements;
}

add_action('wp_ajax_x_products_filter_grid', 'x_products_filter_grid');
add_action('wp_ajax_nopriv_x_products_filter_grid', 'x_products_filter_grid');

function x_products_filter_grid()
{
    require_once STM_X_BUILDER_DIR . "/builder/template.Class.php";
    $r = array();
    $category = (!empty($_GET['term_id'])) ? intval($_GET['term_id']) : '';

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 5,
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
        $i = 0;
        while ($q->have_posts()) {
            $q->the_post();
            $id = get_the_ID();
            $_product = wc_get_product($id);

            $price = $_product->get_price();
            $regular_price = '';
            $sale_price = null;
            $sale_to = '';
            $discount = '';
            if ($_product->is_on_sale()) {
                $regular_price = $_product->get_regular_price();
                $sale_price = $_product->get_sale_price();

                $sale_to = $_product->get_date_on_sale_to();
                if (!empty($sale_to)) {
                    $current_time = time();
                    $sale_to = strtotime($sale_to);
                    $sale_to = ($current_time < $sale_to) ? date('M j, Y G:i:s', $sale_to) : null;
                }
                $discount = (!empty($sale_price) && !empty($regular_price)) ? intval(100 - ($sale_price * 100 / $regular_price)) : '';
            }

            $sale_price = (!empty($sale_price)) ? strip_tags(wc_price($_product->get_sale_price())) : '';

            $image_width = 280;
            $image_height = 320;
            if ($i == 0) {
                $image_width = 240;
                $image_height = 280;
            }
            $image = stm_x_builder_get_cropped_image_url(get_post_thumbnail_id(), $image_width, $image_height);
            $gallery = $_product->get_gallery_image_ids();
            $gallery = (!empty($gallery)) ? stm_x_builder_get_cropped_image_url($gallery[0], $image_width, $image_height) : '';
            $r[] = array(
                'id' => $id,
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'price' => wc_price($price),
                'regular_price' => wc_price($regular_price),
                'sale_price' => $sale_price,
                'quantity' => $_product->get_stock_quantity(),
                'sale_to' => $sale_to,
                'discount' => $discount,
                'image' => $image,
                'buttons' => STM_X_Templates::load_x_template_legal('global/product_buttons', array('id' => $id)),
                'gallery' => $gallery
            );
            $i++;
        }

        wp_reset_postdata();
    }
    wp_send_json($r);
}