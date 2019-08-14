<?php
add_filter('x_get_elements', 'x_add_hint_images_element');

function x_add_hint_images_element($elements)
{

	$elements[] = array(
		"module" => "x_hint_images",
		"name"   => "Hint Images",
        "element_color" => "#ca8519",
		"params" => array(
			"fields" => array(
				array(
					"id"    => "images",
					"type"  => "repeater",
					"options" => array(
                        array(
                            "id"    => "image",
                            "type"  => "hint_image",
                            "label" => "Image",
                        ),
                    )
				),
			)
		)
	);
	
	return $elements;
}