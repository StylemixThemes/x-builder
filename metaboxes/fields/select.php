<?php
/**
 * @var $field_name
 * @var $section_name
 *
 */

$field_key = "data['{$section_name}']['fields']['{$field_name}']";

?>

<div class="stmt-to-admin-select">

    <label v-html="<?php echo esc_attr($field_key); ?>['label']"></label>
    <select name="<?php echo esc_attr($field_name); ?>"
            v-model="<?php echo esc_attr($field_key); ?>['value']"
            v-bind:id="'<?php echo esc_attr($section_name . '-' . $field_name); ?>'">
        <option v-for="(option, key) in <?php echo esc_attr($field_key); ?>['options']" v-bind:value="key">{{ option }}</option>
    </select>
</div>