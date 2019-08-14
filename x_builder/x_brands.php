<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $brands
 * @var $grid
 * @var $custom_css
 */


$params = stm_x_builder_get_params($module, $params);
extract($params);

$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;


stm_x_builder_register_style($module, array(), $custom_css);

if(!$grid) {
    wp_enqueue_style('owl-carousel');
    wp_enqueue_script('imagesloaded');
    stm_x_builder_register_script($module, array('owl-carousel', 'imagesloaded'));
    $classes[] = 'owl-carousel';
} else {
    $classes[] = 'x_brands__grid';
}

if(!empty($brands)): ?>

<div class="x_brands <?php echo esc_attr(implode(' ', $classes)); ?>" data-module="<?php echo esc_attr($module_id); ?>">
    <?php foreach($brands as $brand):
        $url = (!empty($brand['x_link'])) ? $brand['x_link'] : '#'; ?>
        <a class="x_brands__single" href="<?php echo esc_url($url); ?>">
            <img src="<?php echo esc_url(stm_x_builder_get_cropped_image_url($brand['image'], 220, 160, false)); ?>"
                 alt="<?php esc_attr_e('Brand image', 'STM_X_Builder_Front'); ?>" />
        </a>
    <?php endforeach; ?>
</div>

<?php endif;