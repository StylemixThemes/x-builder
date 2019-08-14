<?php
/**
 * @var $field_name
 * @var $section_name
 *
 */

$field = "data['{$section_name}']['fields']['{$field_name}']";

include STM_X_BUILDER_DIR . '/metaboxes/components_js/color.php';
?>

<div class="stmt_colorpicker_wrapper">
    <label v-html="<?php echo esc_attr($field); ?>['label']"></label>
    <span v-bind:style="{'background-color': <?php echo esc_attr($field); ?>['value']}"></span>
    <input type="text"
           name="<?php echo esc_attr($field_name); ?>"
           v-bind:placeholder="<?php echo esc_attr($field); ?>['label']"
           v-bind:id="'<?php echo esc_attr($section_name . '-' . $field_name); ?>'"
           v-model="<?php echo esc_attr($field); ?>['value']"/>
    <stmt-color v-bind:current_color="<?php echo esc_attr($field); ?>['value']" v-on:get-color="<?php echo esc_attr($field); ?>['value'] = $event"></stmt-color>
</div>