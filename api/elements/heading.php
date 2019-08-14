<?php
add_filter('x_get_elements', 'x_add_heading_element');

function x_add_heading_element($elements)
{

	$elements[] = array(
		"module" => "x_heading",
		"name"   => "Heading",
        "element_color" => "#94bd3c",
		"show_params" => array(
		    'heading' => array(
		        'pre' => esc_html__('Heading: ', 'x-builder')
            ),
            'tag' => array(
                'pre' => esc_html__('Tag: H', 'x-builder')
            ),
        ),
		"params" => array(
			"fields" => array(
				array(
					"id"    => "heading",
					"type"  => "text",
					"label" => "Text",
                    "typography" => array('.title')
				),
                array(
                    "id"    => "tag",
                    "type"  => "select",
                    "label" => "Tag",
                    "options" => array(
                        "1" => "H1",
                        "2" => "H2",
                        "3" => "H3",
                        "4" => "H4",
                        "5" => "H5",
                        "6" => "H6",
                    )
                ),
			)
		)
	);
	
	return $elements;
}