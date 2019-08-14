<template>
    <div>

        <div class="x-builder">

            <x_mini_elements></x_mini_elements>

            <div class="addSection start" @click.prevent="addSection('start')">
                +
                <div class="hint">Add Section</div>
            </div>

            <!--SECTIONS-->
            <draggable :list="sections"
                       :options="{group:{ name: 'section'}}"
                       class="draggable_wrapper">

                <div class="section"
                     v-bind:class="{'active' : section.params.id == activeElement}"
                     v-for="(section, sectionIndex) in sections">

                    <section_actions :sections="sections"
                                     :section="section"
                                     :sectionIndex="sectionIndex">
                    </section_actions>

                    <!--ROWS-->
                    <draggable :list="section.rows"
                               :options="{group:{ name: 'row-x'}}"
                               class="draggable_wrapper">

                        <div v-for="(row, rowIndex) in section.rows"
                             v-bind:class="{'active' : row.params.id == activeElement}"
                             class="draggabble_inner row-x">

                            <row_actions :sections="sections"
                                         :sectionIndex="sectionIndex"
                                         :rowIndex="rowIndex"
                                         :row="row">
                            </row_actions>

                            <!--COLUMNS-->
                            <column :sectionIndex="sectionIndex"
                                    :rowIndex="rowIndex"
                                    :source="'column'"
                                    :row="row">
                            </column>

                        </div>

                    </draggable>

                </div>

            </draggable>

            <div class="addSection" v-on:click="addSection('end')">
                +
                <div class="hint">Add Section</div>
            </div>

        </div>

    </div>
</template>

<script>

    import draggable from 'vuedraggable'
    import column from './builder_parts/column'
    import section_actions from './builder_action_buttons/section'
    import row_actions from './builder_action_buttons/row'
    import {mixins} from './../mixins';
    import {sections} from './../helpers/sections';
    import {rows} from './../helpers/rows';
    import {elements} from './../helpers/elements';
    import {Affix} from 'vue-affix';
    import {mapGetters} from 'vuex';
    import x_mini_elements from './helpers/mini_elements';
    import {EventBus} from "./../event-bus";

    export default {
        name: 'builder',
        mixins: [mixins, sections, rows, elements],
        data() {
            return {
                sections: [],
                files: [],
            }
        },
        mounted: function () {
            this.getRows();
            this.onRowChanged();
            this.newModuleAdded();
            this.savingRows();
        },
        components: {
            draggable,
            section_actions,
            row_actions,
            column,
            Affix,
            x_mini_elements
        },
        methods: {
            changeTab(tab) {
                this.$store.commit('changeDesignTab', tab);
            },
            savingRows() {
                let _this = this;
                EventBus.$on('SaveRows', function(sections) {
                    _this.saveRows(sections);
                });
            }
        },
        watch: {
            sections: {
                handler: function () {
                    this.fillRows(this);
                    if(typeof x_builder_content !== 'undefined') x_builder_content = this.sections;
                },
                deep: true
            }
        },
        computed : {
            ...mapGetters([
                'activeElement',
                'designTab',
            ]),
        }
    }
</script>


<style scoped lang="scss">
    @import "../assets/scss/x-builder.scss";
</style>
