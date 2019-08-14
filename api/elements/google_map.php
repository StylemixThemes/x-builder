<?php
add_filter('x_get_elements', 'x_add_google_map_element');

function x_add_google_map_element($elements)
{

    $elements[] = array(
        "module" => "x_google_map",
        "name" => "Google Map",
        "element_color" => "#1cac77",
        "params" => array(
            "fields" => array(
                array(
                    "id" => "latitude",
                    "type" => "text",
                    "label" => "Latitude",
                ),
                array(
                    "id" => "longitude",
                    "type" => "text",
                    "label" => "Longitude",
                ),
                array(
                    "id" => "height",
                    "type" => "number",
                    "label" => "Map height",
                    "value" => "300"
                ),
                array(
                    "id" => "zoom",
                    "type" => "number",
                    "label" => "Map zoom",
                    "value" => 16,
                ),
                array(
                    "id" => "offset_x",
                    "type" => "number",
                    "label" => "Map X Offset",
                ),
                array(
                    "id" => "offset_y",
                    "type" => "number",
                    "label" => "Map Y Offset",
                ),
            )
        )
    );

    return $elements;
}