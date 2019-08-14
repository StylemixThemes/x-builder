<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $images
 * @var $style
 * @var $custom_css
 */

$parallax = ((!empty($params['parallax_speed']))) ? $params['parallax_speed'] : '';

$params = stm_x_builder_get_params($module, $params);
extract($params);

if (!empty($images)):

    $sizes = array(
        array('640', '400'),
        array('640', '400'),
        array('640', '800'),
        array('1280', '400'),
    );

    $classes = array();
    $module_id = stm_x_builder_module_id($module, $params);
    $classes[] = $module_id;
    $inline_styles = (empty($custom_css)) ? '' : $custom_css;
    stm_x_builder_register_style($module, array(), $inline_styles);
    //$classes[] = $style;

    stm_x_builder_register_script($module, array('imagesloaded', 'packery'));

    if ($parallax) {
        $classes[] = "x_parallax";
        stm_x_builder_register_script($module, array('rellax'), '', $module_id, array(
            'speed' => $parallax
        ));
    }

    ?>

    <div class="x_hint_images <?php echo esc_attr(implode(' ', $classes)) ?>"
         data-module="<?php echo esc_attr($module_id); ?>">


        <?php
        $k = 0;
        foreach ($images as $i => $image):
            if($k > 3) $k = 0;
            $image_data = $image['image'];
            $width = $sizes[$k][0];
            $height = $sizes[$k][1];

            ?>
            <div class="x_hint_image x_hint_image<?php echo esc_attr($k); ?>">
                <div class="x_hint_image__inner">
                    <?php echo stm_x_builder_get_cropped_image($image_data['image_id'], $width, $height); ?>
                    <?php if (!empty($image_data['hints'])): ?>
                        <?php foreach ($image_data['hints'] as $hint):
                            $is_right = (intval($hint['x'] < 70)) ? 'right' : 'left';
                            ?>
                            <div class="x_hint_image__hint x_hint_image__hint_<?php echo esc_attr($is_right); ?>"
                                 style="top: <?php echo esc_attr($hint['y']); ?>; left: <?php echo esc_attr($hint['x']); ?>;">
                                <div class="x_hint_image__hint_plus">+</div>
                                <div class="x_hint_image__hint_text heading_font"><?php echo sanitize_text_field($hint['hint']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php $k++; endforeach; ?>

    </div>

<?php endif;