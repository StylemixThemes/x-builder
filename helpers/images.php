<?php
function stm_x_builder_get_image_src($image_id, $size = 'full')
{
    $image = wp_get_attachment_image_src($image_id, $size);
    if (empty($image) or is_wp_error($image)) return '';

    return apply_filters('x_builder_filter_image_url', $image[0]);
}

function stm_x_builder_get_cropped_image_url($image_id, $width, $height, $crop = true)
{
    remove_filter('x_builder_filter_image_url', 'stm_x_builder_image_cdn_filter', 20);
    $image_url = stm_x_builder_get_image_src($image_id);
    add_filter('x_builder_filter_image_url', 'stm_x_builder_image_cdn_filter', 20);
    $width = !empty(intval($width)) ? intval($width) : 'full';
    $height = !empty(intval($height)) ? intval($height) : 'full';
    return apply_filters('stm_x_builder_filter_image_url', aq_resize($image_url, $width, $height, $crop, true, true));
}

function stm_x_builder_get_cropped_image($image_id, $width, $height, $crop = true)
{
    $image_url = stm_x_builder_get_cropped_image_url($image_id, $width, $height, $crop);

    $retina = (is_int($width) and is_int($height)) ? stm_x_builder_get_cropped_image_url($image_id, $width * 2, $height * 2, $crop) : '';
    $retina = (!empty($retina)) ? "srcset='{$retina} 2x'" : "";
    return "<img src='{$image_url}' width='{$width}' height='{$height}' alt=' " . esc_html__('Image', 'x-builder') .  " ' {$retina} />";
}

function stm_x_builder_cropped_image($image_id, $width, $height, $crop = true)
{
    echo stm_x_builder_get_cropped_image($image_id, $width, $height, $crop);
}

add_filter('stm_x_builder_filter_image_url', 'stm_x_builder_image_cdn_filter', 20);

function stm_x_builder_image_cdn_filter($image_url) {
    $site_url = get_home_url();
    $cdn = stm_x_get_option('cdn');

    if(!empty($cdn) and !empty($image_url)) {
        $cdn_image = str_replace($site_url, $cdn, $image_url);
    }

    if(!empty($cdn_image)) $image_url = $cdn_image;

    return $image_url;
}