<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $latitude
 * @var $longitude
 * @var $height
 * @var $offset_x
 * @var $offset_y
 * @var $height
 * @var $zoom
 * @var $custom_css
 */
$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

if (!empty($height)) {
    $inline_styles .= ".{$module_id} {
        min-height: {$height}px;
    }";
}

stm_x_builder_register_style($module, array(), $inline_styles);
stm_x_builder_register_script(
    $module, array('elab-app'),
    '',
    $module_id,
    array(
        'lat' => $latitude,
        'lng' => $longitude,
        'zoom' => $zoom,
        'offset_x' => $offset_x,
        'offset_y' => $offset_y,
    )
);
wp_enqueue_script('gmap');

?>

<div class="x_gmap <?php echo esc_attr(implode(' ', $classes)); ?>"
     id="<?php echo esc_attr($module_id) ?>"
     data-module="<?php echo esc_attr($module_id); ?>">
</div>