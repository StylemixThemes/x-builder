<?php
add_filter('x_get_elements', 'x_add_widget_element', 10, 2);

function x_add_widget_element($elements, $is_api)
{

    $widgets_data = array();

    if($is_api and !empty ( $GLOBALS['wp_widget_factory'] )) {

        $widgets =  $GLOBALS['wp_widget_factory']->widgets;
        foreach($widgets as $widget_key => $widget) {
            $widgets_data[$widget_key] = $widget->name;
        }

    }

    $elements[] = array(
        "module" => "x_widget",
        "name"   => "Widget",
        "element_color" => "#1c9dac",
        "params" => array(
            "fields" => array(
                array(
                    "id"    => "widget",
                    "type"  => "select",
                    "label" => "Widget",
                    "options" => $widgets_data,
                ),
                array(
                    "id"    => "widget_text",
                    "type"  => "text",
                    "label" => "Widget Title",
                    "typography" => array('.widget .widget-title', '.widget .widget_title', '.widget .widgettitle'),
                ),
                array(
                    "id"    => "widget_text_color",
                    "type"  => "hidden",
                    "label" => "Widget Styles",
                    "typography" => array('.widget_text_color'),
                ),
            )
        )
    );

    return $elements;
}