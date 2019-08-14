<?php
add_filter('x_get_elements', 'stm_x_add_bestsellers_element', 10, 2);

function stm_x_add_bestsellers_element($elements, $is_api)
{

    $terms = ($is_api) ? stm_x_get_terms('product_cat') : array();
    $banners = ($is_api) ? stm_x_get_posts_select('stmt-banners') : array();

    $elements[] = array(
        "module" => "x_best_sellers",
        "name" => "Products Grid", //Best Seller legacy
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
                    "value" => "Products Grid",
                    "typography" => array('.title')
                ),
                array(
                    "id" => "tabs_style",
                    "type" => "select",
                    "label" => esc_html__("Show tabs as", 'x-builder'),
                    "value" => "icons",
                    "options" => array(
                        'icons' => esc_html__("Icons", 'x-builder'),
                        'buttons' => esc_html__("Buttons", 'x-builder'),
                    )
                ),
                array(
                    "id" => "bestsellers",
                    "type" => "checkbox",
                    "label" => "Include Bestsellers",
                    "value" => "",
                ),
                array(
                    "id" => "popular",
                    "type" => "checkbox",
                    "label" => "Include Popular (sorted by average rating)",
                    "value" => "",
                ),
                array(
                    "id" => "trending",
                    "type" => "checkbox",
                    "label" => "Include Trending (sorted by most views from start of week)",
                    "value" => "",
                ),
                array(
                    "id" => "categories",
                    "type" => "multiselect",
                    "label" => "Categories",
                    "value" => "",
                    "options" => $terms
                ),
                array(
                    "id" => "banner",
                    "type" => "select",
                    "label" => "Banners",
                    "value" => "",
                    "options" => $banners
                ),
                array(
                    "id" => "eight_products",
                    "type" => "checkbox",
                    "label" => "Eight Products Style",
                    "value" => false,
                ),
            )
        )
    );

    return $elements;
}

add_action('wp_ajax_stm_x_get_bestsellers', 'stm_x_get_bestsellers');
add_action('wp_ajax_nopriv_stm_x_get_bestsellers', 'stm_x_get_bestsellers');

function stm_x_get_bestsellers()
{
    require_once STM_X_BUILDER_DIR . "/builder/template.Class.php";
    $module_id = (!empty($_GET['module_id'])) ? sanitize_text_field($_GET['module_id']) : '';
    $category = (!empty($_GET['term_id'])) ? sanitize_text_field($_GET['term_id']) : '';
    $posts_per_page = (!empty($_GET['total'])) ? intval($_GET['total']) : 7;
    $bestsellers = (!empty($_GET['term_id']) and $_GET['term_id'] === 'bestsellers') ? 'bestsellers' : '';
    $popular = (!empty($_GET['term_id']) and $_GET['term_id'] === 'popular') ? 'popular' : '';
    $trending = (!empty($_GET['term_id']) and $_GET['term_id'] === 'trending') ? 'trending' : '';
    $style = (!empty($_GET['style'])) ? sanitize_text_field($_GET['style']) : '';

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

        if (!empty($bestsellers)) {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        }

        if (!empty($popular)) {
            $args['meta_key'] = '_wc_average_rating';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        }

        if (!empty($trending)) {

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

                $image_dims = ($i == 0 || $i == 5 || $i == 7 || $i == 8) ? apply_filters('x_bestsellers_large_image', array(483, 451), $i, $style) : apply_filters('x_bestsellers_small_image', array(240, 275), $i, $style);

                $gallery = $_product->get_gallery_image_ids();
                $gallery = (!empty($gallery)) ? stm_x_builder_get_cropped_image_url($gallery[0], $image_dims[0], $image_dims[1]) : '';

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
                    'image' => stm_x_builder_get_cropped_image_url(get_post_thumbnail_id(), $image_dims[0], $image_dims[1]),
                    'buttons' => STM_X_Templates::load_x_template_legal('global/product_buttons', array('id' => $id)),
                    'gallery' => $gallery,
                    'i' => $i
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