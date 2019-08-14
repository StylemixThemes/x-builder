<?php
add_filter('x_get_elements', 'x_add_post_list_carousel', 10, 2);

function x_add_post_list_carousel($elements, $is_api)
{

	$terms = ($is_api) ? stm_x_get_terms('category') : array();

	$elements[] = array(
		"module" => "x_post_list_carousel",
		"name" => "Post list carousel",
        "element_color" => "#e440cf",
		"params" => array(
			"fields" => array(
				array(
					"id" => "carousel",
					"type" => "checkbox",
					"label" => "Enable carousel",
					"value" => true,
				),
				array(
					"id" => "categories",
					"type" => "multiselect",
					"label" => "Categories",
					"value" => "",
					"options" => $terms
				),
				array(
					"id" => "total",
					"type" => "text",
					"label" => "Total Posts to show (3 by default)",
					"value" => 3,
				),
			)
		)
	);

	return $elements;
}
