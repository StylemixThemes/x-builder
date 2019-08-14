<?php
/**
 * Class STM_X_Builder
 */

if (!class_exists('STM_X_Builder')) {

    class STM_X_Builder
    {

        function __construct()
        {

            add_action('admin_bar_menu', 'STM_X_Builder::activate_editor', 9999999);
            add_action('init', 'STM_X_Builder::on_off_x_builder', 50);

            add_action('admin_enqueue_scripts', 'STM_X_Builder::generic_styles');

            if (STM_X_Builder::editor_active()) {
                add_filter('use_block_editor_for_post', '__return_false');
                add_filter('gutenberg_can_edit_post', '__return_false', 10);
                add_filter('user_can_richedit', '__return_true');
                add_action('edit_form_after_title', 'STM_X_Builder::x_builder');
                add_action('admin_enqueue_scripts', 'STM_X_Builder::scripts');
                add_action('admin_enqueue_scripts', 'STM_X_Builder::styles');

                add_action('save_post', 'STM_X_Builder::save_post', 10, 2);
                add_action('wp_restore_post_revision', 'STM_X_Builder::restore_revision', 10, 2);
            }
        }

        public static function editor_active()
        {

            if(!empty($_GET['x-builder-edit'])) {
                $get_edit = sanitize_text_field($_GET['x-builder-edit']);
                $get_edit = explode('|', $get_edit);

                if(count($get_edit) === 2) {
                    $get_edit = $get_edit[1];
                    return ($get_edit === 'enabled');
                }

            }

            $post_id = (!empty($_GET['post'])) ? intval($_GET['post']) : '';
            $post_type = (!empty($_GET['post_type'])) ? sanitize_text_field($_GET['post_type']) : '';

            $enabled = stm_x_is_editor_active_for_post($post_id, $post_type);

            return ($enabled === 'enabled');
        }

        function remove_editor()
        {
            return false;
        }

        public static function x_builder()
        {
            require_once(STM_X_BUILDER_DIR . '/templates/builder.php');
        }

        public static function scripts()
        {

            $screen = get_current_screen();

            if ($screen->base == 'edit' or $screen->base == 'post') {
                $app = STM_X_BUILDER_URL . 'src/vue/dist/static';

                wp_enqueue_media();
                wp_enqueue_editor();
                wp_enqueue_style('editor-buttons');
                wp_enqueue_script('vue-resource.js', "{$app}/js/vue.js", array(), time(), true);
                wp_enqueue_script('x_vendor', "{$app}/js/node-static.js", array(), time(), true);
                wp_enqueue_script('x_app', "{$app}/js/x_builder.js", array(), time(), true);

                /*Add API Endpoints*/
                wp_localize_script('x_app', 'x_builder_endpoints', STM_X_Api_Endpoints::apiUrls(get_the_ID()));
                wp_enqueue_script('x_builder_admin', STM_X_BUILDER_URL . "public/js/admin/x_builder_admin.js", array(), time(), true);
            }

        }

        public static function styles($hook)
        {

            $screen = get_current_screen();

            if ($screen->base == 'edit' or $screen->base == 'post') {
                $src = STM_X_BUILDER_URL . 'public/css/';
                $public_src = STM_X_BUILDER_URL . 'public/';
                $app = STM_X_BUILDER_URL . 'src/vue/dist/static';
                wp_enqueue_style('x-builder', "{$src}/builder.css", array(), time());
                wp_enqueue_style('x-builder-app', "{$app}/css/app.css", array(), time());
                wp_enqueue_style('x-linear-icons', "{$public_src}icons/linear-icons.css", array(), time());
            }
        }

        public static function generic_styles()
        {
            $screen = get_current_screen();


            if ($screen->base == 'edit' or $screen->base == 'post') {
                $src = STM_X_BUILDER_URL . 'public/css/';
                $app = STM_X_BUILDER_URL . 'src/vue/dist/static';
                wp_enqueue_style('x-builder-generic', "{$src}/builder_generic.css", array(), time());
            }
        }

        public static function save_post($post_id, $post)
        {

            $parent_id = wp_is_post_revision($post_id);

            if ($parent_id) {

                $parent = get_post($parent_id);
                $my_meta = get_post_meta($parent->ID, 'x_builder_content', true);

                if (false !== $my_meta)
                    add_metadata('post', $post_id, 'x_builder_content', $my_meta);

            }

        }

        public static function restore_revision($post_id, $revision_id)
        {

            $post = get_post($post_id);
            $revision = get_post($revision_id);
            $my_meta = get_metadata('post', $revision->ID, 'x_builder_content', true);

            if (false !== $my_meta)
                update_post_meta($post_id, 'x_builder_content', $my_meta);
            else
                delete_post_meta($post_id, 'x_builder_content');

        }

        public static function add_input_debug_preview()
        {
            echo '<input type="hidden" name="debug_preview" value="debug_preview">';
        }

        public static function add_field_debug_preview($fields)
        {
            $fields["debug_preview"] = "debug_preview";
            return $fields;
        }

        public static function activate_editor($wp_admin_bar)
        {

            global $post;

            if (!empty($post) and !empty($post->ID)) {

                $post_id = $post->ID;

                $enabled_for_post = stm_x_is_editor_active_for_post($post_id);

                $enabled_link = ($enabled_for_post === 'enabled') ? 'disabled' : 'enabled';

                $args = array(
                    'id' => 'x-builder-activate',
                    'title' => esc_html__('Edit with X Builder', 'x-builder'),
                    'href' => add_query_arg('x-builder-edit', "{$post_id}|{$enabled_link}"),
                    'meta' => array(
                        'class' => "x-builder-edit {$enabled_for_post}"
                    )
                );

                $wp_admin_bar->add_node($args);

            }
        }

        public static function on_off_x_builder()
        {

            if (!empty($_GET['x-builder-edit'])) {

                $data = sanitize_text_field($_GET['x-builder-edit']);

                $data = explode('|', $data);

                if (count($data) === 2) {

                    $post_id = $data[0];
                    $status = $data[1];

                    update_post_meta($post_id, 'x_builder_enabled_for_post', $status);

                }

            }
        }

    }

    new STM_X_Builder();

}