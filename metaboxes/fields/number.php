<?php
/**
 * @var $field_name
 * @var $section_name
 *
 */

$field = "data['{$section_name}']['fields']['{$field_name}']";

?>

<label v-html="<?php echo esc_attr($field); ?>['label']"></label>
<input type="number"
       name="<?php echo esc_attr($field_name);?>"
       v-bind:placeholder="<?php echo esc_attr($field); ?>['label']"
       v-bind:id="'<?php echo esc_attr($section_name . '-' . $field_name);?>'"
       v-model="<?php echo esc_attr($field); ?>['value']" />