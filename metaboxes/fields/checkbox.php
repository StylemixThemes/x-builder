<?php
/**
 * @var $field_name
 * @var $section_name
 *
 */

$field_key = "data['{$section_name}']['fields']['{$field_name}']";

?>

<div class="stmt-to-admin-checkbox">
    <label v-html="<?php echo esc_attr($field_key); ?>['label']"></label>
    <div class="stmt-to-admin-checkbox-wrapper" v-bind:class="{'active' : <?php echo esc_attr($field_key); ?>['value']}">
        <div class="stmt-to-checkbox-switcher"></div>
        <input type="checkbox"
               name="<?php echo esc_attr($field_name); ?>"
               v-bind:id="'<?php echo esc_attr($section_name . '-' . $field_name); ?>'"
               v-model="<?php echo esc_attr($field_key); ?>['value']"/>
    </div>
</div>