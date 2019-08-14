<?php

require_once STM_X_BUILDER_DIR . "/api/elements/modules.php";
require_once STM_X_BUILDER_DIR . "/api/elements/text.php";
require_once STM_X_BUILDER_DIR . "/api/elements/heading.php";
require_once STM_X_BUILDER_DIR . "/api/elements/image.php";
require_once STM_X_BUILDER_DIR . "/api/elements/widget.php";
require_once STM_X_BUILDER_DIR . "/api/elements/hint_images.php";
require_once STM_X_BUILDER_DIR . "/api/elements/button.php";
require_once STM_X_BUILDER_DIR . "/api/elements/banner.php";
require_once STM_X_BUILDER_DIR . "/api/elements/brands.php";
require_once STM_X_BUILDER_DIR . "/api/elements/countdown.php";
require_once STM_X_BUILDER_DIR . "/api/elements/google_map.php";
require_once STM_X_BUILDER_DIR . "/api/elements/iconbox.php";
require_once STM_X_BUILDER_DIR . "/api/elements/post_list.php";
require_once STM_X_BUILDER_DIR . "/api/elements/post_list_carousel.php";


class STM_X_Api_Elements
{

    public static function getElements($is_api = true)
    {
        return apply_filters('x_get_elements',
            array(
                array(
                    "module" => "inner_row",
                    "name" => "Inner Row",
                    "type" => "Basic",
                    "group" => "Basic",
                    "element_color" => "#498b9b",
                    "params" => array(
                        "fields" => array(
                            array(
                                "id" => "grid",
                                "type" => "grid",
                                "label" => "Grid",
                                "value" => 1,
                            ),
                        )
                    )
                ),
            ),
            $is_api
        );
    }

    public static function getMappedElements($is_api = true)
    {
        $elements = self::getElements($is_api);

        foreach ($elements as $element_key => $element) {
            $elements[$element['module']] = $element;
            unset($elements[$element_key]);
        }

        return $elements;
    }

    public static function getElement($element, $is_api = true)
    {
        $elements = self::getMappedElements($is_api);
        return (!empty($elements[$element])) ? $elements[$element] : array();
    }
}