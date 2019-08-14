<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $banner
 * @var $bestsellers
 * @var $trending
 * @var $popular
 * @var $categories
 * @var $eight_products
 * @var $tabs_style
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

$style = 'default';
if (!empty($banner)) $style = 'with-banner';
if(!empty($eight_products)) $style = 'eight-products';

$classes[] = $style;

$classes[] = 'clearfix';

$classes[] = "tabs_style_{$tabs_style}";

if (!empty($categories)) {
    foreach ($categories as $category_key => $category) {
        /*Category Icon*/
        $icon = get_term_meta($category['term_id'], 'x_product_icon', true);
        $categories[$category_key]['icon'] = (!empty($icon)) ? $icon : 'lnricons-chevron-right-circle';
        if(!empty($category['name'])) $categories[$category_key]['name'] = html_entity_decode($category['name']);
    }
}

if(!empty($bestsellers)) {
    array_unshift($categories, array(
        'name' => esc_html__('BestSellers', 'x-builder'),
        'term_id' => 'bestsellers',
        'icon' => 'lnricons-chart-growth'
    ));
}

if(!empty($popular)) {
    array_unshift($categories, array(
        'name' => esc_html__('Popular', 'x-builder'),
        'term_id' => 'popular',
        'icon' => 'lnricons-chart-bars'
    ));
}

if(!empty($trending)) {
    array_unshift($categories, array(
        'name' => esc_html__('Trending', 'x-builder'),
        'term_id' => 'trending',
        'icon' => 'lnricons-diamond3'
    ));
}

array_unshift($categories, array(
    'name' => esc_html__('All', 'x-builder'),
    'term_id' => 'all',
    'icon' => 'lnricons-menu-square'
));

$style_deps = array();
$deps = array('vue.js', 'vue-resource.js');
if($style === 'default') {
    $deps[] = 'imagesloaded';
    $deps[] = 'owl-carousel';
    $style_deps[] = 'owl-carousel';
}

$transient = (!empty($categories[0])) ? get_transient("{$module_id}-{$categories[0]['term_id']}") : '';

stm_x_builder_register_style("{$module}-{$style}", $style_deps, $inline_styles);
stm_x_builder_register_script('timer', array('vue.js'));
stm_x_builder_register_script(
    "{$module}-{$style}",
    $deps,
    '',
    $module_id,
    array(
        'categories' => $categories,
        'transient' => $transient
    )
);

?>

<div class="x_best_sellers <?php echo esc_attr(implode(' ', $classes)); ?>"
     data-module="<?php echo esc_attr($module_id); ?>" data-v-if="categories.length">

    <?php STM_X_Templates::show_x_template("x_best_sellers/{$style}", array(
        'title' => $title,
        'banner' => $banner
    )); ?>

</div>