<?php
add_filter('x_get_elements', 'x_add_post_list', 10, 2);

function x_add_post_list($elements, $is_api)
{

	$terms = ($is_api) ? stm_x_get_terms('category') : array();

	$elements[] = array(
		"module" => "x_post_list",
		"name" => "Post list",
        "element_color" => "#e84ca1",
		"params" => array(
			"fields" => array(
                array(
                    "id" => "carousel",
                    "type" => "checkbox",
                    "label" => "Enable carousel",
                    "value" => false,
                ),
                array(
                    "id" => "simple",
                    "type" => "checkbox",
                    "label" => "Simple view",
                    "value" => false,
                ),
				array(
					"id" => "title",
					"type" => "text",
					"label" => "Title",
					"value" => "Latest News",
                    "typography" => array('.title')
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
                array(
                    "id" => "words",
                    "type" => "number",
                    "label" => "Trim Words (number of words to display)",
                    "value" => "",
                ),
			)
		)
	);

	return $elements;
}
