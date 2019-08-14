<?php
/**
 * @var $field_name
 * @var $section_name
 *
 */

$field_key = "data['{$section_name}']['fields']['{$field_name}']";

?>

<div class="stmt-to-admin-select stmt-to-admin-select-images" v-bind:id="'<?php echo esc_attr($section_name . '-' . $field_name); ?>'">
    <label v-html="<?php echo esc_attr($field_key); ?>['label']"></label>
    <div class="stmt-to-radio">
        <label v-for="(option, key) in <?php echo esc_attr($field_key); ?>['options']">
            <input type="radio"
                   name="<?php echo esc_attr($field_name); ?>"
                   v-model="<?php echo esc_attr($field_key); ?>['value']"
                   v-bind:value="key"/>
            {{ option.title }}
            <img v-bind:src="option.image" />
        </label>
    </div>
</div>