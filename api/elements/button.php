<?php
add_filter('x_get_elements', 'x_add_button_element');

function x_add_button_element($elements)
{

	$elements[] = array(
		"module" => "x_button",
		"name"   => "Button",
        "element_color" => "#6664cd",
		"params" => array(
			"fields" => array(
				array(
					"id"    => "label",
					"type"  => "text",
					"label" => "Button Label",
                    "typography" => array('.btn')
				),
                array(
                    "id"    => "link",
                    "type"  => "text",
                    "label" => "Button Link",
                ),
                array(
                    "id"    => "type",
                    "type"  => "select",
                    "label" => "Button Type",
                    "options" => array(
                        "primary" => esc_html__('Solid', 'stmt_theme'),
                        "outline" => esc_html__('Outline', 'stmt_theme'),
                    ),
                    "value" => "solid"
                ),
                array(
                    "id"    => "color",
                    "type"  => "color",
                    "label" => "Button Color",
                ),
                array(
                    "id"    => "color_hover",
                    "type"  => "color",
                    "label" => "Button Color on Hover",
                ),
                array(
                    "id"    => "border_color",
                    "type"  => "color",
                    "label" => "Button Border Color",
                ),
                array(
                    "id"    => "border_color_hover",
                    "type"  => "color",
                    "label" => "Button Border Color on Hover",
                ),
                array(
                    "id"    => "background_color",
                    "type"  => "color",
                    "label" => "Button Background Color",
                ),
                array(
                    "id"    => "background_color_hover",
                    "type"  => "color",
                    "label" => "Button Background Color on Hover",
                ),
                array(
                    "id"    => "inline",
                    "type"  => "checkbox",
                    "label" => "Inline Button",
                ),
			)
		)
	);
	
	return $elements;
}