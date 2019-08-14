<?php
/**
 * @var $id
 *
 */

?>



<div class="x_builder_product_buttons product">

    <div data-tooltip="<?php esc_attr_e('Add to cart', 'x-builder') ?>" class="x_builder_product_buttons_buy">
        <?php woocommerce_template_loop_add_to_cart(); ?>
    </div>

    <?php if (defined('YITH_WCWL')):
        $url = YITH_WCWL()->get_wishlist_url();
        ?>
        <div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo esc_attr($id); ?>">

            <div class="yith-wcwl-add-button">

                <a href="#"
                   rel="nofollow"
                   data-product-id="<?php echo esc_attr($id); ?>"
                   class="add_to_wishlist">
                    <i class="lnricons-heart"></i>
                    <?php esc_html_e('Add to Wishlist', 'x-builder'); ?>
                </a>

            </div>

            <div class="yith-wcwl-wishlistexistsbrowse hide" style="display: none;">
                <a href="<?php echo esc_url($url); ?>" rel="nofollow">
                    <i class="lnricons-heart"></i>
                    <?php esc_html_e('Browse Wishlist', 'x-builder'); ?>
                </a>
            </div>

        </div>

    <?php endif; ?>


    <a href="#"
       class="compare button x_compare"
       data-product_id="<?php echo intval($id); ?>"
       rel="nofollow">
        <i class="lnricons-shuffle"></i>
        <?php esc_html_e('Compare', 'STM_X_Builder_Front'); ?>
    </a>
    <?php if(class_exists('YITH_WCQV')): ?>
        <a href="#"
           class="quick_view yith-wcqv-button"
           data-product_id="<?php echo intval($id); ?>"
           data-tooltip="<?php esc_attr_e('Quick View', 'x-builder'); ?>">
            <i class="lnricons-eye"></i>
            <?php esc_html_e('Quick view', 'elab'); ?>
        </a>
    <?php endif; ?>

</div>