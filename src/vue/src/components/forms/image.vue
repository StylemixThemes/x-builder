<template>
    <div class="form-group">

        <h4>
            {{label}}
        </h4>

        <media_library :stored_image="form_data[data_prop]" :justAdd="'false'" v-on:get-image="imageGet($event)"></media_library>

        <input type="hidden" v-model="form_data[data_prop]" class="form-control" />
    </div>
</template>

<script>

    import media_library from './../helpers/media_library'

    export default {
        name: 'x_image',
        props: ['data', 'data_prop', 'label'],
        data: function () {
            return {
                image_id : '',
                form_data: this.data
            }
        },
        components: {
            media_library
        },
        methods : {
            imageGet($event) {
                let _this = this;
                _this.form_data[_this.data_prop] = $event.id;
            },
        }
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/forms/image.scss";
</style>