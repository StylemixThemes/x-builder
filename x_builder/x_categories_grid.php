<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $title
 * @var $categories
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

wp_enqueue_script('imagesloaded');
stm_x_builder_register_style($module, array(), $inline_styles);
stm_x_builder_register_script($module, array('vue.js', 'vue-resource.js'), '', $module_id, $categories);
?>

<div class="x_categories_grid <?php echo esc_attr(implode(' ', $classes)); ?>"
     data-module="<?php echo esc_attr($module_id); ?>">
    <h3 class="title"><?php echo sanitize_text_field($title); ?></h3>
    <div class="x_categories_grid__items" v-if="categories.length">
        <div class="x_categories_grid__item" v-for="category in categories">

            <div class="x_categories_grid__item_image">
                <a v-bind:href="category.permalink">
                    <img src="#" alt="<?php esc_attr_e('Product image', 'STM_X_Builder_Front'); ?>" v-bind:src="category.image" v-bind:alt="category.title"/>
                </a>
            </div>

            <div class="x_categories_grid__item_content">
                <div class="x_categories_grid__item_parent">
                    <a v-bind:href="category.permalink" v-html="category.title"></a>
                </div>
                <div class="x_categories_grid__item_childs heading_font" v-for="child in category.terms">
                    <a v-bind:href="child.permalink" v-html="child.name"></a>
                </div>
                <div class="parent_view_all">
                    <a v-bind:href="category.permalink">
                        <?php esc_html_e('View all', 'STM_X_Builder_Front'); ?>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <div class="x_loader_wrapper" v-else>
        <div class="x_loader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
