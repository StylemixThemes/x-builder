<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $icon
 * @var $title
 * @var $style
 * @var $content
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$classes[] = "x_iconbox_{$style}";

stm_x_builder_register_style($module, array(), $custom_css);
?>

<div class="x_iconbox <?php echo esc_attr(implode(' ', $classes)); ?>" id="<?php echo esc_attr($module_id) ?>">

    <?php if (!empty($icon)): ?>
        <div class="x_iconbox__icon icon">
            <i class="<?php echo esc_attr($icon); ?>"></i>
        </div>
    <?php endif; ?>

    <div class="x_iconbox__s_wrapper">

        <?php if (!empty($title)): ?>
            <div class="x_iconbox__title">
                <h5 class="title"><?php echo sanitize_text_field($title); ?></h5>
            </div>
        <?php endif; ?>

        <?php if (!empty($content)): ?>
            <div class="x_iconbox__content">
                <div class="content"><?php echo wp_kses_post($content); ?></div>
            </div>
        <?php endif; ?>

    </div>

</div>
