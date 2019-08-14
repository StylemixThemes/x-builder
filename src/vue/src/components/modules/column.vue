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

            <!--Large-->
            <x_select :list="columnsNum" :data="data" :data_prop="'number'" :label="'Column default width'"></x_select>

            <x_select :list="columnsNum" :data="data" :data_prop="'xlg'"
                      :label="'Extra Large Screen Width > 1200px'"></x_select>

            <x_select :list="columnsNum" :data="data" :data_prop="'md'" :label="'Medium screen / tablet'"></x_select>

            <x_select :list="columnsNum" :data="data" :data_prop="'sm'" :label="'Small screen / phone'"></x_select>

            <x_select :list="columnsNum" :data="data" :data_prop="'xs'"
                      :label="'Extra small screen / phone'"></x_select>
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
    import x_select from "./../forms/select";
    import x_text from "./../forms/text";
    import design from "../helpers/design";

    export default {
        name: 'column',
        props: ['data'],
        mixins: [mixins],
        components: {
            x_text,
            x_select,
            design,
        },
        data: function () {
            return {
                columnsNum: {},
                currentTab: 'settings',
                designTab: 'screen',
            }
        },
        mounted: function () {
            this.fillColumns();
        },
        methods: {
            fillColumns: function () {
                let i = 1;
                this.$set(this.columnsNum, 0, 'Fill Row');
                while (i < 13) {
                    let width = 100 * i / 12;
                    this.$set(this.columnsNum, i, Math.round(width) + '% (' + i + '/12)');
                    i++;
                }
            },
            designChanged($event, x_design) {
                this.$set(this.data, x_design, $event);
            }
        }
    }
</script>


<style scoped lang="scss">
    //@import "../assets/scss/elements.scss";
</style>