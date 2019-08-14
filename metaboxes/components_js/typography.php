<script type="text/javascript">
	<?php
	ob_start();
	include STM_X_BUILDER_DIR . '/metaboxes/components/typography.php';
	$template = preg_replace( "/\r|\n/", "", addslashes(ob_get_clean()));
	?>

    Vue.component('stmt-typography', {
        props: ['stored_typography', 'stored_selector'],
        data: function () {
            return {
                typography: {},
                selectors: '',
                color: '',
            }
        },
        mounted: function() {
            if(this.stored_selector) {
                this.selectors = this.stored_selector;
            }

            if(this.stored_typography) {
                this.typography = JSON.parse(this.stored_typography);
                if(this.typography['color']) this.color = this.typography['color'];
                if(this.typography['selectors']) this.selectors = this.typography['selectors'];
            }
        },
        template: '<?php echo stm_x_filtered_output($template); ?>',
        methods: {

        },
        watch: {
            typography: {
                handler: function () {
                    this.$emit('get-typography', JSON.stringify(this.typography));
                },
                deep: true
            },
            selectors: function (val) {
                this.typography['selectors'] = val;
                this.$emit('get-typography', JSON.stringify(this.typography));
            },
            color: function(value){
                this.typography['color'] = value;
                this.$emit('get-typography', JSON.stringify(this.typography));
            }
        }
    })
</script>