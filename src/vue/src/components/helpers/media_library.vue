<template>
    <div class="x-media-library">

        <div class="image-field" v-if="image_url && justAdd !== 'true'" v-bind:class="{'active' : image_url && justAdd !== 'true'}">
            <img v-bind:src="image_url"/>
        </div>
        <div class="actions">
            <div class="button" v-if="!image_url || justAdd === 'true'" @click="addImage()">
                Add Image
            </div>
            <div class="button" v-if="image_url && justAdd !== 'true'" @click="removeImage()">
                Remove Image
            </div>
            <div class="button" v-if="image_url && justAdd !== 'true'" @click="addImage()">
                Replace Image
            </div>
        </div>
    </div>
</template>

<script>

    import {endpoints} from './../../helpers/endpoints';

    export default {
        name: 'media_library',
        props: ['stored_image', 'justAdd'],
        mixins: [endpoints],
        data: function () {
            return {
                image_id: '',
                image_url: '',
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
                    _this.$set(_this, 'image_id', response.body.image_id);
                    _this.$emit('get-image', {
                        'id': _this.image_id,
                        'url': _this.image_url,
                    });
                });
            }
        },
        watch: {
            image_id: function (value) {
                let _this = this;

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