<?php

class STM_X_Api_Content
{

    public static $content = 'x_builder_content';
    public static $preview = 'x_builder_preview';

    public static function getContent($request)
    {
        $id = intval($request->get_param('id'));

        if (empty($id)) return '';

        $post_meta = get_post_meta($id, self::$content, true);

        $x_builder_enabled_for_post = get_post_meta($id, 'x_builder_enabled_for_post', true);

        $post = get_post($id);
        $content = (!empty($post->post_content)) ? $post->post_content : '';
        if(empty($x_builder_enabled_for_post) and !empty($content)) {
            $content = array(
                array('rows' => array(
                    array('columns' => array(
                        array(
                            'elements' =>
                                array(
                                    array(
                                        'module' => 'x_text',
                                        'name' => 'Text',
                                        'element_color' => '#ff8282',
                                        'group' => 'Basic',
                                        'params' =>
                                            array(
                                                'module_name' => 'x_text',
                                                'myText' => $content,
                                                'x_typography' =>
                                                    array(),
                                            ),
                                        'show_params' =>
                                            array(
                                                'myText' =>
                                                    array(
                                                        'pre' => 'Title: ',
                                                    ),
                                            ),
                                        'box_shadow' => '',
                                    ),), 'params' => array(),),),
                        'params' => array(),
                    ),
                ),
                    'params' => array(),
                ),
            );

            $post_meta = (!empty($post_meta)) ? array_merge($content, $post_meta) : $content;
        }

        return $post_meta;

    }

    public static function setContent($request)
    {
        $id = intval($request->get_param('id'));

        global $wp_filesystem;

        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        if (empty($id)) return '';
        $request_body = $wp_filesystem->get_contents('php://input');
        $content = json_decode($request_body, true);

        $preview = ((!empty($_GET)) and (!empty($_GET['preview'])) and ($_GET['preview'] == 1));

        if (!$preview) {
            /*Create Revision;*/
            $post = get_post($id);

            $update = array(
                'ID' => $post->ID,
                'post_title' => $post->post_title,
                'post_content' => json_encode($content, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)
            );

            wp_update_post($update);
        }

        $meta = ($preview) ? self::$preview : self::$content;

        update_post_meta($id, 'x_builder_enabled_for_post', 'enabled');

        return update_post_meta($id, $meta, $content);

    }

    public static function upload_image()
    {

        $is_valid_image = Validation::is_valid($_FILES, array(
            'image' => 'required_file|extension,png;jpg;jpeg'
        ));

        if ($is_valid_image !== true) {
            wp_send_json(array(
                'error' => true,
                'message' => $is_valid_image[0]
            ));
        }


        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $attachment_id = media_handle_upload('image', 0);

        if (is_wp_error($attachment_id)) {
            return (array(
                'error' => true,
                'message' => $attachment_id->get_error_message()
            ));
        }

        $image = wp_get_attachment_image_src($attachment_id, 'img-870-440');

        return (array(
            'id' => $attachment_id,
            'url' => $image[0],
            'error' => 'false',
        ));
    }

    public static function getImage($request)
    {
        $id = intval($request->get_param('id'));
        return array(
            'image_id' => $id,
            'image_url' => stm_x_builder_get_image_src($id)
        );
    }

    public static function x_revision_has_changed()
    {
        return true;
    }

}