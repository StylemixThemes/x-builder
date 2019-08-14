<template>

    <div class="row-module">

        <div class="navigation">

            <a href="#"
               v-bind:class="{'active' : currentTab === 'settings'}"
               @click.prevent="currentTab = 'settings'">
                Settings
            </a>

            <a href="#"
               v-bind:class="{'active' : currentTab === 'design'}"
               @click.prevent="currentTab = 'design'">
                Design
            </a>

        </div>

        <div v-show="currentTab === 'settings'">

            <div class="form-group">
                <h4>Row Layout</h4>
                <select v-model="data['layout']" class="form-control">
                    <option v-bind:value="''">Boxed</option>
                    <option v-bind:value="'stretch'">Stretch to Section</option>
                </select>
            </div>

            <x_grid :data="data"
                    :data_prop="'grid'"
                    :label="'Grid Presets'">
            </x_grid>
        </div>

        <div v-show="currentTab === 'design'">

            <div class="design_tabs">
                <i class="lnr lnr-screen"
                   @click.prevent="designTab = 'screen'"
                   v-bind:class="{'active' : designTab === 'screen'}"></i>
                <i class="lnr lnr-laptop"
                   @click.prevent="designTab = 'laptop'"
                   v-bind:class="{'active' : designTab === 'laptop'}"></i>
                <i class="lnr lnr-tablet" style="transform: rotate(90deg)"
                   @click.prevent="designTab = 'tabletHor'"
                   v-bind:class="{'active' : designTab === 'tabletHor'}"></i>
                <i class="lnr lnr-tablet"
                   @click.prevent="designTab = 'tablet'"
                   v-bind:class="{'active' : designTab === 'tablet'}"></i>
                <i class="lnr lnr-smartphone"
                   @click.prevent="designTab = 'smartphone'"
                   v-bind:class="{'active' : designTab === 'smartphone'}"></i>
            </div>

            <design :saved_design="data['x_design']"
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

    </div>
</template>

<script>

    import {mixins} from "../../mixins";
    import {EventBus} from "../../event-bus";
    import x_checkbox from "./../forms/checkbox";
    import x_grid from "./../forms/grid_preset";
    import x_select from "./../forms/select";
    import design from "../helpers/design";

    export default {
        name: 'row',
        props: ['data', 'adds'],
        mixins: [mixins],
        components: {
            x_checkbox,
            x_grid,
            x_select,
            design,
        },
        data: function () {
            return {
                currentTab: 'settings',
                designTab: 'screen',
            }
        },
        methods: {
            designChanged($event, x_design) {
                this.$set(this.data, x_design, $event);
            }
        },
        watch: {
            data: {
                handler: function () {
                    let _this = this;
                    EventBus.$emit('RowSettingsChanged', _this.data, _this.adds);
                },
                deep: true
            }
        }
    }
</script>


<style scoped lang="scss">
    @import "../../../node_modules/bootstrap/scss/functions";
    @import "../../../node_modules/bootstrap/scss/mixins";
    @import "../../../node_modules/bootstrap/scss/variables";
    @import "../../../node_modules/bootstrap/scss/input-group";
    @import "../../../node_modules/bootstrap/scss/forms";
    //@import "../assets/scss/elements.scss";
</style>
