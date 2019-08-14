<?php
add_filter('x_get_elements', 'stm_x_add_category_banner_element', 10, 2);

function stm_x_add_category_banner_element($elements, $is_api)
{

    $terms = ($is_api) ? stm_x_get_terms_select('product_cat') : array();

    $elements[] = array(
        "module" => "x_category_banner",
        "name" => "Category Banner",
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
                    "typography" => array('.x_category_banner__title')
                ),
                array(
                    "id" => "image",
                    "type" => "image",
                    "label" => "Image (270x220)",
                ),
                array(
                    "id" => "category",
                    "type" => "select",
                    "label" => "Category",
                    "options" => $terms
                ),
                array(
                    "id" => "show_category_name",
                    "type" => "checkbox",
                    "label" => "Show Category name",
                ),
                array(
                    "id" => "show_category_price",
                    "type" => "checkbox",
                    "label" => "Show Category price",
                ),
            )
        )
    );

    return $elements;
}