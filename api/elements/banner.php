<?php
add_filter('x_get_elements', 'x_add_banner_element');

function x_add_banner_element($elements)
{

	$elements[] = array(
		"module" => "x_banner",
		"name"   => "Banner",
        "element_color" => "#6f87ff",
        "show_params" => array(
            'title' => array(
                'pre' => esc_html__('Title: ', 'x-builder')
            ),
        ),
		"params" => array(
			"fields" => array(
				array(
					"id"         => "title",
					"type"       => "text",
					"label"      => "Banner Title",
					"typography" => array('.title')
				),
                array(
                    "id"         => "link",
                    "type"       => "text",
                    "label"      => "Banner Link",
                ),
				array(
					"id"         => "subtitle",
					"type"       => "text",
					"label"      => "Banner Subtitle",
					"typography" => array('.subtitle')
				),
				array(
					"id"    => "title_width",
					"type"  => "number",
					"label" => "Banner Title Max width",
				),
                array(
                    "id"    => "subtitle_width",
                    "type"  => "number",
                    "label" => "Banner SubTitle Max width",
                ),
                array(
                    "id"    => "content_width",
                    "type"  => "number",
                    "label" => "Banner Content Max width",
                ),
                array(
                    "id"    => "min_height",
                    "type"  => "number",
                    "label" => "Banner Min Height",
                ),
				array(
					"id"         => "content",
					"type"       => "editor",
					"label"      => "Banner Content",
					"typography" => array('.content')
				),
                array(
                    "id"         => "button_title",
                    "type"       => "text",
                    "label"      => "button Title",
                ),
				array(
					"id"      => "positions",
					"type"    => "select",
					"label"   => "Position order",
					"options" => array(
						'title|content|subtitle' => "1. Title. 2. Content. 3. Sub Title",
						'title|subtitle|content' => "1. Title. 2. Sub Title. 3. Content",
						'content|title|subtitle' => "1. Content. 2. Title. 3. Sub Title",
						'subtitle|content|title' => "1. Sub Title. 2. Content. 3. Title",
						'subtitle|title|content' => "1. Sub Title. 2. Title. 3. Content",
					),
					"value" => ""
				),
                array(
                    "id"         => "banner_overlay",
                    "type"       => "color",
                    "label"      => "Banner Overlay",
                ),
			)
		)
	);

	return $elements;
}