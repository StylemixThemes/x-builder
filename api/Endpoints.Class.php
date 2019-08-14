<?php

new STM_X_Api_Endpoints();

class STM_X_Api_Endpoints
{

    public static $namespace = 'x_builder/v1';

    public function __construct()
    {
        add_action('rest_api_init', array($this, 'contentRouteGet'));

        add_action('rest_api_init', array($this, 'contentRouteSet'));

        add_action('rest_api_init', array($this, 'elementRoute'));

        add_action('rest_api_init', array($this, 'uploadImage'));

        add_action('rest_api_init', array($this, 'getImage'));

        add_action('wp_ajax_export_page', array($this, 'exportPage'));

        add_action('wp_ajax_import_page', array($this, 'importPage'));

        add_action('wp_ajax_nopriv_import_page', array($this, 'importPage'));

    }

    public static function contentRouteGet()
    {
        register_rest_route(self::$namespace, '/content/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array('STM_X_Api_Content', 'getContent')
        ));
    }

    public static function contentRouteSet()
    {
        register_rest_route(self::$namespace, '/save_content/(?P<id>\d+)', array(
            'methods' => 'POST',
            'callback' => array('STM_X_Api_Content', 'setContent')
        ));
    }

    public static function elementRoute()
    {
        register_rest_route(self::$namespace, '/elements', array(
            'methods' => 'GET',
            'callback' => array('STM_X_Api_Elements', 'getMappedElements'),
        ));
    }

    public static function uploadImage()
    {
        register_rest_route(self::$namespace, '/upload_image', array(
            'methods' => 'POST',
            'callback' => array('STM_X_Api_Content', 'upload_image')
        ));
    }

    public static function getImage()
    {
        register_rest_route(self::$namespace, '/get_image/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array('STM_X_Api_Content', 'getImage')
        ));
    }

    public static function exportPage()
    {
        header('Content-disposition: attachment; filename=file.json');
        header('Content-type: application/json');

        $page_id = intval($_GET['page']);

        echo json_encode(get_post_meta($page_id, STM_X_Api_Content::$content, true));

        die;
    }

    public static function importPage()
    {
        $page_id = intval($_GET['page']);
        $content = '';

        global $wp_filesystem;

        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        if(!empty($_FILES['image'])) {
            $content = json_decode($wp_filesystem->get_contents($_FILES["image"]["tmp_name"]), true);
        }

        wp_send_json($content);
    }

    public static function apiUrls($post_id = '')
    {
        $rest_url = get_rest_url();
        $admin_ajax = admin_url('admin-ajax.php');

        $namespace = self::$namespace;
        return array(
            'content' => "{$rest_url}{$namespace}/content/{$post_id}",
            'save_content' => "{$rest_url}{$namespace}/save_content/{$post_id}",
            'elements' => "{$rest_url}{$namespace}/elements",
            'upload_image' => "{$rest_url}{$namespace}/upload_image",
            'get_image' => "{$rest_url}{$namespace}/get_image",
            'export_page' => "{$admin_ajax}?action=export_page&page={$post_id}",
            'import_page' => "{$admin_ajax}?action=import_page&page={$post_id}"
        );
    }

}