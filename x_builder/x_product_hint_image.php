<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $price
 * @var $product
 * @var $width
 * @var $height
 * @var $custom_css
 */
$params = stm_x_builder_get_params( $module, $params );
extract( $params );
$classes = array();
$module_id = stm_x_builder_module_id( $module, $params );
$classes[] = $module_id;
$inline_styles = ( empty( $custom_css ) ) ? '' : $custom_css;
$product_id = $product;
$image_1 = get_post_meta( $product_id, 'hint_image_1', true );
$image_1 = ( !empty( $image_1 ) ) ? json_decode( $image_1, true ) : '';
if(empty($width)){
    $width = 740;
}
if(empty($height)){
    $height = 400;
}
if( !empty( $image_1[ 'image_id' ] ) ):
    stm_x_builder_register_style($module, array(), $inline_styles);
    ?>
    <div class="elab_hint_images single-hint <?php echo esc_attr($module_id); ?>">
        <div class="elab_hint_image">
            <div class="elab_hint_image__inner">
                <?php echo stm_x_builder_get_cropped_image( ${"image_1"}[ 'image_id' ], $width, $height ); ?>
                <?php if( !empty( ${"image_1"}[ 'hints' ] ) ): ?>
                    <?php foreach( ${"image_1"}[ 'hints' ] as $hint ):
                        $is_right = ( intval( $hint[ 'x' ] < 70 ) ) ? 'right' : 'left';
                        ?>
                        <div class="elab_hint_image__hint elab_hint_image__hint_<?php echo esc_attr( $is_right ); ?>"
                             style="top: <?php echo esc_attr( $hint[ 'y' ] ); ?>; left: <?php echo esc_attr( $hint[ 'x' ] ); ?>;">
                            <div class="elab_hint_image__hint_plus">+</div>
                            <div class="elab_hint_image__hint_text heading_font"><?php echo sanitize_text_field( $hint[ 'hint' ] ); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <a href="<?php the_permalink($product_id); ?>" class="product-link"></a>
                <?php
                $_product = wc_get_product( $product_id );
                $regular_price = $_product->get_regular_price();
                $sale_price = $_product->get_sale_price();
                $price_class = 'regular_price';
                if( empty( $sale_price ) ) {
                    $price_class = 'sale_price';
                }
                ?>
                <?php if($price): ?>
                    <div class="product-price">
                        <?php

                            $symbol = get_woocommerce_currency_symbol();

                            if(!empty($sale_price)){
                                $sale_price = floatval($sale_price);
                                echo '<span class="sale_price"><span>' . esc_html($symbol) . '</span>' . esc_html(number_format($sale_price, 2, '.', ' ')) . '</span>';
                            }
                            if(!empty($regular_price)){
                                $regular_price = floatval($regular_price);
                                echo '<span class="' . esc_attr($price_class) . '"><span>' . esc_html($symbol) . '</span>' . esc_html(number_format($regular_price, 2, '.', ' ')) . '</span>';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                <?php
                    if(!empty($sale_price)):
                        $sale = (100 - (intval($sale_price) * 100 / intval($regular_price)));
                        $sale = intval($sale);
                ?>
                    <div class="sale-info">
                        <div class="sale-top"><?php esc_html_e('up to', 'x-builder'); ?></div>
                        <div class="sale-value">
                            <span class="sale-num"><?php echo esc_html($sale); ?></span>
                            <span class="sale-text">
                                <span class="sale-percent">%</span>
                                <span class="sale-off"><?php esc_html_e('off', 'x-builder'); ?></span>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="hint_images_holder"></div>
<?php endif;