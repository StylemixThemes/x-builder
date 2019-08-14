<?php
/**
 * @var $field_name
 * @var $section_name
 *
 */

$option_name = $metabox['args']['stmt_to_settings'][$section_name]['fields'][$field_name]['options'];

$field_key = "data['{$section_name}']['fields']['{$field_name}']";

include STM_X_BUILDER_DIR . '/metaboxes/components_js/multiselect.php';

$options = apply_filters("stmt_multiselect_options_{$option_name}", array());

?>

<label v-html="<?php echo esc_attr($field_key); ?>['label']"></label>

<stmt-multiselect v-bind:options='<?php echo str_replace('\'', '', json_encode($options)); ?>'
                  v-bind:selected_options='<?php echo esc_attr($field_key); ?>["value"]'
                  v-on:get-selects="<?php echo esc_attr($field_key); ?>['value'] = $event"></stmt-multiselect>

<input type="hidden"
       name="<?php echo esc_attr($field_name); ?>"
       v-model="<?php echo esc_attr($field_key); ?>['value']"/>