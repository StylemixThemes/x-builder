<template>

    <div class="form-group">

        <h4>
            {{label}}
        </h4>

        <textarea v-bind:data-vue-editor="editor_id" v-bind:id="editor_id" v-model="form_data[data_prop]"></textarea>

    </div>
</template>

<script>

    export default {
        name: 'x_editor',
        props: ['data', 'data_prop', 'label'],
        data: function () {
            return {
                editor_id: "x-vue-editor" + this.generateRandomId(),
                editor: '',
                form_data: this.data,
            }
        },
        mounted: function () {
            if (typeof this.form_data[this.data_prop] === 'undefined') this.form_data[this.data_prop] = '';

            let _this = this;
            if (typeof wp !== 'undefined') {
                wp.editor.initialize(_this.editor_id, {
                    tinymce: {
                        wpautop: true,
                        //plugins: 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
                        plugins: "charmap colorpicker hr lists paste tabfocus textcolor fullscreen wordpress wpautoresize wpeditimage wpemoji wpgallery wplink wptextpattern",
                        toolbar1: 'formatselect bold italic | bullist numlist | blockquote | alignleft aligncenter alignright | link unlink | wp_more | forecolor backcolor',
                        init_instance_callback: function (editor) {
                            editor.on('Change', function (e) {
                                _this.$set(_this.form_data, _this.data_prop, e.level.content);
                            });
                        }
                    },
                    mediaButtons: true,
                    quicktags: true
                });

            }
        },
        methods: {
            generateRandomId: function () {
                return parseFloat(Math.round(Math.random() * 100) / 100).toFixed(4) * 1000;
            },
        },
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/forms/text.scss";
</style>