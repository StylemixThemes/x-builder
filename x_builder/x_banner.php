<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $link
 * @var $subtitle
 * @var $button_title
 * @var $title_width
 * @var $subtitle_width
 * @var $banner_overlay
 * @var $custom_css
 * @var $positions
 */
$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

$tag = (!empty($link)) ? "a" : "div";

if (!empty($title_width)) {
	$inline_styles .= ".{$module_id} .title{max-width: {$title_width}px;}";
}

if (!empty($subtitle_width)) {
    $inline_styles .= ".{$module_id} .subtitle{max-width: {$subtitle_width}px;}";
}

if(!empty($min_height)){
    $inline_styles .= ".{$module_id} {min-height: {$min_height}px;}";
}

if (!empty($content_width)) {
    $inline_styles .= ".{$module_id} .content{max-width: {$content_width}px;}";
}

if(!empty($banner_overlay)) {
    $inline_styles .= ".{$module_id}:after {background-color: {$banner_overlay};}";
}

stm_x_builder_register_style($module, array(), $inline_styles);

$positions = (!empty($positions)) ? $positions : 'title|subtitle|content';
$classes[] = sanitize_title($positions);
$positions = explode('|', $positions);

$classes[] = (empty($subtitle)) ? 'no-subtitle' : '';

?>

<<?php echo stm_x_filtered_output($tag); ?> <?php if(!empty($link)) echo "href='{$link}'"; ?> class="x_banner <?php echo implode(' ', $classes); ?>">

	<?php foreach ($positions as $position) {
		STM_X_Templates::show_x_template("x_banner/{$position}", compact($position));
	} ?>

    <?php if(!empty($button_title)): ?>
        <span class="btn btn-primary"><?php echo wp_kses_post($button_title); ?></span>
    <?php endif; ?>

</<?php echo stm_x_filtered_output($tag); ?>>