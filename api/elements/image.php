<?php
add_filter('x_get_elements', 'x_add_image_element');

function x_add_image_element($elements)
{

	$elements[] = array(
		"module" => "x_image",
		"name"   => "Image",
        "element_color" => "#ff357c",
		"box_shadow" => 'img',
		"params" => array(
			"fields" => array(
				array(
					"id"    => "image",
					"type"  => "image",
					"label" => "Image",
				),
                array(
                    "id"    => "width",
                    "type"  => "number",
                    "label" => "Image Width",
                ),
                array(
                    "id"    => "height",
                    "type"  => "number",
                    "label" => "Image Height",
                ),
                array(
                    "id"    => "align",
                    "type"  => "select",
                    "label" => "Image Align",
                    "options" => array(
                        'left' => esc_html__('Left', 'STM_X_Builder_Front'),
                        'right' => esc_html__('Right', 'STM_X_Builder_Front'),
                        'center' => esc_html__('Center', 'STM_X_Builder_Front'),
                    )
                ),
                array(
                    "id"    => "style",
                    "type"  => "select",
                    "label" => "Image Style",
                    "options" => array(
                        'normal' => esc_html__('Normal', 'STM_X_Builder_Front'),
                        'rounded_with_shadow' => esc_html__('Rounded with Shadow', 'STM_X_Builder_Front'),
                    )
                ),
                array(
                    "id"    => "width_md",
                    "type"  => "number",
                    "label" => "Image Width on Laptop",
                ),
			)
		)
	);
	
	return $elements;
}