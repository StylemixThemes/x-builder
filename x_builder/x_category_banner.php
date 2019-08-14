<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $title
 * @var $image
 * @var $category
 * @var $show_category_name
 * @var $show_category_price
 * @var $custom_css
 * @var $positions
 */
$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;
$inline_styles = (empty($custom_css)) ? '' : $custom_css;

stm_x_builder_register_style($module, array(), $inline_styles);

$category = (!empty($category)) ? get_term_by('id', $category, 'product_cat') : '';
$category_link = (!empty($category)) ? get_term_link($category) : '';
$min_price = (!empty($category)) ? stm_x_get_min_price_per_product_cat($category->term_id) : '';

if (!empty($image)):
    ?>

    <a href="<?php echo esc_url($category_link); ?>"
       class="x_category_banner <?php echo esc_attr(implode(' ', $classes)); ?>">

        <div class="x_category_banner__inner">

            <div class="x_category_banner__image">
                <?php echo stm_x_builder_get_cropped_image($image, '270', '220', false); ?>
            </div>

            <div class="x_category_banner__content">

                <?php if (!empty($category) and $show_category_name): ?>
                    <div class="x_category_banner__cat">
                        <?php echo sanitize_text_field($category->name); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($title)): ?>
                    <div class="x_category_banner__title">
                        <?php echo sanitize_text_field($title); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($category) and $show_category_price): ?>
                    <div class="x_category_banner__price">
                        <?php printf(esc_html__('Starting at %s', 'STM_X_Builder_Front'), wc_price(stm_x_get_min_price_per_product_cat($category->term_id))); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </a>

<?php endif;