<?php

add_action('before_delete_post', 'stm_x_builder_clear_cache');
add_action('save_post', 'stm_x_builder_clear_cache');

function stm_x_builder_clear_cache()
{
    global $wpdb;
    $sql = "SELECT `option_name` AS `name`, `option_value` AS `value`
            FROM  $wpdb->options
            WHERE `option_name` LIKE '%transient_%'
            ORDER BY `option_name`";

    $results = $wpdb->get_results( $sql );


    foreach($results as $result) {
        if(strpos($result->name, '_transient_x_') !== 0) continue;
        delete_transient(str_replace('_transient_', '', $result->name));
    }

}

function stm_x_builder_get_element_params($module)
{
    //x_pre($module);
    $element = STM_X_Api_Elements::getElement($module, false);
    $default_params = array();

    if (!isset($element['params']) or !isset($element['params']['fields'])) return $default_params;

    foreach ($element['params']['fields'] as $field) {
        $default_value = isset($field['value']) ? $field['value'] : '';
        $default_params[$field['id']] = $default_value;
    }

    return $default_params;

}

function stm_x_builder_get_params($module, $params)
{
    $default_params = stm_x_builder_get_element_params($module);

    return wp_parse_args($params, $default_params);
}

function stm_x_builder_register_style($module, $deps = array(), $inline_styles = '')
{
    $handle = "x_builder_{$module}";
    $css_url = apply_filters('x_builder_css_path', STM_X_BUILDER_URL . 'public/css/');
    $src = apply_filters("x_builder_{$module}_style", "{$css_url}public/modules/{$module}.css");
    $v = (WP_DEBUG) ? time() : '1.0';
    wp_enqueue_style($handle, $src, $deps, $v);
    if (!empty($inline_styles)) wp_add_inline_style($handle, $inline_styles);
}

function stm_x_builder_register_script($module, $deps = array(), $inline = '', $localize_name = '', $localize = array())
{
    $handle = "x_builder_{$module}";
    $src = apply_filters("x_builder_{$module}_style", STM_X_BUILDER_URL . "public/js/modules/{$module}.js");
    $v = (WP_DEBUG) ? time() : '1.0';
    wp_enqueue_script($handle, $src, $deps, time(), $v);

    if (!empty($inline)) {
        wp_add_inline_script($handle, $inline);
    }

    if (!empty($localize) and !empty($localize_name)) {
        wp_localize_script($handle, $localize_name, $localize);
    }
}

function stm_x_builder_version()
{
    return (!WP_DEBUG) ? '1.0' : STM_X_BUILDER_V;
}

function stm_x_builder_module_id($module, $params)
{
    return $module . md5(json_encode($params));
}

function stm_x_get_terms($taxonomy)
{
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ));

    if (is_wp_error($terms)) return array();

    return $terms;
}

function stm_x_get_terms_list($taxonomy)
{
    $terms = stm_x_get_terms($taxonomy);

    if (empty($terms)) return '';

    return wp_list_pluck($terms, 'name');
}

function stm_x_get_terms_select($taxonomy)
{
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ));

    $terms_data = array(
        '' => esc_html__('Choose', 'x-builder')
    );

    if (is_wp_error($terms)) return $terms_data;

    foreach ($terms as $term) {
        $terms_data[$term->term_id] = $term->name;
    }

    return $terms_data;
}

function stm_x_get_posts($post_type)
{
    $posts = array();
    $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => -1
    );

    $q = new WP_Query($args);


    if ($q->have_posts()) {
        while ($q->have_posts()) {
            $q->the_post();
            $posts[] = array(
                'name' => get_the_title(),
                'term_id' => get_the_ID(),
            );
        }

        wp_reset_postdata();
    }

    return $posts;

}

function stm_x_get_posts_select($post_type)
{
    $posts = array(
        '' => esc_html__('Choose', 'x-builder')
    );
    $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => -1
    );

    $q = new WP_Query($args);


    if ($q->have_posts()) {
        while ($q->have_posts()) {
            $q->the_post();
            $posts[get_the_ID()] = get_the_title();
        }

        wp_reset_postdata();
    }


    return $posts;

}

function stm_x_get_min_price_per_product_cat($term_id)
{

    global $wpdb;

    $sql = "

    SELECT  MIN( meta_value+0 ) as minprice

    FROM {$wpdb->posts} 

    INNER JOIN {$wpdb->term_relationships} ON ({$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id)

    INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id) 

    WHERE  

      ( {$wpdb->term_relationships}.term_taxonomy_id IN (%d) ) 

    AND {$wpdb->posts}.post_type = 'product' 

    AND {$wpdb->posts}.post_status = 'publish' 

    AND {$wpdb->postmeta}.meta_key = '_price'

  ";

    return $wpdb->get_var($wpdb->prepare($sql, $term_id));

}

