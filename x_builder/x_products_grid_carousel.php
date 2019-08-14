<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $title
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

$transient = get_transient($module_id);

stm_x_builder_register_style("{$module}", array(), $inline_styles);
stm_x_builder_register_script(
    "{$module}",
    array('vue.js', 'vue-resource.js', 'imagesloaded'),
    '',
    $module_id,
    array(
        'transient' => $transient
    )
);

?>

<div class="x_products_grid_carousel <?php echo esc_attr(implode(' ', $classes)); ?>"
     data-module="<?php echo esc_attr($module_id); ?>">

    <?php if (!empty($title)): ?>
        <div class="x_products_grid_carousel__title title heading_font">
            <?php echo sanitize_text_field($title); ?>
        </div>
    <?php endif; ?>

    <div class="x_products_grid_carousel__rows">
        <div class="x_products_grid_carousel__row" data-v-for="(row, row_num) in rows"
             data-v-bind_class="'x_products_grid_carousel__row_' + row_num">
            <div class="x_products_grid_carousel__products">

                <a data-v-bind_href="products[product_index].permalink"
                   class="x_products_grid_carousel__product x_product_buttons_wrapper"
                   data-v-for="product_index in row"
                   data-v-bind_class="'x_products_grid_carousel__product_' + product_index"
                   data-v-if="products[product_index]">

                    <div class="x_product_buttons" data-v-html="products[product_index].buttons"></div>

                    <div class="x_products_grid_carousel__product__sale x_products_grid_carousel__product__label heading_font"
                         data-v-if="products[product_index].discount"
                         data-v-html="'-' + products[product_index].discount + '%'">
                    </div>

                    <div class="x_products_grid_carousel__product__stock x_products_grid_carousel__product__label heading_font"
                         data-v-if="products[product_index].quantity === 0">
                        <?php esc_html_e('Out of stock', 'x-builder') ?>
                    </div>

                    <div class="x_products_grid_carousel__product__content x_products_grid_carousel__product__content_top">
                        <div class="x_products_grid_carousel__product__cats"
                             data-v-html="products[product_index].terms"></div>

                        <div class="x_products_grid_carousel__product__title"
                             data-v-html="products[product_index].title"></div>

                        <div class="x_products_grid_carousel__product__excerpt"
                             data-v-html="products[product_index].excerpt"></div>

                    </div>

                    <div class="x_products_grid_carousel__product__image">
                        <img src="#"
                             alt="<?php esc_attr_e('Product Image', 'x-builder'); ?>"
                             data-v-bind_src="products[product_index].image"
                             data-v-bind_alt="products[product_index].title"/>
                    </div>

                    <div class="x_products_grid_carousel__product__content x_products_grid_carousel__product__content_bottom">

                        <div class="x_products_grid_carousel__product__price">
                                <span class="regular_price"
                                      data-v-html="products[product_index].regular_price"
                                      data-v-if="products[product_index].sale_price">
                                </span>
                            <span class="price" data-v-html="products[product_index].price"></span>
                        </div>

                        <span class="btn btn-outline-primary">
                            <?php esc_html_e('Shop now', 'stmt_theme_text_domain'); ?>
                        </span>

                    </div>

                </a>

            </div>
        </div>
    </div>


</div>