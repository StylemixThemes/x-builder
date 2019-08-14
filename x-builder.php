<?php
/*
Plugin Name: X Builder
Plugin URI: https://wordpress.org/plugins/x-builder/
Description: X Builder was designed both for non-tech-savvy users and WordPress experts to create or edit the content of the pages and posts easily. Save your time with X Builder, upload ready-to-use modules, move them around, edit and publish.
Author: StylemixThemes
Author URI: https://stylemixthemes.com/
Text Domain: x-builder
Version: 1.0
*/

define('STM_X_BUILDER_DIR', dirname(__FILE__));
define('STM_X_BUILDER_PATH', plugin_basename(__FILE__));
define('STM_X_BUILDER_URL', plugins_url('/', __FILE__));
define('STM_X_BUILDER_V', 5.0);

add_action('init', 'x_builder_load_textdomain');

function x_builder_load_textdomain()
{
    if (!is_textdomain_loaded('x-builder')) {
        load_plugin_textdomain(
            'x-builder',
            false,
            'x-builder/languages'
        );
    }
}

function x_pre($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}


require_once STM_X_BUILDER_DIR . "/api/main.php";
require_once STM_X_BUILDER_DIR . "/helpers/aq_resizer.php";
require_once STM_X_BUILDER_DIR . "/helpers/functions.php";
require_once STM_X_BUILDER_DIR . "/helpers/images.php";
require_once STM_X_BUILDER_DIR . "/helpers/validation.Class.php";

if (is_admin()) {
    require_once STM_X_BUILDER_DIR . "/admin/builder/builder.php";
    require_once STM_X_BUILDER_DIR . "/admin/toolbar.class.php";


    if (!class_exists('ReduxFramework') && file_exists(dirname(__FILE__) . '/ReduxFramework/ReduxCore/framework.php')) {
        require_once(dirname(__FILE__) . '/ReduxFramework/ReduxCore/framework.php');
    }


    if (!isset($redux_demo) && file_exists(dirname(__FILE__) . '/ReduxFramework/config.php')) {
        require_once(dirname(__FILE__) . '/ReduxFramework/config.php');
    }

} else {
    require_once STM_X_BUILDER_DIR . "/builder/builder.Class.php";
}