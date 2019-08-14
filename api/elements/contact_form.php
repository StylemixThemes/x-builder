<?php
add_filter('x_get_elements', 'x_add_contact_form_element', 10, 2);

function x_add_contact_form_element($elements, $is_api)
{

    $posts = (!$is_api) ? array() : stm_x_get_posts_select('wpcf7_contact_form');

	$elements[] = array(
		"module" => "x_contact_form",
		"name"   => "Contact Form",
        "element_color" => "#8baeff",
        "show_params" => array(
            'title' => array(
                'pre' => esc_html__('Title: ', 'x-builder')
            ),
        ),
		"params" => array(
			"fields" => array(
                array(
                    "id"    => "title",
                    "type"  => "text",
                    "label" => "Contact Form title",
                    "typography" => array('.x_contact_form_wpcf7__title')
                ),
                array(
                    "id"    => "contact_form",
                    "type"  => "select",
                    "label" => "Choose Contact Form",
                    "value" => "",
                    "options" => $posts
                ),
                array(
                    "id"    => "location_title",
                    "type"  => "text",
                    "label" => "Location Title",
                ),
                array(
                    "id"    => "location_text",
                    "type"  => "editor",
                    "label" => "Location Text",
                ),
                array(
                    "id"    => "contact_title",
                    "type"  => "text",
                    "label" => "Contact Title",
                ),
                array(
                    "id"    => "contact_text",
                    "type"  => "editor",
                    "label" => "Contact Text",
                ),
                array(
                    "id"    => "phone_title",
                    "type"  => "text",
                    "label" => "Phone Title",
                ),
                array(
                    "id"    => "phone_text",
                    "type"  => "editor",
                    "label" => "Phone Text",
                ),
			)
		)
	);
	
	return $elements;
}