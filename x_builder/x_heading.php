<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $tag
 * @var $heading
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);

if (!empty($heading)) :

    $classes = array();
    $module_id = stm_x_builder_module_id($module, $params);
    $classes[] = $module_id;
    $inline_styles = (empty($custom_css)) ? '' : $custom_css;
    stm_x_builder_register_style($module, array(), $inline_styles);


    $tag = (!empty($tag)) ? $tag : 2;
    ?>

    <div class="x_heading <?php echo esc_attr(implode(' ', $classes)) ?>">
        <h<?php echo intval($tag); ?> class="heading"><?php echo wp_kses_post($heading); ?></h<?php echo intval($tag); ?>>
    </div>

<?php endif;