<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $categories
 * @var $title
 * @var $banner
 * @var $card_bg
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array('x_products_filter_grid');
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

if (!empty($card_bg)) {
    $inline_styles .= ".{$module_id} .x_products_filter_grid__products__row-item {
        background-color : {$card_bg};
    }";
}

stm_x_builder_register_style($module, array(), $inline_styles);
stm_x_builder_register_script('timer', array('vue.js'));
stm_x_builder_register_script(
    $module,
    array('vue.js', 'vue-resource.js'),
    '',
    $module_id,
    array(
        'categories' => $categories,
        'banner' => $banner
    )
);

if (!empty($categories)): ?>

    <div class="<?php echo esc_attr(implode(' ', $classes)); ?>"
         @mouseover="hover=true"
         data-module="<?php echo esc_attr($module_id); ?>">
        <div class="row">
            <div class="x_products_filter_grid__cats col-md-3">
                <?php if (!empty($title)): ?>
                    <h3 class="title"><?php echo esc_html($title); ?></h3>
                <?php endif; ?>
                <?php foreach ($categories as $category): ?>
                    <?php $icon = get_term_meta($category['term_id'], 'x_product_icon', true); ?>
                    <div class="x_products_filter_grid__cats__item heading_font ttc_hv tbrc_a tbrc_b"
                         v-bind:class="active_category == <?php echo stm_x_filtered_output($category['term_id']); ?> ? 'active' : ''"
                         @click.prevent="getProducts(<?php echo esc_attr($category['term_id']); ?>)">
                        <span><?php echo stm_x_filtered_output($category['name']); ?></span>
                        <?php if (!empty($icon)): ?>
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-9" v-if="loading">
                <div class="x_loader_wrapper">
                    <div class="x_loader">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="x_products_filter_grid__products col-md-9"
                 v-if="typeof products[active_category] !== 'undefined' && !loading">

                <h4 v-if="!products[active_category].length && !loading && !banner">
                    <?php esc_html_e('No products in the category', 'x-builder'); ?>
                </h4>
                <div class="x_products_filter_grid__products__row x_vertical_products"
                     v-for="(row, index) in rows" v-bind:class="!products[active_category][0] ? 'empty' : ''">
                    <div class="x_products_filter_grid__products__row-item x_product_buttons_wrapper x_woo_image_wrapper"
                         v-for="rowProduct in row"
                         v-if="products[active_category][rowProduct]">
                        <div class="x_vertical_product__sale x_vertical_product__label heading_font"
                             v-if="products[active_category][rowProduct].sale_price">
                            <?php esc_html_e('Sale', 'x-builder') ?>
                        </div>
                        <div class="x_product_buttons" v-html="products[active_category][rowProduct].buttons"></div>
                        <div class="x_image">
                            <a v-bind:href="products[active_category][rowProduct].permalink">
                                <div class="x_woo_image_hover" v-if="products[active_category][rowProduct].gallery">
                                    <img v-bind:src="products[active_category][rowProduct].image"
                                         v-bind:alt="products[active_category][rowProduct].title"/>
                                    <img v-if="hover" v-bind:src="products[active_category][rowProduct].gallery"
                                         v-bind:alt="products[active_category][rowProduct].title"/>
                                </div>

                                <img v-else v-bind:src="products[active_category][rowProduct].image"
                                     v-bind:alt="products[active_category][rowProduct].title"/>
                            </a>
                        </div>
                        <div class="x_product_content">
                            <a v-bind:href="products[active_category][rowProduct].permalink" class="x_title h3">
                                {{products[active_category][rowProduct].title}}
                            </a>
                            <div class="x_price">
							<span v-html="products[active_category][rowProduct].price"
                                  class="x_price"></span>
                                <del v-if="products[active_category][rowProduct].sale_price"
                                     v-html="products[active_category][rowProduct].sale_price"
                                     class="x_sale_price"></del>
                            </div>
                            <Timer :starttime="products[active_category][rowProduct].sale_to"
                                   :endtime="products[active_category][rowProduct].sale_to"
                                   v-if="products[active_category][rowProduct].sale_to"
                                   trans='{"day":"<?php esc_attr_e('Day', 'x-builder') ?>","hours":"<?php esc_attr_e('Hours', 'x-builder') ?>","minutes":"<?php esc_attr_e('Minutes', 'x-builder') ?>","seconds":"<?php esc_attr_e('Seconds', 'x-builder') ?>"}'>
                            </Timer>
                        </div>
                    </div>
                    <div class="x_best_sellers__banner" v-if="index === 1">
                        <?php STM_X_Templates::show_x_template("x_best_sellers/parts/banner", array(
                            'banner' => $banner
                        )); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php endif;