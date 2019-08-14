<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $image
 * @var $width
 * @var $width_md
 * @var $height
 * @var $align
 * @var $style
 * @var $custom_css
 */

$parallax = ((!empty($params['parallax_speed']))) ? $params['parallax_speed'] : '';

$params = stm_x_builder_get_params($module, $params);
extract($params);

if (!empty($image)):

    $classes = array();
    $module_id = stm_x_builder_module_id($module, $params);
    $classes[] = $module_id;
    $inline_styles = (empty($custom_css)) ? '' : $custom_css;

    if(!empty($width_md)) {
        $inline_styles .= "@media (max-width: 1350px) {
            .{$module_id} {
                max-width: {$width_md}px;
            }
        }";
    }

    stm_x_builder_register_style($module, array(), $inline_styles);
    $height = (!empty($height)) ? $height : 'full';
    $width = (!empty($width)) ? $width : 'full';
    $classes[] = $style;

    $classes[] = (!empty($align)) ? "text-{$align}" : 'left';

    if ($parallax) {
        $classes[] = "x_parallax";
        stm_x_builder_register_script($module, array('rellax'), '', $module_id, array(
            'speed' => $parallax
        ));
    }

    ?>

    <div class="x_image <?php echo esc_attr(implode(' ', $classes)) ?>" data-module="<?php echo esc_attr($module_id); ?>">
        <?php stm_x_builder_cropped_image($image, $width, $height); ?>
    </div>

<?php endif;