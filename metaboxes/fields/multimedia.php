<?php
/**
 * @var $field_name
 * @var $section_name
 *
 */

$field_key = "data['{$section_name}']['fields']['{$field_name}']";

?>

<label v-html="<?php echo esc_attr($field_key); ?>['label']"></label>

<script type="text/javascript">
	<?php
	ob_start();
	include STM_X_BUILDER_DIR . '/metaboxes/components/multimedia.php';
	$template = preg_replace( "/\r|\n/", "", addslashes(ob_get_clean()) );
	?>
    Vue.component('stmt-multimedia', {
        props: ['files'],
        data: function () {
            return {
                media: [],
                media_modal: ''
            }
        },
        mounted: function() {
            this.media = JSON.parse(this.files);
        },
        template: '<?php echo stm_x_filtered_output($template); ?>',
        methods: {
            addMedia() {
                this.media.push({
                    id : '',
                    url : '',
                });
            },
            addFile(k) {
                this.media_modal = wp.media({
                    frame: 'select',
                    multiple: false,
                    editing: true,
                });

                this.media_modal.on('select', function (value) {
                    var attachment = this.media_modal.state().get('selection').first().toJSON();

                    var preview = (typeof attachment.sizes !== 'undefined') ? attachment.sizes.thumbnail.url : '';

                    this.$set(this.media[k], 'id', attachment.id);
                    this.$set(this.media[k], 'url', attachment.url);
                    this.$set(this.media[k], 'type', attachment.type);
                    this.$set(this.media[k], 'preview', preview);
                }, this);

                this.media_modal.open();
            },
            removeMedia(k, confirm_message) {
                var r = confirm(confirm_message);
                if(r) this.media.splice(k, 1);
            },
            addMediaBulk() {
                var vm = this;
                this.media_modal = wp.media({
                    frame: 'select',
                    multiple: true,
                    editing: true,
                });

                this.media_modal.on('select', function (value) {
                    var attachments = this.media_modal.state().get('selection').toJSON();
                    attachments.forEach(function(attachment){

                        var file = {
                            id: attachment.id,
                            url: attachment.url,
                            type: attachment.type,
                        };

                        file['preview'] = (typeof attachment.sizes !== 'undefined') ? attachment.sizes.thumbnail.url : '';

                        vm.media.push(file);
                    });
                }, this);

                this.media_modal.open();
            }
        },
        watch: {
            media: {
                handler(value){
                    var json_value = [];
                    value.forEach(function(v){
                        if(v['url'] !== '') {
                            json_value.push(v);
                        }
                    });
                    this.$emit('get-files', JSON.stringify(json_value));
                },
                deep: true
            }
        }
    });
</script>

<stmt-multimedia v-on:get-files="<?php echo esc_attr($field_key) ?>['value'] = $event" v-bind:files="<?php echo esc_attr($field_key); ?>['value']"></stmt-multimedia>


<input type="hidden"
       name="<?php echo esc_attr($field_name); ?>"
       v-bind:id="'<?php echo esc_attr($section_name . '-' . $field_name); ?>'"
       v-model="<?php echo esc_attr($field_key); ?>['value']" />