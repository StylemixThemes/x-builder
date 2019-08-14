<?php
/**
 * @var $id
 *
 */

?>

<div class="x_builder_product_buttons product">

    <div data-tooltip="<?php esc_attr_e('Add to cart', 'x-builder') ?>">
        <?php woocommerce_template_loop_add_to_cart(); ?>
    </div>

    <?php if (defined('YITH_WCWL')):
        $url = YITH_WCWL()->get_wishlist_url();
        ?>
        <div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo esc_attr($id); ?>">

            <div class="yith-wcwl-add-button" data-tooltip="<?php esc_attr_e('Add to wishlist', 'x-builder'); ?>">

                <a href="#"
                   rel="nofollow"
                   data-product-id="<?php echo esc_attr($id); ?>"
                   class="add_to_wishlist">
                    <i class="lnricons-heart"></i>
                    <span><?php esc_html_e('Add to Wishlist', 'x-builder'); ?></span>
                </a>

            </div>

            <div class="yith-wcwl-wishlistexistsbrowse hide" style="display: none;" data-tooltip="<?php esc_attr_e('View wishlist', 'x-builder'); ?>">
                <a href="<?php echo esc_url($url); ?>" rel="nofollow">
                    <i class="lnricons-heart"></i>
                    <span><?php esc_html_e('Browse Wishlist', 'x-builder'); ?></span>
                </a>
            </div>

            <div class="yith-wcwl-wishlistaddedbrowse hide" style="display: none;" data-tooltip="<?php esc_attr_e('View wishlist', 'x-builder'); ?>">
                <a href="<?php echo esc_url($url); ?>" rel="nofollow">
                    <i class="lnricons-heart"></i>
                    <span><?php esc_html_e('Browse Wishlist', 'x-builder'); ?></span>
                </a>
            </div>

        </div>

    <?php endif; ?>


    <a href="#"
       class="compare button x_compare"
       data-product_id="<?php echo intval($id); ?>"
       data-tooltip="<?php esc_attr_e('Add to compare', 'x-builder'); ?>"
       rel="nofollow">
        <i class="lnricons-shuffle"></i>
        <span><?php esc_html_e('Compare', 'STM_X_Builder_Front'); ?></span>
    </a>
    <?php if(class_exists('YITH_WCQV')): ?>
        <a href="#"
           class="quick_view yith-wcqv-button"
           data-product_id="<?php echo intval($id); ?>"
           data-tooltip="<?php esc_attr_e('Quick View', 'x-builder'); ?>">
            <i class="lnricons-eye"></i>
        </a>
    <?php endif; ?>
</div>