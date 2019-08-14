<template>
    <div class="row-module">

        <div v-if="typeof elementsStore[data['module_name']] !== 'undefined'">

            <div class="navigation">

                <a href="#"
                   v-bind:class="{'active' : currentTab === 'settings'}"
                   @click.prevent="currentTab = 'settings'">
                    Settings
                </a>

                <a href="#"
                   v-bind:class="{'active' : currentTab === 'typography'}"
                   @click.prevent="currentTab = 'typography'"
                   v-if="typographyData.length">
                    Typography
                </a>

                <a href="#"
                   v-bind:class="{'active' : currentTab === 'design'}"
                   @click.prevent="currentTab = 'design'">
                    Design
                </a>

                <a href="#"
                   v-bind:class="{'active' : currentTab === 'parallax'}"
                   @click.prevent="currentTab = 'parallax'">
                    Parallax
                </a>

            </div>


            <div v-for="formParams in elementsStore[data['module_name']]['params']['fields']"
                 v-show="currentTab === 'settings'">

                <component v-bind:is="'x_' + formParams['type']"
                           :key="formParams['id']"
                           :label="formParams['label']"
                           :data_prop="formParams['id']"
                           :adds="formParams['options']"
                           :data="data">
                </component>

            </div>


            <div v-show="currentTab === 'typography'"
                 v-for="typography in typographyData">
                <typography :saved_typo="data['x_typography'][typography.id]"
                            :label="typography['label']"
                            v-on:typo-changed="data['x_typography'][typography.id] = $event">
                </typography>
            </div>


            <div v-show="currentTab === 'design'">

                <div class="design_tabs">
                    <i class="xbuilder-lg"
                       @click.prevent="changeTab('screen')"
                       v-bind:class="{'active' : designTab === 'screen'}"></i>
                    <i class="xbuilder-md"
                       @click.prevent="changeTab('laptop')"
                       v-bind:class="{'active' : designTab === 'laptop'}"></i>
                    <i class="xbuilder-tablet_hor"
                       @click.prevent="changeTab('tabletHor')"
                       v-bind:class="{'active' : designTab === 'tabletHor'}"></i>
                    <i class="xbuilder-tablet_vert"
                       @click.prevent="changeTab('tablet')"
                       v-bind:class="{'active' : designTab === 'tablet'}"></i>
                    <i class="xbuilder-mobile"
                       @click.prevent="changeTab('smartphone')"
                       v-bind:class="{'active' : designTab === 'smartphone'}"></i>
                </div>

                <design v-bind:saved_design="data['x_design']"
                        v-show="designTab === 'screen'"
                        v-on:design-changed="designChanged($event, 'x_design')"
                        :data="data"></design>

                <design :saved_design="data['x_design_md']"
                        v-show="designTab === 'laptop'"
                        v-on:design-changed="designChanged($event, 'x_design_md')"
                        :data="data"></design>

                <design :saved_design="data['x_design_md_sm']"
                        v-show="designTab === 'tabletHor'"
                        v-on:design-changed="designChanged($event, 'x_design_md_sm')"
                        :data="data"></design>

                <design :saved_design="data['x_design_sm']"
                        v-show="designTab === 'tablet'"
                        v-on:design-changed="designChanged($event, 'x_design_sm')"
                        :data="data"></design>

                <design :saved_design="data['x_design_xs']"
                        v-show="designTab === 'smartphone'"
                        v-on:design-changed="designChanged($event, 'x_design_xs')"
                        :data="data"></design>

            </div>

            <div v-show="currentTab === 'parallax'">
                <div class="form-group">
                    <h4>Parallax Speed</h4>
                    <input class="form-control" type="number" v-model="data['parallax_speed']"/>
                </div>
            </div>


        </div>

    </div>
</template>

<script>
    import x_checkbox from "./../forms/checkbox";
    import x_grid from "./../forms/grid_preset";
    import x_text from "./../forms/text";
    import x_hidden from "./../forms/hidden";
    import x_number from "./../forms/number";
    import x_editor from "./../forms/editor";
    import x_image from "./../forms/image";
    import x_color from "./../forms/color";
    import x_select from "./../forms/select";
    import x_repeater from "./../forms/repeater";
    import x_date from "./../forms/date";
    import x_time from "./../forms/time";
    import x_iconpicker from "./../forms/iconpicker";
    import x_multiselect from "./../forms/multiselect";
    import x_gallery from "./../forms/gallery";
    import {mixins} from '../../mixins'
    import Typography from "../helpers/typography";
    import Design from "../helpers/design";
    import {mapGetters} from 'vuex'

    export default {
        name: 'element_x',
        props: ['data', 'module'],
        mixins: [mixins],
        data() {
            return {
                currentTab: 'settings',
                elementsData: {},
                elements: [],
                typographyData: [],
                designData: []
            }
        },
        components: {
            Design,
            Typography,
            x_checkbox,
            x_grid,
            x_text,
            x_hidden,
            x_number,
            x_editor,
            x_select,
            x_multiselect,
            x_image,
            x_color,
            x_repeater,
            x_iconpicker,
            x_date,
            x_time,
            x_gallery,
        },
        mounted: function () {
            let _this = this;
            if (_this._lodash.isEmpty(_this.data['x_typography'])) _this.$set(_this.data, 'x_typography', {});

            if (_this._lodash.isObject(_this.elementsStore[_this.data['module_name']])) {
                _this._lodash.forOwn(_this.elementsStore[_this.data['module_name']], function (params) {
                    if (_this._lodash.isObject(params)) {
                        _this._lodash.forOwn(params.fields, function (field) {
                            if (!_this._lodash.isEmpty(field.typography)) {
                                _this.typographyData.push(field);
                            }
                        })
                    }
                });
            }
        },
        methods: {
            changeTab(tab) {
                this.$store.commit('changeDesignTab', tab);
            },
            designChanged($event, x_design) {
                this.$set(this.data, x_design, $event);
            }
        },
        computed: {
            ...mapGetters([
                'designTab',
                'elementsStore'
            ]),
        },
    }
</script>


<style scoped lang="scss">
    @import "../../../node_modules/bootstrap/scss/functions";
    @import "../../../node_modules/bootstrap/scss/mixins";
    @import "../../../node_modules/bootstrap/scss/variables";
    @import "../../../node_modules/bootstrap/scss/input-group";
    @import "../../../node_modules/bootstrap/scss/forms";
    @import "../../assets/scss/forms/text.scss";
</style>
