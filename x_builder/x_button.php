<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $label
 * @var $link
 * @var $type
 * @var $inline
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);

if (!empty($label) and !empty($link)) :

    $classes = array();
    $module_id = stm_x_builder_module_id($module, $params);
    $classes[] = $module_id;
    if(!empty($inline)) $classes[] = 'inline_btn';
    $inline_styles = (empty($custom_css)) ? '' : $custom_css;

    if(!empty($color)){
        $inline_styles .= ' .' . $module_id . ' .btn:not(:hover) {color:' . $color . ';}';
    }
    if(!empty($color_hover)){
        $inline_styles .= ' .' . $module_id . ' .btn:hover {color:' . $color_hover . ';}';
    }
    if(!empty($border_color)){
        $inline_styles .= ' .' . $module_id . ' .btn:not(:hover) {border-color:' . $border_color . ';}';
    }
    if(!empty($border_color_hover)){
        $inline_styles .= ' .' . $module_id . ' .btn:hover {border-color:' . $border_color_hover . ';}';
    }
    if(!empty($background_color)){
        $inline_styles .= ' .' . $module_id . ' .btn:not(:hover) {background-color:' . $background_color . ';}';
    }
    if(!empty($background_color_hover)){
        $inline_styles .= ' .' . $module_id . ' .btn:hover {background-color:' . $background_color_hover . ';}';
    }
    stm_x_builder_register_style($module, array(), $inline_styles);

    $button_classes = array('btn');
    $button_classes[] = ($type=== 'outline') ? "btn-outline-primary" : "btn-primary";
    ?>

    <div class="x_button <?php echo esc_attr(implode(' ', $classes)) ?>">
        <a href="<?php echo esc_url($link); ?>" class="btn <?php echo esc_attr(implode(' ', $button_classes)) ?>">
            <?php echo sanitize_text_field($label); ?>
        </a>
    </div>

<?php endif;