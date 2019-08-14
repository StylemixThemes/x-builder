<?php
add_filter('x_get_elements', 'x_add_brands_element');

function x_add_brands_element($elements)
{

    $elements[] = array(
        "module" => "x_brands",
        "name" => "Brands",
        "element_color" => "#4a88e4",
        "params" => array(
            "fields" => array(
                array(
                    "id" => "grid",
                    "type" => "checkbox",
                    "label" => esc_html__("Grid View", 'x-builder'),
                    "value" => false,
                ),
                array(
                    "id" => "brands",
                    "type" => "repeater",
                    "label" => "Brands",
                    "options" => array(
                        array(
                            "id" => "image",
                            "type" => "image",
                            "label" => "Brand Image",
                        ),
                        array(
                            "id" => "x_link",
                            "type" => "text",
                            "label" => "Brand Link",
                            "column" => "7"
                        ),
                    )
                ),
            )
        )
    );

    return $elements;
}