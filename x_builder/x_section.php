<?php
/**
 *
 * @var $params
 * @var $rows
 * @var $z_index
 * @var $custom_css
 *
 *
 */

$layout = '';
$module = 'section';
$params = stm_x_builder_get_params($module, $params);
extract($params);

$classes = array();

$module_id = stm_x_builder_module_id('x_module_x', $params);
$inline_styles = (empty($custom_css)) ? '' : $custom_css;
if(!empty($z_index)) {
    $inline_styles .= ".{$module_id} {position: relative; z-index: {$z_index}}";
}
stm_x_builder_register_style($module, array(), $inline_styles);
stm_x_builder_register_script($module, array('jquery'));

$classes[] = $module_id;
$classes[] = "x_section__{$layout}";

?>

<div class="x_section <?php echo implode(' ', $classes); ?>">
    <div class="row">
		<?php foreach ($rows as $row): ?>
			<?php STM_X_Templates::show_x_template('x_row', $row); ?>
		<?php endforeach; ?>
    </div>
</div>