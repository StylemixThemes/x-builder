<?php

require_once STM_X_BUILDER_DIR . "/builder/template.Class.php";
require_once STM_X_BUILDER_DIR . "/builder/css.Class.php";

new STM_X_Builder_Front();

class STM_X_Builder_Front
{
    public function __construct()
    {
        add_filter('the_content', array('STM_X_Builder_Front', 'content'));

        add_action('wp_enqueue_scripts', array('STM_X_Builder_Front', 'scripts_and_styles'), -1);

        add_action('wp_head', array('STM_X_Builder_Front', 'global_variables'));

    }

    public static function global_variables()
    { ?>
        <script type="text/javascript">
            var x_ajax_url = "<?php echo esc_url(admin_url('admin-ajax.php')); ?>";
        </script>
    <?php }

    public static function content($content)
    {
        remove_filter('the_content', array('STM_X_Builder_Front', 'content'));

        $is_editor_active_for_post = stm_x_is_editor_active_for_precised_post(get_the_ID());

        $x_content = ($is_editor_active_for_post === 'enabled') ? self::parse_sections(get_the_ID()) : $content;

        add_filter('the_content', array('STM_X_Builder_Front', 'content'));

        return $x_content;
    }

    public static function parse_sections($id)
    {

        $meta = (is_preview()) ? STM_X_Api_Content::$preview : STM_X_Api_Content::$content;

        $sections = get_post_meta($id, $meta, true);

        $content = '';
        if (!empty($sections)) {
            foreach ($sections as $section) {
                $content .= STM_X_Templates::load_x_template('x_section', $section);
            }
        }

        return $content;
    }

    public static function scripts_and_styles()
    {
        $src = apply_filters('x_builder_css_path', STM_X_BUILDER_URL . 'public/css/');

        $v = stm_x_builder_version();
        wp_enqueue_style('STM_X_Builder_Front', $src . '/public/x_builder.css', array(), $v);
        if(apply_filters('x_enable_buttons_style', true)) {
            stm_x_builder_register_style(apply_filters('product_buttons_style', 'product_buttons/style_1'));
        }
        wp_register_style('owl-carousel', "{$src}vendor/owl.carousel.min.css", array(), time());

        $src_js = STM_X_BUILDER_URL . 'public/js/';
        wp_register_script('vue.js', "{$src_js}vendor/vue.min.js", array(), time(), true);
        wp_register_script('vue-resource.js', "{$src_js}vendor/vue-resource.min.js", array(), time(), true);
        wp_enqueue_script('vue-w3c-valid.js', "{$src_js}vendor/vue-w3c-valid.min.js", array(), time(), true);
        wp_register_script('owl-carousel', "{$src_js}vendor/owl.carousel.min.js", array(), time(), true);
        wp_register_script('rellax', "{$src_js}vendor/rellax.min.js", array(), time(), true);
        wp_register_script('packery', "{$src_js}vendor/packery.min.js", array(), time(), true);

        stm_x_builder_register_script('app', array('jquery'));
    }

}