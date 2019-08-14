<?php
if (!defined('ABSPATH')) exit; //Exit if accessed directly

if(!class_exists('STMT_Metaboxes')) {

    define( 'STM_CONFIGURATIONS_DIR', STM_X_BUILDER_DIR );
    define( 'STM_CONFIGURATIONS_PATH', STM_X_BUILDER_PATH );
    define( 'STM_CONFIGURATIONS_URL', STM_X_BUILDER_URL );

    define('STMT_TO_DIR', STM_CONFIGURATIONS_DIR . '/theme-options');
    define('STMT_TO_URL', STM_CONFIGURATIONS_URL . '/theme-options');
    define('STMT_TO_DIST', false);


    class STMT_Metaboxes
    {

        function __construct()
        {

            add_action('add_meta_boxes', array($this, 'stmt_to_register_meta_boxes'));
            add_action('admin_enqueue_scripts', array($this, 'stmt_to_scripts'), 100);
            add_action('save_post', array($this, 'stmt_to_save'), 10, 3);
            add_action('wp_ajax_stmt_curriculum', array($this, 'stmt_search_posts'));
            add_action('wp_ajax_stmt_curriculum_create_item', array($this, 'stmt_curriculum_create_item'));

            add_action('wp_ajax_stmt_save_title', array($this, 'stmt_save_title'));
            add_action('wp_ajax_stmt_get_image_url', 'STMT_Metaboxes::get_image_url');

            add_filter('stmt_multiselect_options_product_cat', 'STMT_Metaboxes::product_cat_options');
        }

        public static function product_cat_options()
        {
            $r = array();
            $product_terms = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
            ));

            if (!empty($product_terms) and !is_wp_error($product_terms)) {
                foreach ($product_terms as $product_term) {
                    $r[] = array(
                        'name' => $product_term->name,
                        'value' => $product_term->term_id,
                    );
                }
            }

            return $r;
        }

        function boxes()
        {
            return apply_filters('stmt_to_boxes', array(
                'stm_default_settings' => array(
                    'post_type' => array('post', 'page'),
                    'label' => esc_html__('Page Settings', 'stmt_theme_options'),
                ),
                'stm_testimonials' => array(
                    'post_type' => array('stmt-testimonials'),
                    'label' => esc_html__('Testimonial Settings', 'stmt_theme_options'),
                ),
                'stm_portfolio' => array(
                    'post_type' => array('stmt-portfolio'),
                    'label' => esc_html__('Portfolio Settings', 'stmt_theme_options'),
                ),
                'stm_banners' => array(
                    'post_type' => array('stmt-banners'),
                    'label' => esc_html__('Portfolio Settings', 'stmt_theme_options'),
                ),
                'stm_product' => array(
                    'post_type' => array('product'),
                    'label' => esc_html__('Product Settings', 'stmt_theme_options'),
                ),
            ));
        }

        function get_users()
        {
            $users = array(
                '' => esc_html__('Choose User', 'stmt_theme_options')
            );

            if (!is_admin()) return $users;

            $users_data = get_users();
            foreach ($users_data as $user) {
                $users[$user->ID] = $user->data->user_nicename;
            }

            return $users;
        }

        function fields()
        {

            return apply_filters('stmt_to_fields', array(
                'stm_default_settings' => array(
                    'page_settings' => array(
                        'name' => esc_html__('Page Settings', 'stmt_theme_options'),
                        'fields' => array(
                            'page_color' => array(
                                'label' => esc_html__('Page Background color', 'stmt_theme_options'),
                                'type' => 'color',
                            ),
                            'page_title_transparent' => array(
                                'label' => esc_html__('Transparent Title Box', 'stmt_theme_options'),
                                'type' => 'checkbox',
                            ),
                            'hide_page_title' => array(
                                'label' => esc_html__('Hide Page Title', 'stmt_theme_options'),
                                'type' => 'checkbox',
                            ),
                            'hide_page_bc' => array(
                                'label' => esc_html__('Hide Page NavXT BreadCrumbs', 'stmt_theme_options'),
                                'type' => 'checkbox',
                            ),
                            'footer_top_padding' => array(
                                'label' => esc_html__('Footer Top Padding (px)', 'stmt_theme_options'),
                                'type' => 'number',
                            ),
                            'footer_bottom_padding' => array(
                                'label' => esc_html__('Footer Bottom Padding (px)', 'stmt_theme_options'),
                                'type' => 'number',
                            ),
                        )
                    ),
                ),

                'stm_testimonials' => array(
                    'page_settings' => array(
                        'name' => esc_html__('Testimonial Settings', 'stmt_theme_options'),
                        'fields' => array(
                            'author' => array(
                                'label' => esc_html__('Testimonial Author', 'stmt_theme_options'),
                                'type' => 'text',
                            ),
                        )
                    ),
                ),

                'stm_portfolio' => array(
                    'page_settings' => array(
                        'name' => esc_html__('Portfolio Settings', 'stmt_theme_options'),
                        'fields' => array(
                            'gallery' => array(
                                'label' => esc_html__('Gallery', 'stmt_theme_options'),
                                'type' => 'multimedia',
                            ),
                        )
                    ),
                ),

                'stm_banners' => array(
                    'page_settings' => array(
                        'name' => esc_html__('Banner Settings', 'stmt_theme_options'),
                        'fields' => array(
                            'title' => array(
                                'label' => esc_html__('Title', 'stmt_theme_options'),
                                'type' => 'text',
                            ),
                            'title_color' => array(
                                'label' => esc_html__('Title Color', 'stmt_theme_options'),
                                'type' => 'color',
                            ),
                            'content' => array(
                                'label' => esc_html__('Content', 'stmt_theme_options'),
                                'type' => 'editor',
                            ),
                            'image' => array(
                                'label' => esc_html__('Image', 'stmt_theme_options'),
                                'type' => 'image',
                            ),
                            'bg_color' => array(
                                'label' => esc_html__('Background Color', 'stmt_theme_options'),
                                'type' => 'color',
                            ),
                            'bg' => array(
                                'label' => esc_html__('Background Image', 'stmt_theme_options'),
                                'type' => 'image',
                            ),
                            'button_title' => array(
                                'label' => esc_html__('Button Text', 'stmt_theme_options'),
                                'type' => 'text',
                                'columns' => '50'
                            ),
                            'button_link' => array(
                                'label' => esc_html__('Button Link', 'stmt_theme_options'),
                                'type' => 'text',
                                'columns' => '50'
                            ),
                            'button_title_2' => array(
                                'label' => esc_html__('Button Text 2', 'stmt_theme_options'),
                                'type' => 'text',
                                'columns' => '50'
                            ),
                            'button_link_2' => array(
                                'label' => esc_html__('Button Link 2', 'stmt_theme_options'),
                                'type' => 'text',
                                'columns' => '50'
                            ),
                            'banner_style' => array(
                                'label' => esc_html__('Banner Style', 'stmt_theme_options'),
                                'type' => 'select',
                                'options' => array(
                                    '' => esc_html__('Select Banner Style', 'stmt_theme_options'),
                                    'style_1' => esc_html__('Style 1', 'stmt_theme_options'),
                                    'style_2' => esc_html__('Style 2', 'stmt_theme_options'),
                                    'style_3' => esc_html__('Style 3', 'stmt_theme_options'),
                                ),
                                'columns' => '50'
                            ),
                        )
                    ),
                ),

                'stm_product' => array(
                    'product_settings' => array(
                        'name' => esc_html__('Product Settings', 'stmt_theme_options'),
                        'fields' => array(
                            'product_style' => array(
                                'label' => esc_html__('Product Style', 'stmt_theme_options'),
                                'type' => 'select',
                                'options' => array(
                                    '' => esc_html__('Global Settings', 'stmt_theme_options'),
                                    'style_1' => esc_html__('Image Left', 'stmt_theme_options'),
                                    'style_2' => esc_html__('Image Right', 'stmt_theme_options'),
                                    'style_3' => esc_html__('Image Center', 'stmt_theme_options'),
                                ),
                                'value' => 'style_1'
                            ),
                        )
                    ),
                    'product_hint_images' => array(
                        'name' => esc_html__('Hint Images', 'stmt_theme_options'),
                        'fields' => array(
                            'hint_image_1' => array(
                                'label' => esc_html__('Image 1 (740x400)', 'stmt_theme_options'),
                                'type' => 'hint_image',
                            ),
                            'hint_image_2' => array(
                                'label' => esc_html__('Image 2 (985x760)', 'stmt_theme_options'),
                                'type' => 'hint_image',
                            ),
                            'hint_image_3' => array(
                                'label' => esc_html__('Image 3 (890x630)', 'stmt_theme_options'),
                                'type' => 'hint_image',
                            ),
                        )
                    ),
                    'page_settings' => array(
                        'name' => esc_html__('Product IconBox', 'stmt_theme_options'),
                        'fields' => array(
                            'iconbox_title' => array(
                                'label' => esc_html__('Iconbox Title', 'stmt_theme_options'),
                                'type' => 'text',
                            ),
                            'iconbox_icon_1' => array(
                                'label' => esc_html__('Icon 1', 'stmt_theme_options'),
                                'type' => 'iconpicker',
                                'columns' => 50
                            ),
                            'iconbox_title_1' => array(
                                'label' => esc_html__('Title 1', 'stmt_theme_options'),
                                'type' => 'text',
                                'columns' => 50
                            ),
                            'iconbox_icon_2' => array(
                                'label' => esc_html__('Icon 2', 'stmt_theme_options'),
                                'type' => 'iconpicker',
                                'columns' => 50
                            ),
                            'iconbox_title_2' => array(
                                'label' => esc_html__('Title 2', 'stmt_theme_options'),
                                'type' => 'text',
                                'columns' => 50
                            ),
                            'iconbox_icon_3' => array(
                                'label' => esc_html__('Icon 3', 'stmt_theme_options'),
                                'type' => 'iconpicker',
                                'columns' => 50
                            ),
                            'iconbox_title_3' => array(
                                'label' => esc_html__('Title 3', 'stmt_theme_options'),
                                'type' => 'text',
                                'columns' => 50
                            ),
                            'iconbox_icon_4' => array(
                                'label' => esc_html__('Icon 4', 'stmt_theme_options'),
                                'type' => 'iconpicker',
                                'columns' => 50
                            ),
                            'iconbox_title_4' => array(
                                'label' => esc_html__('Title 4', 'stmt_theme_options'),
                                'type' => 'text',
                                'columns' => 50
                            ),
                            'iconbox_icon_5' => array(
                                'label' => esc_html__('Icon 5', 'stmt_theme_options'),
                                'type' => 'iconpicker',
                                'columns' => 50
                            ),
                            'iconbox_title_5' => array(
                                'label' => esc_html__('Title 5', 'stmt_theme_options'),
                                'type' => 'text',
                                'columns' => 50
                            ),
                        )
                    ),
                    'x_builder_section' => array(
                        'name' => esc_html__('Additional Images', 'stmt_theme_options'),
                        'fields' => array(
                            'product_carousel_grid' => array(
                                'label' => esc_html__('Image for Product Carousel Grid', 'stmt_theme_options'),
                                'type' => 'image',
                            ),
                        )
                    ),
                ),

            ));
        }

        function get_fields($metaboxes)
        {
            $fields = array();
            foreach ($metaboxes as $metabox_name => $metabox) {
                foreach ($metabox as $section) {
                    foreach ($section['fields'] as $field_name => $field) {
                        $sanitize = (!empty($field['sanitize'])) ? $field['sanitize'] : 'stmt_to_save_field';
                        $fields[$field_name] = !empty($_POST[$field_name]) ? call_user_func(array($this, $sanitize), $_POST[$field_name], $field_name) : '';
                    }
                }
            }

            return $fields;
        }

        function stmt_to_save_field($value)
        {
            return $value;
        }

        function stmt_to_save_number($value)
        {
            return intval($value);
        }

        function stmt_to_save_dates($value, $field_name)
        {
            global $post_id;

            $dates = explode(',', $value);
            if (!empty($dates) and count($dates) > 1) {
                update_post_meta($post_id, $field_name . '_start', $dates[0]);
                update_post_meta($post_id, $field_name . '_end', $dates[1]);
            }

            return $value;
        }

        function stmt_to_register_meta_boxes()
        {
            $boxes = $this->boxes();
            foreach ($boxes as $box_id => $box) {
                $box_name = $box['label'];
                add_meta_box($box_id, $box_name, array($this, 'stmt_to_display_callback'), $box['post_type'], 'normal', 'high', $this->fields());
            }
        }

        function stmt_to_display_callback($post, $metabox)
        {
            $meta = $this->convert_meta($post->ID);
            foreach ($metabox['args'] as $metabox_name => $metabox_data) {
                foreach ($metabox_data as $section_name => $section) {
                    foreach ($section['fields'] as $field_name => $field) {
                        $default_value = (!empty($field['value'])) ? $field['value'] : '';
                        $value = (isset($meta[$field_name])) ? $meta[$field_name] : $default_value;
                        if (!empty($value)) {
                            switch ($field['type']) {
                                case 'dates' :
                                    $value = explode(',', $value);
                                    break;
                                case 'answers' :
                                    $value = unserialize($value);
                                    break;
                            }
                        }
                        $metabox['args'][$metabox_name][$section_name]['fields'][$field_name]['value'] = $value;
                    }
                }
            }
            include STM_X_BUILDER_DIR . '/metaboxes/metabox-display.php';
        }

        function convert_meta($post_id)
        {
            $meta = get_post_meta($post_id);
            $metas = array();
            foreach ($meta as $meta_name => $meta_value) {
                $metas[$meta_name] = $meta_value[0];
            }

            return $metas;
        }

        function stmt_to_scripts($hook)
        {
            $v = time();
            $base = STM_X_BUILDER_URL . '/metaboxes/assets/';
            wp_enqueue_media();
            wp_enqueue_script('vue.js', $base . 'js/vue.min.js', array('jquery'), $v);
            wp_enqueue_script('vue-resource.js', $base . 'js/vue-resource.min.js', array('vue.js'), $v);
            wp_enqueue_script('vue2-datepicker.js', $base . 'js/vue2-datepicker.min.js', array('vue.js'), $v);
            wp_enqueue_script('vue-select.js', $base . 'js/vue-select.js', array('vue.js'), $v);
            wp_enqueue_script('vue2-editor.js', $base . 'js/vue2-editor.min.js', array('vue.js'), $v);
            wp_enqueue_script('vue2-color.js', $base . 'js/vue-color.min.js', array('vue.js'), $v);
            wp_enqueue_script('sortable.js', $base . 'js/sortable.min.js', array('vue.js'), $v);
            wp_enqueue_script('vue-multiselect.js', $base . 'js/vue-multiselect.min.js', array('vue.js'), $v);
            wp_enqueue_script('vue-draggable.js', $base . 'js/vue-draggable.min.js', array('sortable.js'), $v);
            wp_enqueue_script('stmt_to_mixins.js', $base . 'js/mixins.js', array('vue.js'), $v);
            wp_enqueue_script('stmt_to_metaboxes.js', $base . 'js/metaboxes.js', array('vue.js'), $v);
            wp_enqueue_script('fonticonpicker', $base . 'js/jquery.fonticonpicker.min.js', array(), $v);

            wp_enqueue_style('vue-multiselect.css', $base . 'css/vue-multiselect.min.css', array(), $v);
            wp_enqueue_style('stmt-to-metaboxes.css', $base . 'css/main.css', array(), $v);
            wp_enqueue_style('linear-icons', $base . 'css/linear-icons.css', array('stmt-to-metaboxes.css'), $v);
            wp_enqueue_style('fonticonpicker', $base . 'css/jquery.fonticonpicker.min.css', array(), $v);

        }

        function stmt_to_post_types()
        {
            return apply_filters('stmt_to_post_types', array(
                'page',
                'post',
                'product',
                'stmt-testimonials',
                'stmt-portfolio',
                'stmt-banners',
            ));
        }

        function stmt_to_save($post_id, $post)
        {

            $post_type = get_post_type($post_id);

            if (!in_array($post_type, $this->stmt_to_post_types())) return;

            if (!empty($_POST) and !empty($_POST['action']) and $_POST['action'] === 'editpost') {

                $fields = $this->get_fields($this->fields());

                foreach ($fields as $field_name => $field_value) {
                    update_post_meta($post_id, $field_name, $field_value);
                }
            }


        }

        function stmt_search_posts()
        {
            $r = array();

            $args = array(
                'posts_per_page' => 10,
            );

            if (!empty($_GET['s'])) {
                $args['s'] = sanitize_text_field($_GET['s']);
            }

            if (!empty($_GET['post_types'])) {
                $args['post_type'] = explode(',', sanitize_text_field($_GET['post_types']));
            }

            if (!empty($_GET['ids'])) {
                $args['post__in'] = explode(',', sanitize_text_field($_GET['ids']));
            }

            if (!empty($_GET['exclude_ids'])) {
                $args['post__not_in'] = explode(',', sanitize_text_field($_GET['exclude_ids']));
            }

            if (!empty($_GET['orderby'])) {
                $args['orderby'] = sanitize_text_field($_GET['orderby']);
            }

            $q = new WP_Query($args);
            if ($q->have_posts()) {
                while ($q->have_posts()) {
                    $q->the_post();

                    $response = array(
                        'id' => get_the_ID(),
                        'title' => get_the_title(),
                    );

                    if (in_array('stmt-questions', $args['post_type'])) {
                        $response = array_merge($response, $this->question_fields($response['id']));
                    }

                    $r[] = $response;
                }

                wp_reset_postdata();
                wp_reset_query();
            }

            $insert_sections = array();
            foreach ($args['post__in'] as $key => $post) {
                if (!is_numeric($post)) {
                    $insert_sections[$key] = array('id' => $post, 'title' => $post);
                }
            }

            foreach ($insert_sections as $position => $inserted) {
                array_splice($r, $position, 0, array($inserted));
            }

            wp_send_json($r);
        }

        function get_question_fields()
        {
            return array(
                'type' => array(
                    'default' => 'single_choice',
                ),
                'answers' => array(
                    'default' => array(),
                ),
                'question' => array(),
                'question_explanation' => array(),
                'question_hint' => array(),
            );
        }

        function question_fields($post_id)
        {
            $fields = $this->get_question_fields();
            $meta = array();

            foreach ($fields as $field_key => $field) {
                $meta[$field_key] = get_post_meta($post_id, $field_key, true);
                $default = (isset($field['default'])) ? $field['default'] : '';
                $meta[$field_key] = (!empty($meta[$field_key])) ? $meta[$field_key] : $default;
            }

            return $meta;
        }

        function stmt_curriculum_create_item()
        {
            $r = array();
            $available_post_types = array('stmt-lessons', 'stmt-quizzes', 'stmt-questions');

            if (!empty($_GET['post_type'])) $post_type = sanitize_text_field($_GET['post_type']);
            if (!empty($_GET['title'])) $title = sanitize_text_field($_GET['title']);

            /*Check if data passed*/
            if (empty($post_type) and empty($title)) return;

            /*Check if available post type*/
            if (!in_array($post_type, $available_post_types)) return;

            $item = array(
                'post_type' => $post_type,
                'post_title' => wp_strip_all_tags($title),
                'post_status' => 'publish',
            );

            $r['id'] = wp_insert_post($item);
            $r['title'] = get_the_title($r['id']);

            if ($post_type == 'stmt-questions') {
                $r = array_merge($r, $this->question_fields($r['id']));
            }

            wp_send_json($r);

        }



        function stmt_save_title()
        {
            if (empty($_GET['id']) and !empty($_GET['title'])) return false;

            $post = array(
                'ID' => intval($_GET['id']),
                'post_title' => sanitize_text_field($_GET['title']),
            );

            wp_update_post($post);

            wp_send_json($post);
        }

        public static function get_image_url()
        {
            if (empty($_GET['image_id'])) die;
            wp_send_json(wp_get_attachment_url(intval($_GET['image_id'])));
        }
    }

    new STMT_Metaboxes();

    function stmt_to_metaboxes_deps($field, $section_name)
    {
        $dependency = '';
        if (empty($field['dependency'])) return $dependency;

        $key = $field['dependency']['key'];
        $compare = $field['dependency']['value'];

        $compared_value = "data['{$section_name}']['fields']['{$key}']['value']";

        if ($compare === 'not_empty') {
            $dependency = "v-if=data['{$section_name}']['fields']['{$key}']['value']";
        } else {
            $dependency = "v-if=\"data['{$section_name}']['fields']['{$key}']['value'] === '{$compare}'\"";
        }

        return $dependency;
    }

}