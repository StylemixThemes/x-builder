<?php
/**
 * @var $field_name
 * @var $section_name
 *
 */

$field_key = "data['{$section_name}']['fields']['{$field_name}']";

?>

<script>
    Vue.component('vue-editor', Vue2Editor.default.VueEditor);
</script>


<div class="stmt-to-editor">

    <label v-html="<?php echo esc_attr($field_key); ?>['label']"></label>
    <vue-editor v-bind:editorToolbar="customToolbar" v-model="<?php echo esc_attr($field_key); ?>['value']"></vue-editor>

    <textarea name="<?php echo esc_attr($field_name); ?>"
              v-bind:id="'<?php echo esc_attr($section_name . '-' . $field_name); ?>'"
              v-model="<?php echo esc_attr($field_key); ?>['value']">
    </textarea>
</div>