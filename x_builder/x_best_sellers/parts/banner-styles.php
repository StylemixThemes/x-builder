<?php
/**
 * @var $banner
 */
$bg_color = get_post_meta($banner, 'bg_color', true);
$title_color = get_post_meta($banner, 'title_color', true);
$bg = get_post_meta($banner, 'bg', true);

$inline = '';
$selector = ".x_banner_mini__{$banner}";

if(!empty($bg_color)) {
    $inline .= "{$selector} {
        background-color : {$bg_color};
    }";
}

if(!empty($title_color)) {
    $inline .= "{$selector} .x_banner_mini__title {
        color : {$title_color};
    }";
}

if(!empty($bg)) {
    $bg = stm_x_builder_get_cropped_image($bg, '540', '260');
    $inline .= "{$selector} {
        background-image : url('{$bg}'); 
    }";
}

stm_x_builder_register_style('banner_mini', array(), $inline);