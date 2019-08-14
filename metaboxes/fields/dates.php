<?php
/**
 * @var $field_name
 * @var $section_name
 *
 */

$field_key = "data['{$section_name}']['fields']['{$field_name}']";

?>

<script type="text/javascript">
	<?php
	ob_start();
	include STM_X_BUILDER_DIR . '/metaboxes/components/datepicker.php';
	$template = preg_replace( "/\r|\n/", "", ob_get_clean() );
	?>

    Vue.component('date-picker', DatePicker.default);
    Vue.component('stmt-datepicker', {
        props: ['current_date'],
        data: function () {
            return {
                date: []
            }
        },
        mounted: function() {
            if(typeof this.current_date[0] !== 'undefined') {
                this.date.push(new Date(parseInt(this.current_date[0])));
            }
            if(typeof this.current_date[1] !== 'undefined') {
                this.date.push(new Date(parseInt(this.current_date[1])));
            }
        },
        template: '<?php echo stm_x_filtered_output($template); ?>',
        methods: {
            dateChanged(newDate) {
                var customDate = [];
                customDate.push(new Date(newDate[0]).getTime());
                customDate.push(new Date(newDate[1]).getTime());
                this.$emit('date-changed', customDate);
            }
        },
    })
</script>

<label v-html="<?php echo esc_attr($field_key); ?>['label']"></label>

<stmt-datepicker v-bind:current_date="<?php echo esc_attr($field_key) ?>['value']"
                placeholder=""
                v-on:date-changed="<?php echo esc_attr($field_key) ?>['value'] = $event"></stmt-datepicker>


<input type="hidden" name="<?php echo esc_attr($field_name); ?>" v-model="<?php echo esc_attr($field_key) ?>['value']" />
<input type="hidden" name="<?php echo esc_attr($field_name . '_start'); ?>" v-model="<?php echo esc_attr($field_key) ?>['value'][0]" />
<input type="hidden" name="<?php echo esc_attr($field_name . '_end'); ?>" v-model="<?php echo esc_attr($field_key) ?>['value'][1]" />