add_action('wp', 'stm_x_set_viewed_products');

function stm_x_set_viewed_products()
{

    if (stm_x_is_product()) {

        $cookie_name = 'x_builder_viewed_products_' . get_current_blog_id();
        $product_id = get_the_ID();

        /*Get Current Viewed Products*/
        $viewed = (!empty($_COOKIE[$cookie_name])) ? $_COOKIE[$cookie_name] : '';
        $viewed = array_filter(explode('|', $viewed));

        if (!in_array($product_id, $viewed)) {
            array_unshift($viewed, $product_id);
            stm_x_add_product_views($product_id);
        }

        setcookie($cookie_name, implode('|', $viewed), time() + (86400 * 30 * 30), "/");

    }

}

function stm_x_is_product()
{
    return (function_exists('is_product')) ? is_product() : false;
}

function stm_x_get_current_week()
{
    return strtotime('last monday', strtotime('tomorrow'));
}

function stm_x_add_product_views($product_id)
{

    $week_start = stm_x_get_current_week();
    $meta_name = "x_builder_product_views_{$week_start}";

    stm_x_save_weeks($week_start);

    $current_views = intval(get_post_meta($product_id, $meta_name, true));
    if (empty($current_views)) $current_views = 0;
    $current_views++;

    update_post_meta($product_id, $meta_name, $current_views);
}

function stm_x_save_weeks($week)
{
    $weeks = get_option('x_builder_weeks', array());
    if (!in_array($week, $weeks)) $weeks[] = $week;

    update_option('x_builder_weeks', $weeks);
}

function stm_x_get_post_terms($id, $taxonomy)
{
    $terms = get_the_terms($id, $taxonomy);
    if (is_wp_error($terms) or empty($terms)) return array();

    return $terms;
}

function stm_x_get_post_terms_list($id, $taxonomy)
{
    $terms = stm_x_get_post_terms($id, $taxonomy);

    if (empty($terms)) return '';

    return wp_list_pluck($terms, 'name');
}

function stm_x_get_option($option_name, $default = '')
{
    $options = get_option('x_builder_options', array());
    return (isset($options[$option_name])) ? $options[$option_name] : $default;
}

function stm_x_clear_cache_button($wp_admin_bar)
{
    $args = array(
        'id' => 'x-builder-clear-cache',
        'title' => esc_html__('Clear X Builder Cache', 'x-builder'),
        'href' => add_query_arg('x-builder-cache', 'clear'),
        'meta' => array(
            'class' => 'x-builder-class'
        )
    );
    $wp_admin_bar->add_node($args);
}

add_action('admin_bar_menu', 'stm_x_clear_cache_button', 50);

if (!empty($_GET['x-builder-cache']) and $_GET['x-builder-cache'] === 'clear') {
    add_action('init', 'stm_x_clear_cache');

    function stm_x_clear_cache()
    {
        stm_x_builder_clear_cache();
    }
}

function stm_x_set_transient($transient_name, $r, $time = '') {
    set_transient($transient_name, $r);
}

function stm_x_is_editor_active_for_precised_post($post_id) {
    $enabled_for_post = get_post_meta($post_id, 'x_builder_enabled_for_post', true);


    return ($enabled_for_post === 'enabled') ? 'enabled' : 'disabled';

}

function stm_x_is_editor_active_for_post($post_id = '', $post_type = '')
{

    $post_type = (!empty($post_type)) ? $post_type : get_post_type($post_id);

    $options = get_option('x_builder_options');

    $enabled_options = (!empty($options['enabled_on_x'])) ? $options['enabled_on_x'] : array();
    if(gettype($enabled_options) === 'string') $enabled_options = explode(' ', $enabled_options);

    $enabled_for_post_type = in_array($post_type, $enabled_options);

    $enabled_for_post_type = ($enabled_for_post_type) ? 'enabled' : 'disabled';

    if(empty($post_id)) return $enabled_for_post_type;

    $enabled_for_post = get_post_meta($post_id, 'x_builder_enabled_for_post', true);

    if (empty($enabled_for_post)) $enabled_for_post = $enabled_for_post_type;

    return $enabled_for_post;
}

function stm_x_filtered_output($data) {
    return apply_filters('x_filtered_output', $data);
}