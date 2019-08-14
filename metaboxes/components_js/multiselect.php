<script type="text/javascript">
    <?php
    ob_start();
    include STM_X_BUILDER_DIR . '/metaboxes/components/multiselect.php';
    $template = preg_replace( "/\r|\n/", "", addslashes(ob_get_clean()));
    ?>

    Vue.component('multiselect', VueMultiselect.Multiselect);
    Vue.component('stmt-multiselect', {
        props: ['options', 'selected_options'],
        data: function () {
            return {
                multiselect: [],
            }
        },
        mounted: function() {
            if(this.selected_options) {
                this.multiselect = JSON.parse(this.selected_options);
            }
        },
        template: '<?php echo stm_x_filtered_output($template); ?>',
        methods: {

        },
        watch: {
            multiselect: {
                handler: function () {
                    this.$emit('get-selects', JSON.stringify(this.multiselect));
                },
                deep: true
            }
        }
    })
</script>