<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $categories
 * @var $per_row
 * @var $total
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

$per_row = (empty($per_row)) ? 3 : $per_row;

if (!empty($categories)) {
    foreach ($categories as $category_key => $category) {
        /*Category Icon*/
        $icon = get_term_meta($category['term_id'], 'x_product_icon', true);
        $categories[$category_key]['icon'] = (!empty($icon)) ? $icon : 'lnricons-chevron-right-circle';
    }
}

stm_x_builder_register_style($module, array(), $inline_styles);
stm_x_builder_register_script('timer', array('vue.js'));

$transient = (!empty($categories[0])) ? get_transient("{$module_id}-{$categories[0]['term_id']}") : '';

stm_x_builder_register_script(
    $module,
    array('vue.js', 'vue-resource.js'),
    '',
    $module_id,
    array(
        'categories' => $categories,
        'total' => $total,
        'per_row' => $per_row,
        'transient' => $transient,
    )
);

?>

<div class="x_hot_deals <?php echo esc_attr(implode(' ', $classes)); ?>"
     data-v-on_mouseover="hover=true"
     data-module="<?php echo esc_attr($module_id); ?>" data-v-if="categories.length">

    <h3 class="title"><?php echo sanitize_text_field($title); ?></h3>

    <div class="x_hot_deals__module">

        <div class="x_hot_deals__categories" data-v-if="categories.length">
            <div class="x_hot_deals__category"
                 data-v-for="(category, index) in categories"
                 data-v-on_click.prevent="getProducts(category)"
                 data-v-bind_class="{'active' : category.term_id == parseInt(active_category)}">
                <h5 data-v-html="category.name"></h5>
                <i data-v-bind_class="category.icon" data-v-if="category.icon"></i>
            </div>
        </div>

        <div class="x_hot_deals__products">


            <div class="x_small_products x_small_products_<?php echo esc_attr($per_row); ?> x_hot_deals__cat_products"
                 data-v-if="typeof products[active_category] !== 'undefined'">

                <h4 data-v-if="!products[active_category].length && !loading"><?php esc_html_e('No products on sale right now', 'x-builder'); ?></h4>

                <a data-v-bind_href="product.permalink"
                   class="x_small_product x_product_buttons_wrapper x_woo_image_wrapper"
                   data-v-for="product in products[active_category]">

                    <div class="x_product_buttons" data-v-html="product.buttons"></div>

                    <div class="x_small_product__sale x_small_product__label heading_font"
                         data-v-if="product.discount" data-v-html="'-' + product.discount + '%'">
                    </div>

                    <div class="x_small_product__stock x_small_product__label heading_font"
                         data-v-if="product.quantity === 0">
                        <?php esc_html_e('Out of stock', 'x-builder') ?>
                    </div>

                    <div class="x_small_product__image">

                        <div class="x_woo_image_hover" data-v-if="product.gallery">
                            <img src="#" alt="<?php esc_attr_e('Product Image', 'STM_X_Builder_Front'); ?>"
                                 data-v-bind_src="product.image" data-v-bind_alt="product.title"/>
                            <img data-v-if="hover" src="#" alt="<?php esc_attr_e('Product Image', 'STM_X_Builder_Front'); ?>"
                                 data-v-bind_src="product.gallery" data-v-bind_alt="product.title"/>
                        </div>

                        <img data-v-else src="#" alt="<?php esc_attr_e('Product Image', 'STM_X_Builder_Front'); ?>"
                             data-v-bind_src="product.image" data-v-bind_alt="product.title"/>
                    </div>

                    <div class="x_small_product__content">

                        <div class="x_small_product__brand" data-v-if="product.brands">{{product['brands']}}
                        </div>

                        <h6 class="x_small_product__title" data-v-html="product.title"></h6>

                        <div class="x_small_product__price">
                                <span class="regular_price"
                                      data-v-html="product.regular_price"
                                      data-v-if="product.sale_price">
                                </span>
                            <span class="price" data-v-html="product.price"></span>
                        </div>

                    </div>

                </a>

            </div>

            <div class="x_loader_wrapper" data-v-if="loading">
                <div class="x_loader">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>

        </div>
    </div>


</div>