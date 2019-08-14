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

wp_enqueue_style('owl-carousel');
wp_enqueue_script('imagesloaded');
stm_x_builder_register_style($module, array(), $inline_styles);
stm_x_builder_register_script('timer', array('vue.js'));
stm_x_builder_register_script($module, array('vue.js', 'vue-resource.js', 'owl-carousel'), '', $module_id, array(
    'posts' => $posts,
    'transient' => get_transient($module_id),
));

?>
<div class="x_deal_of_the_day <?php echo esc_attr(implode(' ', $classes)); ?>"
     data-module="<?php echo esc_attr($module_id); ?>">
    <h3 class="text-center title"><?php echo sanitize_text_field($title); ?></h3>
    <div class="sep"></div>
    <div class="x_loader_wrapper" data-v-if="!products.length">
        <div class="x_loader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="x_deal_of_the_day__posts owl-carousel" data-v-if="products.length">

        <a data-v-bind_href="product.permalink" class="x_deal_of_the_day__single" data-v-for="product in products">
            <div class="x_deal_of_the_day__single_inner">

                <div class="x_deal_of_the_day__single_timer heading_font" data-v-if="product.sale_to">
                    <div data-vue-role="Timer" data-v-bind_starttime="product.sale_to"
                         data-v-bind_endtime="product.sale_to"
                         data-vue-trans='{"day":"Day","hours":"Hours","minutes":"Minutes","seconds":"Seconds"}'>
                    </div>
                </div>
                <div class="timer_holder" data-v-else></div>

                <div class="x_deal_of_the_day__single_image">
                    <img src="#" data-v-bind_src="product.image" data-v-bind_alt="product.title"
                         alt="<?php esc_attr_e('Product Image', 'STM_X_Builder_Front'); ?>"/>

                </div>

                <div class="x_deal_of_the_day__single_content">

                    <div class="x_deal_of_the_day__single_brand" data-v-if="product.brands">{{product['brands']}}</div>

                    <h6 class="x_deal_of_the_day__single_title" data-v-html="product.title"></h6>

                    <div class="x_deal_of_the_day__single_price">
                        <span class="regular_price" data-v-html="product.regular_price"
                              data-v-if="product.sale_price"></span>
                        <span class="price" data-v-html="product.price"></span>
                    </div>

                </div>

            </div>
        </a>

    </div>
</div>