<?php
/**
 * @var $field
 * @var $field_name
 * @var $section_name
 *
 */

$field_key = "data['{$section_name}']['fields']['{$field_name}']";

include STM_X_BUILDER_DIR . '/metaboxes/components_js/typography.php';
include STM_X_BUILDER_DIR . '/metaboxes/components_js/color.php';
?>

<label v-html="<?php echo esc_attr($field_key); ?>['label']"></label>
<stmt-typography v-bind:stored_typography="<?php echo esc_attr($field_key); ?>['value']"
                 v-bind:stored_selector="<?php echo esc_attr($field_key); ?>['selector']"
                 v-bind:current_color="<?php echo esc_attr($field_key); ?>['color']"
         v-on:get-typography="<?php echo esc_attr($field_key); ?>['value'] = $event"></stmt-typography>

<input type="hidden"
       name="<?php echo esc_attr($field_name); ?>"
       v-model="<?php echo esc_attr($field_key); ?>['value']" />