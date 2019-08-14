<?php

add_filter('x_get_elements', 'x_add_product_hint_image', 10, 2);

function x_add_product_hint_image( $elements, $is_api ){
    $posts = (!$is_api) ? array() : stm_x_get_posts('product');
    $products = array();
    foreach ($posts as $post){
        $products[$post['term_id']] = $post['name'];
    }
    $elements[] = array(
        "module" => "x_product_hint_image",
        "name"   => "Product Width Hint",
        "group" => "WooCommerce",
        "params" => array(
            "fields" => array(
                array(
                    "id"    => "price",
                    "type"  => "checkbox",
                    "label" => "Add Price",
                    "value" => false,
                ),
                array(
                    "id"    => "product",
                    "type"  => "select",
                    "label" => "Post To Show",
                    "value" => "",
                    "options" => $products
                ),
                array(
                    "id"    => "width",
                    "type"  => "number",
                    "label" => "Image Width",
                    "value" => 740,
                ),
                array(
                    "id"    => "height",
                    "type"  => "number",
                    "label" => "Image Height",
                    "value" => 400,
                ),
            )
        )
    );

    return $elements;
}