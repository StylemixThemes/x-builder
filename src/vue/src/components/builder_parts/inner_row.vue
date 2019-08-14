<template>
    <div class="element_content">
        <!--COLUMNS-->
        <!--<tree-view :data="item" :options="{maxDepth: 3}"></tree-view>-->
        <column :sectionIndex="sectionIndex"
                :rowIndex="rowIndex"
                :source="'inner_row'"
                :row="item">
        </column>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import {mixins} from '../../mixins'
    import {EventBus} from '../../event-bus'

    export default {
        name: 'inner_row',
        mixins: [mixins],
        components: {
            draggable,
            column: () => import('./column')
        },
        props: ['item', 'sectionIndex', 'rowIndex'],
        mounted: function () {
            this.fillInnerRow();
        },
        methods: {
            fillInnerRow() {
                let _this = this;
                if (!_this._lodash.isObject(_this.item['columns'])) {
                    _this.$set(_this.item, 'columns', [
                        {
                            elements: [],
                            params: {
                                id: this.generateRandomId(),
                                number: 0
                            }
                        }
                    ]);
                }
            }
        },
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/element.scss";
</style>
