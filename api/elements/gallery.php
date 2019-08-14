<?php
add_filter('x_get_elements', 'x_add_gallery_element');

function x_add_gallery_element($elements)
{

    $elements[] = array(
        "module" => "x_gallery",
        "name" => "Gallery",
        "element_color" => "#6f87ff",
        "params" => array(
            "fields" => array(
                array(
                    "id" => "categories",
                    "type" => "repeater",
                    "label" => "Categories",
                    "options" => array(
                        array(
                            "id" => "category",
                            "type" => "text",
                            "label" => "Category title",
                        ),
                    )
                ),
            )
        )
    );

    return $elements;
}