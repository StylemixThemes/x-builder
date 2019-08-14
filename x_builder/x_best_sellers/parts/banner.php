<?php
/**
 * @var $banner
 */
$title = get_post_meta($banner, 'title', true);
$content = get_post_meta($banner, 'content', true);
$image = get_post_meta($banner, 'image', true);
$button_title = get_post_meta($banner, 'button_title', true);
$button_link = get_post_meta($banner, 'button_link', true);

STM_X_Templates::show_x_template("x_best_sellers/parts/banner-styles", array(
    'banner' => $banner
)); ?>

<div class="x_banner_mini x_banner_mini__<?php echo esc_attr($banner); ?>">
    <div class="x_banner_mini__image">
        <a href="<?php echo esc_url($button_link) ?>">
        <?php echo stm_x_builder_get_cropped_image($image, 327, 260); ?>
        </a>
    </div>
    <div class="x_banner_mini__content">
        <div class="x_banner_mini__title">
            <?php echo sanitize_text_field($title); ?>
        </div>
        <div class="x_banner_mini__excerpt">
            <?php echo stm_x_filtered_output($content); ?>
        </div>
        <?php
        if (!empty($button_title) and !empty($button_link)): ?>
            <div class="elab__banner_btn">
                <a href="<?php echo esc_url($button_link) ?>" class="btn btn-outline-primary">
                    <?php echo sanitize_text_field($button_title); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>