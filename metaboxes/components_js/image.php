<script type="text/javascript">
	<?php
	ob_start();
	include STM_X_BUILDER_DIR . '/metaboxes/components/image.php';
	$template = preg_replace("/\r|\n/", "", addslashes(ob_get_clean()));
	?>
    Vue.component('stm-image', {
        props: ['stored_image'],
        mixins: [stm_lms_get_image_mixin],
        data: function () {
            return {
                image_id: '',
                media_modal: '',
            }
        },
        mounted: function () {
            var vm = this;
            vm.image_id = vm.stored_image;
        },
        template: '<?php echo stm_x_filtered_output($template); ?>',
        methods: {
            addImage: function(){
                this.media_modal = wp.media({
                    frame: 'select',
                    multiple: false,
                    editing: true,
                });

                this.media_modal.on('select', function (value) {
                    var attachment = this.media_modal.state().get('selection').first().toJSON();

                    this.image_id = attachment.id;
                    this.image_url = attachment.url;

                }, this);

                this.media_modal.open();
            },
            removeImage: function() {
                this.image_id = this.image_url = '';
            }
        },
        watch: {
            image_id: function (value) {
                this.$emit('get-image', value);
                this.$emit('get-image-url', this.image_url);
            },
        }
    })
</script>