<?php
add_filter('x_get_elements', 'x_add_text_element');

function x_add_text_element($elements)
{

	$elements[] = array(
		"module" => "x_text",
		"name"   => "Text",
        "element_color" => "#ff8282",
        "show_params" => array(
            'myText' => array(
                'pre' => esc_html__('Title: ', 'x-builder')
            ),
        ),
		"params" => array(
			"fields" => array(
				array(
					"id"    => "myText",
					"type"  => "editor",
					"label" => "Text",
                    "typography" => array('.myText')
				),
			)
		)
	);
	
	return $elements;
}