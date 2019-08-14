<?php
add_filter('x_get_elements', 'x_add_countdown_element');

function x_add_countdown_element($elements)
{

    $elements[] = array(
        "module" => "x_countdown",
        "name" => "Countdown",
        "element_color" => "#26c5b8",
        "params" => array(
            "fields" => array(
                array(
                    "id" => "time",
                    "type" => "time",
                    "label" => "Time",
                ),
                array(
                    "id" => "date",
                    "type" => "date",
                    "label" => "Date",
                ),
            )
        )
    );

    return $elements;
}