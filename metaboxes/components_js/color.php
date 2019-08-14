<script type="text/javascript">
    Vue.component('slider-picker', VueColor.Photoshop);
	<?php
	ob_start();
	include STM_X_BUILDER_DIR . '/metaboxes/components/color.php';
	$template = preg_replace( "/\r|\n/", "", addslashes(ob_get_clean()));
	?>
    Vue.component('stmt-color', {
        props: ['current_color'],
        data: function () {
            return {
                color: '',
            }
        },
        mounted: function() {
            var colors = this.current_color.replace('rgba(', '').slice(0, -1).split(',');
            this.color = {
                r : colors[0],
                g : colors[1],
                b : colors[2],
                a : colors[3],
            }
        },
        template: '<?php echo stm_x_filtered_output($template); ?>',
        methods: {

        },
        watch: {
            color: function(value){
                if(typeof value.rgba !== 'undefined') {
                    var rgba_color = 'rgba(' + value.rgba.r + ',' + value.rgba.g + ',' + value.rgba.b + ',' + value.rgba.a + ')';
                    this.$emit('get-color', rgba_color);
                }
            }
        }
    })
</script>