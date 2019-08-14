<template>
    <div class="x-media-library">
        <div class="image-field" v-if="images.length">
            <img v-bind:src="image_url"/>
        </div>
        <div class="actions">
            <div class="button" @click="addImage()">
                Add Image
            </div>
            <div class="button" v-if="images.length" @click="removeImage()">
                Remove All Images
            </div>
        </div>
    </div>
</template>

<script>

    import {mixins} from './../../mixins'
    import {endpoints} from './../../helpers/endpoints'

    export default {
        name: 'media_gallery',
        props: ['stored_images'],
        mixins: [mixins, endpoints],
        data: function () {
            return {
                images: [],
                media_modal: '',
            }
        },
        mounted: function () {
            let _this = this;
            _this.image_id = _this.stored_image;

            if(_this._lodash.isNumber(_this.stored_image)) _this.getImage();
        },
        methods: {
            addImage: function () {
                this.media_modal = wp.media({
                    frame: 'select',
                    multiple: false,
                    editing: true,
                });

                this.media_modal.on('select', function (value) {
                    let attachment = this.media_modal.state().get('selection').first().toJSON();

                    this.image_id = attachment.id;
                    this.image_url = attachment.url;

                }, this);

                this.media_modal.open();
            },
            removeImage: function () {
                this.image_id = this.image_url = '';
            },
            getImage: function() {
                let _this = this;
                _this.$http.get(_this.apiEndpoints.get_image + '/' + _this.image_id).then(response => {
                    _this.$set(_this, 'image_url', response.body.image_url);
                });
            }
        },
        watch: {
            image_id: function (value) {
                let _this = this;

                if(_this._lodash.isEmpty(_this['image_url'])) return false;

                _this.$emit('get-image', {
                    'id': _this.image_id,
                    'url': _this.image_url,
                });
            },
        }
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/forms/media_library";
</style>