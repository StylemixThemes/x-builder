<?php
add_filter('x_get_elements', 'x_add_revslider_element', 10, 2);

function x_add_revslider_element($elements, $is_api)
{

    $revsliders = array();

    if($is_api) {
        $slider = new RevSlider();
        $arrSliders = $slider->getArrSliders();

        if ($arrSliders) {
            foreach ($arrSliders as $slider) {
                /** @var $slider RevSlider */
                $revsliders[$slider->getAlias()] = $slider->getTitle();
            }
        } else {
            $revsliders[__('No sliders found', 'js_composer')] = 0;
        }
    }

	$elements[] = array(
		"module" => "x_revslider",
		"name"   => "RevSlider",
		"group"   => "RevSlider",
        "element_color" => "#6664cd",
		"params" => array(
			"fields" => array(
                array(
                    "id"    => "revslider",
                    "type"  => "select",
                    "label" => "Choose slider",
                    "value" => "",
                    "options" => $revsliders
                )
			)
		)
	);
	
	return $elements;
}