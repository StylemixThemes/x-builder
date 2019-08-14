<?php
add_filter('x_get_elements', 'x_add_iconbox_element');

function x_add_iconbox_element($elements)
{

    $elements[] = array(
        "module" => "x_iconbox",
        "name" => "Iconbox",
        "element_color" => "#f82d2d",
        "params" => array(
            "fields" => array(
                array(
                    "id" => "icon",
                    "type" => "iconpicker",
                    "label" => "Icon",
                    "typography" => array('.x_iconbox__icon')
                ),
                array(
                    "id" => "style",
                    "type" => "select",
                    "label" => "Iconbox Type",
                    "value" => "icon_top",
                    "options" => array(
                        'icon_top' => esc_html__('Icon Top', 'x-builder'),
                        'icon_left' => esc_html__('Icon Left', 'x-builder'),
                        'icon_right' => esc_html__('Icon Right', 'x-builder'),
                    )
                ),
                array(
                    "id" => "title",
                    "type" => "text",
                    "label" => "Title",
                    "typography" => array('.x_iconbox__title')
                ),
                array(
                    "id" => "content",
                    "type" => "editor",
                    "label" => "Content",
                    "typography" => array('.x_iconbox__content')
                ),
            )
        )
    );

    return $elements;
}