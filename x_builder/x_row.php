<?php
/**
 *
 * @var $params
 * @var $columns
 * @var $layout
 *
 *
 */
$module = 'row';
$params = stm_x_builder_get_params($module, $params);
extract($params);
$module_id = stm_x_builder_module_id('x_module_x', $params);

$inline_styles = (empty($custom_css)) ? '' : $custom_css;

stm_x_builder_register_style($module, array(), $inline_styles);

$layout = (!empty($layout) and $layout === 'stretch') ? 'container-fluid' : 'container';
?>

<div class="<?php echo esc_attr($layout) ?>">
    <div class="row <?php echo esc_attr($module_id); ?>">
		<?php foreach ($columns as $column): ?>
			<?php STM_X_Templates::show_x_template('x_column', $column); ?>
		<?php endforeach; ?>
    </div>
</div>