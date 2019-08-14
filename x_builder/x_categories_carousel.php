<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $title
 * @var $categories
 * @var $inversed
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

wp_enqueue_style('owl-carousel');
wp_enqueue_script('imagesloaded');
stm_x_builder_register_style($module, array(), $inline_styles);
if ($inversed) stm_x_builder_register_style("{$module}-inversed");
stm_x_builder_register_script('timer', array('vue.js'));

if(empty($categories)) $categories = array();

foreach ($categories as $category_key => $category) {
    $term_exists = term_exists($category['term_id'], $category['taxonomy']);
    if (empty($term_exists['term_id'])) {
        unset($categories[$category_key]);
    }
}

stm_x_builder_register_script($module, array('vue.js', 'vue-resource.js', 'owl-carousel'), '', $module_id, $categories);
?>

<div class="x_categories_carousel <?php echo esc_attr(implode(' ', $classes)); ?>"
     data-module="<?php echo esc_attr($module_id); ?>">
    <h3 class="title"><?php echo wp_kses_post($title); ?></h3>
    <div class="x_categories_carousel__items owl-carousel" data-v-if="categories.length">
        <a data-v-bind_href="category.permalink" class="x_categories_carousel__item" data-v-for="category in categories">
            <div class="x_categories_carousel__item_image">
                <img src="#" alt="<?php esc_attr_e('Product image', 'STM_X_Builder_Front'); ?>" data-v-bind_src="category.image"
                     data-v-bind_alt="category.title"/>
            </div>
            <div class="x_categories_carousel__item_content">
                <div class="x_categories_carousel__item_title" data-v-html="category.title"></div>
                <div class="x_categories_carousel__item_description heading_font" data-v-html="category.description"></div>
            </div>
        </a>
    </div>
    <div class="x_loader_wrapper" data-v-else>
        <div class="x_loader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
