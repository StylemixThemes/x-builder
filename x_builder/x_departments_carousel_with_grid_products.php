<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $categories
 * @var $latest
 * @var $last_chance
 * @var $recently_viewed
 * @var $per_row
 * @var $total
 * @var $carousel
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

$per_row = (empty($per_row)) ? 4 : $per_row;

array_unshift($categories, array(
    'name' => esc_html__('All', 'x-builder'),
    'term_id' => 'all',
    'icon' => 'lnricons-menu-square'
));


wp_enqueue_style('owl-carousel');
stm_x_builder_register_style($module, array(), $inline_styles);
stm_x_builder_register_script('timer', array('vue.js'));

$transient = (!empty($categories[0])) ? get_transient("{$module_id}-{$categories[0]['term_id']}") : '';

stm_x_builder_register_script(
    $module,
    array('vue.js', 'vue-resource.js', 'owl-carousel'),
    '',
    $module_id,
    array(
        'categories' => $categories,
        'transient' => $transient,
    )
);

stm_x_builder_register_style('product/style_1');


?>

<div class="x_departments_carousel_with_grid_products <?php echo esc_attr(implode(' ', $classes)); ?>"
     data-v-on_mouseover="hover=true"
     data-module="<?php echo esc_attr($module_id); ?>" data-v-if="categories.length">

    <div class="x_departments_carousel_with_grid_products__categories">

        <?php foreach ($categories as $index => $category):
            $icon = get_term_meta($category['term_id'], 'x_product_icon', true);
            $icon = (!empty($icon)) ? $icon : 'lnricons-menu-square';
            ?>

            <div class="x_departments_carousel_with_grid_products__category"
                 data-v-bind_class="{'active' : active_category == '<?php echo esc_attr($category['term_id']); ?>'}"
                 data-v-on_click.prevent="getProducts(categories[<?php echo esc_attr($index); ?>])">
                <i class="<?php echo esc_attr($icon); ?>"></i>
                <?php echo sanitize_text_field($category['name']); ?>
            </div>

        <?php endforeach; ?>

    </div>

    <div class="x_departments_carousel_with_grid_products__products">

        <div class="x_departments_carousel_with_grid_products__products_inner" data-v-if="products[active_category] && products[active_category] !== 'empty'">

            <div class="x_archive_products style_1 x_archive_products__<?php echo esc_attr($per_row) ?>">

                <a data-v-bind_href="product.permalink" class="x_archive_product x_product_buttons_wrapper x_woo_image_wrapper"
                   data-v-for="product in products[active_category]">

                    <div class="x_product_buttons" data-v-html="product.buttons"></div>

                    <div class="x_archive_product__image">

                        <div class="x_woo_image_hover" data-v-if="product.gallery">
                            <img src="#"
                                 alt="<?php esc_attr_e('Product Image', 'x-builder'); ?>"
                                 data-v-bind_src="product.image"
                                 data-v-bind_alt="product.title"/>
                            <img src="#"
                                 alt="<?php esc_attr_e('Product Image', 'x-builder'); ?>"
                                 data-v-bind_src="product.gallery"
                                 data-v-if="hover"
                                 data-v-bind_alt="product.title"/>
                        </div>

                        <img data-v-else
                             src="#"
                             alt="<?php esc_attr_e('Product Image', 'x-builder'); ?>"
                             data-v-bind_src="product.image"
                             data-v-bind_alt="product.title"/>

                        <div class="x_archive_product__timer heading_font" data-v-if="product.sale_to">
                            <div data-vue-role="Timer"
                                 data-v-bind_starttime="product.sale_to"
                                 data-v-bind_endtime="product.sale_to"
                                 data-vue-trans='{"day":"Day","hours":"Hours","minutes":"Minutes","seconds":"Seconds"}'>
                            </div>
                        </div>

                    </div>

                    <div class="x_archive_product__content">

                        <div class="x_archive_product__stock x_archive_product__stock__label heading_font"
                             data-v-if="product.quantity < 5 && product.quantity > 0">
                            {{product.quantity}} <?php esc_html_e('in stock', 'x-builder'); ?>
                        </div>

                        <div class="x_archive_product__stock x_archive_product__stock__label heading_font"
                             data-v-if="product.quantity === 0">
                            <?php esc_html_e('Out of stock', 'x-builder'); ?>
                        </div>

                        <div class="x_archive_product__title">
                            <h5 data-v-html="product.title"></h5>
                        </div>

                        <div class="x_archive_product__price">
                            <span class="regular_price" data-v-html="product.regular_price" data-v-if="product.sale_price"></span>
                            <span class="price" data-v-html="product.price"></span>
                        </div>

                    </div>

                </a>
            </div>

        </div>

        <h5 class="text-center" data-v-else="">
            <?php esc_html_e('No products in this category', 'STM_X_Builder_Front'); ?>
        </h5>

        <div class="x_loader_wrapper"
             data-v-if="typeof products[active_category] === 'undefined' || !products[active_category].length">
            <div class="x_loader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>


</div>