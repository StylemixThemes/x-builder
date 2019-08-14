<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $title
 * @var $per_row
 * @var $per_row_md
 * @var $number
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array('x_products_sale_carousel');
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

$transient = get_transient("{$module_id}-{$per_row}");

wp_enqueue_style('owl-carousel');
wp_enqueue_script('owl-carousel');

stm_x_builder_register_style("{$module}", array(), $inline_styles);
stm_x_builder_register_script('timer', array('vue.js'));
stm_x_builder_register_script(
    "{$module}",
    array('vue.js', 'vue-resource.js'),
    '',
    $module_id,
    array(
        'number_of_items' => $number,
        'per_row' => $per_row,
        'per_row_md' => $per_row_md,
        'transient' => $transient,
    )

);

?>

<div class="<?php echo esc_attr(implode(' ', $classes)); ?>"
     data-module="<?php echo esc_attr($module_id); ?>">

    <?php if (!empty($title)): ?>
        <div class="x_products_sale_carousel__title title heading_font">
            <?php echo wp_kses_post($title); ?>
            <div class="x_owl_nav">
                <span class="prev"></span>
                <span class="next"></span>
            </div>
        </div>
    <?php endif; ?>

    <div class="x_products_sale_carousel__products">
        <a data-v-bind_href="product.permalink" class="x_products_sale_carousel__product" data-v-for="product in products">

            <div class="x_products_sale_carousel__product_image">
                <img src="#" alt="<?php esc_attr_e('Product Image', 'x-builder'); ?>" data-v-bind_src="product.image">
            </div>

            <div class="x_products_sale_carousel__product_content">

                <div class="x_products_sale_carousel__product_title" data-v-html="product.title"></div>

                <div class="x_products_sale_carousel__product_timer" data-v-if="product.sale_to">
                    <div data-vue-role="Timer"
                         data-v-bind_starttime="product.sale_to"
                         data-v-bind_endtime="product.sale_to"
                         data-vue-trans='{"day":"Day","hours":"Hours","minutes":"Minutes","seconds":"Seconds"}'>
                    </div>
                </div>

                <div class="x_products_sale_carousel__product_price">

                    <span class="regular_price"
                          data-v-html="product.regular_price"
                          data-v-if="product.sale_price">
                    </span>

                    <span class="price" data-v-html="product.price"></span>

                </div>

            </div>

        </a>
    </div>


</div>