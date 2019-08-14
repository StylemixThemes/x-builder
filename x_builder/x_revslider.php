<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $revslider
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$module_id = stm_x_builder_module_id($module, $params);
$inline_styles = (empty($custom_css)) ? '' : $custom_css;
stm_x_builder_register_style($module, array(), $inline_styles);

if(!empty($revslider)) : ?>
    <div class="<?php echo esc_attr($module_id) ?>">
        <?php echo do_shortcode("[rev_slider alias='{$revslider}']"); ?>
    </div>
<?php endif;