<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;
stm_x_builder_register_style($module, array(), $inline_styles);
?>

<div class="x_text <?php echo esc_attr(implode(' ', $classes)) ?>">
    <div class="myText">
        <?php echo stm_x_filtered_output($params['myText']); ?>
    </div>
</div>