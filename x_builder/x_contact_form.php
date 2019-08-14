<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $title
 * @var $contact_form
 * @var $location_title
 * @var $location_text
 * @var $contact_title
 * @var $contact_text
 * @var $phone_title
 * @var $phone_text
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


?>

<div class="x_contact_form <?php echo esc_attr(implode(' ', $classes)) ?>">
    <div class="row align-items-center">
        <?php if (!empty($location_title) and !empty($location_text) or
            !empty($contact_title) and !empty($contact_text) or
            !empty($phone_title) and !empty($phone_text)): ?>
            <div class="col-xl-4 col-lg-4 col-md-12">

                <div class="x_contact_form__labels sbc">

                    <?php if (!empty($location_title) and !empty($location_text)): ?>
                        <div class="x_contact_form__iconbox">
                            <div class="x_contact_form__icon">
                                <i class="lnricons-map-marker"></i>
                            </div>
                            <div class="x_contact_form__title">
                                <h5><?php echo sanitize_text_field($location_title); ?></h5>
                            </div>
                            <div class="x_contact_form__content">
                                <?php echo wp_kses_post($location_text); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($contact_title) and !empty($contact_text)): ?>
                        <div class="x_contact_form__iconbox">
                            <div class="x_contact_form__icon">
                                <i class="lnricons-envelope"></i>
                            </div>
                            <div class="x_contact_form__title">
                                <h5><?php echo sanitize_text_field($contact_title); ?></h5>
                            </div>
                            <div class="x_contact_form__content">
                                <?php echo wp_kses_post($contact_text); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($phone_title) and !empty($phone_text)): ?>
                        <div class="x_contact_form__iconbox">
                            <div class="x_contact_form__icon">
                                <i class="lnricons-telephone"></i>
                            </div>
                            <div class="x_contact_form__title">
                                <h5><?php echo sanitize_text_field($phone_title); ?></h5>
                            </div>
                            <div class="x_contact_form__content">
                                <?php echo wp_kses_post($phone_text); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>


            </div>
        <?php endif; ?>
        <div class="col-xl-8 col-lg-8 col-md-12">
            <div class="x_contact_form_wpcf7">
                <h3 class="x_contact_form_wpcf7__title"><?php echo sanitize_text_field($title); ?></h3>
                <?php echo do_shortcode("[contact-form-7 id={$contact_form}]"); ?>
            </div>
        </div>
    </div>
</div>