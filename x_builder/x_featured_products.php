<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $title
 * @var $posts
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

$transient = get_transient($module_id);

wp_enqueue_script('imagesloaded');
stm_x_builder_register_style($module, array(), $inline_styles);
stm_x_builder_register_script('timer', array('vue.js'));
stm_x_builder_register_script($module, array('vue.js', 'vue-resource.js'), '', $module_id, array(
    'posts' => $posts,
    'transient' => $transient,
));

?>
<div class="x_featured_products <?php echo esc_attr(implode(' ', $classes)); ?>"
     data-v-on_mouseover="hover=true"
     data-module="<?php echo esc_attr($module_id); ?>">
    <h3 class="title text-center"><?php echo wp_kses_post($title); ?></h3>
    <div class="x_loader_wrapper" data-v-if="!products.length">
        <div class="x_loader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>


    <div class="x_featured_products__rows" data-v-if="products.length">
        <div class="x_featured_products__row" data-v-for="(row, row_index) in rows"
             data-v-bind_class="'x_featured_products__row' + row_index">
            <div class="x_featured_products__products">
                <a data-v-bind_href="products[product_index].permalink"
                   class="x_featured_products__single x_product_buttons_wrapper x_woo_image_wrapper"
                   data-v-for="product_index in row" data-v-if="products[product_index]">

                    <div class="x_product_buttons" data-v-html="products[product_index].buttons"></div>

                    <div class="x_featured_products__single_inner">

                        <div class="x_featured_products__single_image">

                            <div class="x_woo_image_hover" data-v-if="products[product_index].gallery">
                                <img src="#"
                                     alt="<?php esc_attr_e('Product Image', 'x-builder'); ?>"
                                     data-v-bind_src="products[product_index].image"
                                     data-v-bind_alt="products[product_index].title"/>
                                <img src="#"
                                     alt="<?php esc_attr_e('Product Image', 'x-builder'); ?>"
                                     data-v-bind_src="products[product_index].gallery"
                                     data-v-if="hover"
                                     data-v-bind_alt="products[product_index].title"/>
                            </div>

                            <img src="#"
                                 alt="<?php esc_attr_e('Product Image', 'x-builder'); ?>"
                                 data-v-else
                                 data-v-bind_src="products[product_index].image"
                                 data-v-bind_alt="products[product_index].title"/>

                        </div>

                        <div class="x_featured_products__single_content">

                            <h6 class="x_featured_products__single_title"
                                data-v-html="products[product_index].title"></h6>

                            <div class="x_featured_products__single_timer heading_font"
                                 data-v-if="products[product_index].sale_to">
                                <div data-vue-role="Timer"
                                     data-v-bind_starttime="products[product_index].sale_to"
                                     data-v-bind_endtime="products[product_index].sale_to"
                                     data-vue-trans='{"day":"Day","hours":"Hours","minutes":"Minutes","seconds":"Seconds"}'>
                                </div>
                            </div>

                            <div class="x_featured_products__single_price">
                                    <span class="regular_price" data-v-html="products[product_index].regular_price"
                                          data-v-if="products[product_index].sale_price"></span>
                                <span class="price" data-v-html="products[product_index].price"></span>
                            </div>

                        </div>

                    </div>
                </a>
            </div>
        </div>

    </div>
</div>