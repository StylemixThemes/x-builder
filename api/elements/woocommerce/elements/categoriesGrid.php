<?php
add_filter('x_get_elements', 'stm_x_add_categories_grid_element', 10, 2);

function stm_x_add_categories_grid_element($elements, $is_api)
{

    $terms = ($is_api) ? stm_x_get_terms('product_cat') : array();

    $elements[] = array(
        "module" => "x_categories_grid",
        "name" => "Product Categories Grid",
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
                    "typography" => array('.title'),
                ),
                array(
                    "id" => "texts",
                    "type" => "hidden",
                    "label" => "Text",
                    "typography" => array('.texts'),
                ),
                array(
                    "id" => "categories",
                    "type" => "multiselect",
                    "label" => "Categories",
                    "value" => "",
                    "options" => $terms
                ),
            )
        )
    );

    return $elements;
}

add_action('wp_ajax_stm_x_get_product_categories_grid', 'stm_x_get_product_categories_grid');
add_action('wp_ajax_nopriv_stm_x_get_product_categories_grid', 'stm_x_get_product_categories_grid');

function stm_x_get_product_categories_grid()
{
    $r = array();

    global $wp_filesystem;

    if (empty($wp_filesystem)) {
        require_once (ABSPATH . '/wp-admin/includes/file.php');
        WP_Filesystem();
    }

    $categories = json_decode($wp_filesystem->get_contents('php://input'), true);


    foreach ($categories as $category) {

        $image_id = get_term_meta($category['term_id'], 'x_product_image', true);
        if(empty($image_id)) $image_id = get_term_meta($category['term_id'], 'thumbnail_id', true);

        if(!get_post_status( $image_id )) $image_id = '';

        $placeholder_url = "https://via.placeholder.com/145x170.png";

        $image = (!empty($image_id)) ? stm_x_builder_get_cropped_image_url($image_id, 145, 170, false) : $placeholder_url;

        $term = get_term_by('id', $category['term_id'], 'product_cat');
        if(empty($term) or is_wp_error($term)) continue;

        $info = array(
            'title' => $term->name,
            'image' => $image,
            'permalink' => get_term_link($term),
            'terms' => array()
        );


        $childs = get_term_children($term->term_id, 'product_cat');
        if(!empty($childs)) {
            $childs = array_slice($childs, 0, 5);
            foreach($childs as $child_id) {
                $child_term = get_term_by('id', $child_id, 'product_cat');
                if(empty($child_term) or is_wp_error($child_term)) continue;

                $child_term->permalink = get_term_link($child_term);

                $info['terms'][] = $child_term;
            }
        }

        $r[] = $info;
    }

    wp_send_json($r);
}