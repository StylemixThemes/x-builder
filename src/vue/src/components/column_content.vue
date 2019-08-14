<template>
    <div class="x-column-content-holder">

        <draggable :list="items"
                   :options="{group:{ name: 'elements', put: put}}"
                   v-bind:data-source="sourceID"
                   class="draggable_wrapper">

            <div v-for="(item, itemIndex) in items"
                 class="draggabble_inner element"
                 :data-source="'elements'"
                 v-bind:class="{'active' : item.params.id === activeElement}"
                 v-bind:style="{'background-color' : item.element_color}"
                 v-bind:data-sectionIndex="sectionIndex"
                 v-bind:data-rowIndex="rowIndex"
                 v-bind:data-colIndex="colIndex"
                 v-bind:data-itemIndex="itemIndex">

                <inner_row_actions v-if="item.module === 'inner_row'"
                                   :sectionIndex="sectionIndex"
                                   :rowIndex="rowIndex"
                                   :colIndex="colIndex"
                                   :itemIndex="itemIndex"
                                   :items="items">
                </inner_row_actions>

                <element_actions v-else
                                 :items="items"
                                 :itemIndex="itemIndex">
                </element_actions>

                <inner_row v-if="item.module === 'inner_row'"
                           :sectionIndex="sectionIndex"
                           :rowIndex="rowIndex"
                           :colIndex="colIndex"
                           :key="generateRandomId()"
                           :item="item">
                </inner_row>

                <x_element v-else
                           :key="item['params']['id']"
                           :item="item">
                </x_element>

            </div>

        </draggable>

        <div class="add_new_element" @click="openMiniElements($event)">
            +
        </div>

    </div>
</template>

<script>

    import draggable from 'vuedraggable'
    import inner_row from './builder_parts/inner_row'
    import {mixins} from '../mixins'
    import {elements} from '../helpers/elements'
    import element_actions from './builder_action_buttons/element'
    import inner_row_actions from './builder_action_buttons/inner_row'
    import x_element from './builder_parts/element'
    import {EventBus} from '../event-bus'
    import x_elements from './control_panel/elements'
    import {mapGetters} from 'vuex'

    export default {
        name: 'column_content',
        props: ['items', 'sectionIndex', 'rowIndex', 'colIndex', 'sourceID'],
        mixins: [mixins, elements],
        data() {
            return {
                column_content: [],
                source: this.sourceID,
                elements: [],
                active_element : '',
            }
        },
        components: {
            inner_row_actions,
            draggable,
            element_actions,
            x_element,
            inner_row,
            x_elements,
        },
        created: function() {
            let _this = this;
            EventBus.$on('Elements Fetched', function (elementsData) {
                _this.$set(_this, 'elements', elementsData);
                _this.getElementsData();
                _this.updateItems();
            });

            EventBus.$on('NewModuleAdded', function () {
                _this.getElementsData();
                _this.updateItems();
            });


        },
        mounted: function () {
            this.source = this._lodash.isEmpty(this.sourceID) ? 'column' : this.sourceID;
        },
        methods: {
            updateItems() {
                let _this = this;
                this._lodash.forOwn(this.items, function (item) {
                    if(typeof _this.elements[item.module] !== 'undefined') {
                        let name = _this.elements[item.module].name;
                        let element_color = (typeof _this.elements[item.module]['element_color'] !== 'undefined') ? _this.elements[item.module]['element_color'] : '#f78a8f';
                        let show_params = (typeof _this.elements[item.module]['show_params'] !== 'undefined') ? _this.elements[item.module]['show_params'] : '[]';
                        let box_shadow = (typeof _this.elements[item.module]['box_shadow'] !== 'undefined') ? _this.elements[item.module]['box_shadow'] : '';

                        _this.$set(item, 'name', name);
                        _this.$set(item, 'element_color', element_color);
                        _this.$set(item, 'show_params', show_params);
                        _this.$set(item, 'box_shadow', box_shadow);

                    }
                });
                return this.items;
            },
            put(to, from, dragElement) {
                let _this = this;
                let sourceValue = dragElement.getAttribute('data-source');

                if (_this.source === 'column' && (sourceValue === 'elements' || sourceValue === 'basic')) {
                    return true;
                }

                return (_this.source === 'inner_row' && sourceValue === 'elements');
            },
            openMiniElements($event) {
                this.$store.commit('addingNewElement', $event);
            }
        },
        computed : {
            ...mapGetters([
                'activeElement',
                'addNewElement',
            ]),
        }
    }
</script>


<style scoped lang="scss">
    @import "../assets/scss/column_content.scss";
</style>
