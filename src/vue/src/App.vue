<template>
    <div id="x_builder">
        <div class="container">

            <div class="row">
                <div class="col-8">
                    <builder></builder>
                </div>
                <div class="col-4" id="sidebar_wrapper">
                    <affix class="sidebar-menu"
                           relative-element-selector="#x_builder"
                           v-bind:style="'width: ' + sidebarWidth + 'px'"
                           :offset="{ top: 15, bottom: 30 }">
                        <control_panel></control_panel>

                        <button type="button"
                                class="btn-x-save"
                                @click.prevent="savingRows()">Save Content
                        </button>

                        <div class="save-menu">

                            <button @click.prevent="importPage()" target="_blank" type="button"
                                    class="button button-primary button-large">Import Page
                            </button>

                            <a v-bind:href="apiEndpoints.export_page" target="_blank" type="button"
                               class="button button-primary button-large">Export Page
                            </a>

                            <input @change="saveFile" type="file" ref="importFile" v-if="importOpened"/>

                        </div>

                    </affix>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import control_panel from './components/control_panel/control_panel.vue'
    import builder from './components/builder.vue'
    import {Affix} from 'vue-affix';
    import {endpoints} from './helpers/endpoints';
    import {rows} from './helpers/rows';
    import {EventBus} from "./event-bus";

    export default {
        name: 'App',
        components: {
            builder,
            control_panel,
            Affix
        },
        mixins: [endpoints, rows],
        data: function () {
            return {
                sidebarWidth: 300,
                importOpened: false,
            }
        },
        mounted: function () {
            this.setSidebarWidth();
        },
        methods: {
            setSidebarWidth() {
                let _this = this;
                _this.$nextTick().then(function () {
                    let width = document.getElementById('sidebar_wrapper').offsetWidth - 30;
                    _this.$set(_this, 'sidebarWidth', width);
                })
            },
            saveFile() {
                this.files = this.$refs.importFile.files
            },
            importPage() {
                let _this = this;


                /*Open First*/
                if(!_this.importOpened) {
                    _this.importOpened = true;
                    return false;
                }

                if(typeof _this.files === 'undefined') {
                    _this.importOpened = false;
                    return false;
                }

                let formData = new FormData();
                formData.append('image', _this.files[0]);
                _this.showToast('Importing Content');
                _this.$http.post(`${_this.apiEndpoints.import_page}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((data) => {
                    if (data.body.length) {

                        EventBus.$emit('SaveRows', data.body);

                    } else {
                        _this.showToast('Something went wrong');
                    }
                });
            },
            savingRows() {
                EventBus.$emit('SaveRows');
            }
        }
    }
</script>

<style lang="scss">
    @import "assets/scss/builder.scss";
    @import "assets/x_builder/style.css";
</style>