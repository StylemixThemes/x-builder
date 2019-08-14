<template>

    <div class="form-group">

        <media_library :justAdd="'true'" v-on:get-image="imageGet($event)"></media_library>

        <vue-editor useCustomImageHandler
                    @click="clicked($event)"
                    @focus="focus($event)"
                    @selection-change="selectionChange($event)"
                    @text-change="textChange($event)"
                    :customModules="customModulesForEditor"
                    :editorOptions="editorSettings"
                    :editorToolbar="customToolbar"
                    @imageAdded="handleImageAdded"
                    v-model="form_data[data_prop]">
        </vue-editor>

    </div>
</template>

<script>
    import media_library from './../helpers/media_library'
    import {endpoints} from './../../helpers/endpoints'
    import {VueEditor, Quill} from 'vue2-editor'

    import {ImageDrop} from 'quill-image-drop-module'
    import ImageResize from 'quill-image-resize-module'

    Quill.register('modules/imageResize', ImageResize);
    Quill.register('modules/imageDrop', ImageDrop);

    export default {
        name: 'x_editor',
        props: ['data', 'data_prop', 'label'],
        mixins: [endpoints],
        data: function () {
            return {
                cursorPosition: 0,
                form_data: this.data,
                customModulesForEditor: [
                    {alias: "imageDrop", module: ImageDrop},
                    {alias: "imageResize", module: ImageResize}
                ],
                editorSettings: {
                    modules: {
                        imageDrop: true,
                        imageResize: {
                            modules: ['Resize', 'DisplaySize', 'Toolbar']
                        }
                    }
                },
                customToolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ["bold", "italic", "underline"],
                    [{list: "ordered"}, {list: "bullet"}],
                    ["image", "code-block"],
                    [{ 'color': [
                        '#000',
                        '#e60000',
                        '#ff9900',
                        '#ffff00',
                        '#008a00',
                        '#0066cc',
                        '#9933ff',
                        '#ae56c2',
                        '#ffffff',
                        '#facccc',
                        '#ffebcc',
                        '#ffffcc',
                        '#cce8cc',
                        '#cce0f5',
                        '#ebd6ff',
                        '#bbbbbb',
                        '#f06666',
                        '#ffc266',
                        '#ffff66',
                        '#66b966',
                        '#66a3e0',
                        '#c285ff',
                        '#888888',
                        '#a10000',
                        '#b26b00',
                        '#b2b200',
                        '#006100',
                        '#0047b2',
                        '#6b24b2',
                        '#444444',
                        '#5c0000',
                        '#663d00',
                        '#666600',
                        '#003700',
                        '#002966',
                        '#3d1466',
                        '#2e1212',
                        '#2659cf',
                        '#022248',
                        '#1241cd',
                        '#fde3ee',
                        '#222832',
                        '#FFC400',
                        '#2a2c32',
                        '#6e62e2',
                        '#24c37d'
                        ] }, { 'background': [] }],
                    [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }]
                ]
            }
        },
        components: {
            VueEditor,
            media_library
        },
        mounted: function() {
            if(typeof this.form_data[this.data_prop] === 'undefined') this.form_data[this.data_prop] = '';
        },
        methods: {
            selectionChange(range) {
                if (this._lodash.isObject(range))
                    this.cursorPosition = range.index;
            },
            focus(event) {
                let _this = this;
                _this.cursorPosition = event.getSelection().index;
            },
            textChange(delta) {
                let _this = this;
                if (_this._lodash.isNumber(delta.ops[0].retain))
                    _this.cursorPosition = delta.ops[0].retain;
            },
            handleImageAdded(file, Editor, cursorLocation) {
                let _this = this;
                let formData = new FormData();
                formData.append('image', file);
                _this.$http.post(_this.apiEndpoints.upload_image, formData).then((result) => {
                    let url = result.body.url;

                    if(_this.form_data[_this.data_prop].length) {
                        Editor.insertEmbed(cursorLocation, 'image', url);
                    } else {
                        _this.$set(_this.form_data, _this.data_prop, `<img src="${url}" />`);
                    }
                });
            },
            imageGet($event) {
                let _this = this;
                if (_this._lodash.isEmpty($event['url'])) return false;

                let content = _this.form_data[_this.data_prop];
                let image = '<img src="' + $event['url'] + '" />';


                if(content.length) {
                    content = [
                        content.slice(0, _this.cursorPosition),
                        image,
                        content.slice(_this.cursorPosition)
                    ].join('');
                    _this.$set(_this.form_data, _this.data_prop, content);
                } else {
                    _this.$set(_this.form_data, _this.data_prop, image);
                }
            }
        }
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/forms/text.scss";
</style>