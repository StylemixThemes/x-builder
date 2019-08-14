<?php
/**
 * @var $field
 * @var $field_name
 * @var $section_name
 *
 */

$field_key = "data['{$section_name}']['fields']['{$field_name}']";

include STM_X_BUILDER_DIR . '/metaboxes/components_js/payments.php';
?>

<stmt-payments v-on:update-payments="<?php echo esc_attr($field_key) ?>['value'] = $event"
              v-bind:saved_payments="<?php echo esc_attr($field_key); ?>['value']"></stmt-payments>
