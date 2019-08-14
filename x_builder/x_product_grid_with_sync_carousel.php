<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $title
 * @var $sort_by
 * @var $number
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array('x_product_grid_with_sync_carousel');
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

wp_enqueue_style('owl-carousel');
wp_enqueue_script('imagesloaded');
stm_x_builder_register_style("{$module}", array(), $inline_styles);
stm_x_builder_register_script(
    "{$module}",
    array('vue.js', 'vue-resource.js', 'owl-carousel'),
    '',
    $module_id,
    array(
        'number_of_items' => $number,
        'sort_by' => $sort_by
    )
);

?>

<div class="<?php echo esc_attr(implode(' ', $classes)); ?>"
     @mouseover="hover=true"
     data-module="<?php echo esc_attr($module_id); ?>">

    <?php if (!empty($title)): ?>
        <div class="x_product_grid_with_sync_carousel__title title heading_font">
            <?php echo sanitize_text_field($title); ?>
            <div class="x_owl_nav">
                <span class="prev"></span>
                <span class="next"></span>
            </div>
        </div>
    <?php endif; ?>

    <div class="x_loader_wrapper" v-if="!products.length">
        <div class="x_loader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="x_product_grid_with_sync_carousel__products" v-else>

        <div class="single-item" v-for="(group, groupIndex) in productsRows">

            <a v-bind:href="product.permalink"
               class="x_product_grid_with_sync_carousel__product x_product_buttons_wrapper x_woo_image_wrapper"
               v-for="product in group">

                <div class="x_product_buttons" v-html="product.buttons"></div>

                <div class="x_product_grid_with_sync_carousel__product_image">

                    <div class="x_woo_image_hover" v-if="product.gallery">

                        <img v-bind:src="product.image"
                             v-bind:alt="product.title"/>

                        <img v-bind:src="product.gallery"
                             v-if="hover"
                             v-bind:alt="product.title"/>

                    </div>

                    <img v-bind:src="product.image"
                         v-else
                         v-bind:alt="product.title"/>

                </div>

                <div class="x_product_grid_with_sync_carousel__product_content">

                    <div class="x_product_grid_with_sync_carousel__product_title" v-html="product.title"></div>

                    <div class="x_product_grid_with_sync_carousel__product_price">

                    <span class="regular_price"
                          v-html="product.regular_price"
                          v-if="product.sale_price">
                    </span>

                        <span class="price" v-html="product.price"></span>

                    </div>

                </div>

            </a>

        </div>

    </div>


</div>