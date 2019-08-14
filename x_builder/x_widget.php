<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $widget
 * @var $widget_text
 * @var $widget_text_color
 * @var $custom_css
 */

$parallax = ((!empty($params['parallax_speed']))) ? $params['parallax_speed'] : '';

$params = stm_x_builder_get_params($module, $params);
extract($params);

if (!empty($widget)):

    $classes = array();
    $module_id = stm_x_builder_module_id($module, $params);
    $classes[] = $module_id;

    if (!empty($custom_css)) {
        $widget_typography_styles = apply_filters('stmt_theme_widget_typo_selectors', array(
            ".widget.widget_archive ul li a",
            ".widget.widget_categories ul li a",
            ".widget.widget_nav_menu ul li a",
            ".widget.widget_pages ul li a",
            ".widget.widget_product_categories ul li a",
            ".widget.widget_recent_comments ul li a",
            ".widget.widget_recent_entries ul li a",
            ".stc"
        ));

        $custom_css = str_replace('.widget_text_color', implode(", .{$module_id} ", $widget_typography_styles), $custom_css);
    }

    $inline_styles = (empty($custom_css)) ? '' : $custom_css;

    stm_x_builder_register_style($module, array(), $inline_styles);

    if ($parallax) {
        $classes[] = "x_parallax";
        stm_x_builder_register_script($module, array('rellax'), '', $module_id, array(
            'speed' => $parallax
        ));
    }

    ?>

    <div class="x_widget <?php echo esc_attr(implode(' ', $classes)) ?>"
         data-module="<?php echo esc_attr($module_id); ?>">

        <?php the_widget(
            $widget,
            array('title' => $widget_text),
            array(
                'widget_id' => $module_id,
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
                'after_widget' => '</div>'
            )
        ); ?>

    </div>

<?php endif;