<?php
add_filter('x_get_elements', 'x_add_featured_products_element', 10, 2);

function x_add_featured_products_element($elements, $is_api)
{

    $posts = (!$is_api) ? array() : stm_x_get_posts('product');

    $elements[] = array(
        "module" => "x_featured_products",
        "name" => "Featured Products",
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
                    "value" => "Featured Products",
                    "typography" => array('.title')
                ),
                array(
                    "id" => "posts",
                    "type" => "multiselect",
                    "label" => "Posts To Show",
                    "value" => "",
                    "options" => $posts
                )
            )
        )
    );

    return $elements;
}


add_action('wp_ajax_x_get_featured_products', 'x_get_featured_products');
add_action('wp_ajax_nopriv_x_get_featured_products', 'x_get_featured_products');

function x_get_featured_products()
{

    global $wp_filesystem;

    if (empty($wp_filesystem)) {
        require_once (ABSPATH . '/wp-admin/includes/file.php');
        WP_Filesystem();
    }

    require_once STM_X_BUILDER_DIR . "/builder/template.Class.php";
    $posts = json_decode($wp_filesystem->get_contents('php://input'), true);
    $module_id = (!empty($_GET['module_id'])) ? sanitize_text_field($_GET['module_id']) : '';

    $transient_name = "{$module_id}";

    if (false === ($r = get_transient($transient_name))) {
        $args = array(
            'post_type' => 'product',
            'post__in' => wp_list_pluck($posts, 'term_id'),
            'orderby' => 'post__in',
            'posts_per_page' => count($posts)
        );

        $r = array();


        if (!empty($bestsellers)) {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        }

        $images = array(
            array(315, 355),
            array(190, 240),
            array(190, 240),
            array(190, 240),
            array(190, 240),
            array(320, 380),
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

                $gallery = $_product->get_gallery_image_ids();
                $gallery = (!empty($gallery)) ? stm_x_builder_get_cropped_image_url($gallery[0], $images[$i][0], $images[$i][1]) : '';

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
                    'image' => stm_x_builder_get_cropped_image_url(get_post_thumbnail_id(), $images[$i][0], $images[$i][1]),
                    'dims' => $images[$i],
                    'buttons' => STM_X_Templates::load_x_template_legal('global/product_buttons', array('id' => $id)),
                    'gallery' => $gallery
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