<template>
    <div class="column_content">


        <draggable :list="row.columns"
                   :options="{group:{ name: 'column', pull: pull}}"
                   class="draggable_wrapper row"
                   :disabled="true"
                   :data-row="rowIndex"
                   :data-source="sourceID"
                   @end="onEnd">

            <div v-for="(col, colIndex) in row.columns"
                 v-bind:class="colClasses('col-' + col['params']['number'], col)"
                 :data-source="'column'"
                 class="col draggabble_inner">

                <div class="col-x">
                    <column_actions :col="col"
                                    :colKey="row['params']['id'] + colIndex">
                    </column_actions>

                    <!--ELEMENTS-->
                    <column_content :sectionIndex="sectionIndex"
                                    :rowIndex="rowIndex"
                                    :colIndex="colIndex"
                                    :sourceID="sourceID"
                                    :items="col.elements"></column_content>

                </div>

            </div>

        </draggable>
    </div>
</template>

<script>
    import column_content from './../column_content'
    import column_actions from './../builder_action_buttons/column'
    import {rows} from '../../helpers/rows'
    import draggable from 'vuedraggable'
    import row_actions from './../builder_action_buttons/row'
    import {mapGetters} from 'vuex';

    export default {
        name: 'column',
        mixins: [rows],
        props: ['row', 'sectionIndex', 'rowIndex', 'source'],
        data: function() {
            return {
                sourceID : this.source
            }
        },
        components: {
            draggable,
            column_content,
            column_actions,
            row_actions
        },
        mounted : function () {
            this.sourceID = this._lodash.isEmpty(this.source) ? 'column' : this.source;
        },
        methods: {
            pull(to, from, dragElement) {
                return from.el.dataset.source === 'elements' || this.sourceID === 'column';
            },
            colClasses(column_static, col_info) {
                let classes = `${column_static} `;

                if(col_info.params.id == this.activeElement) {
                    classes += 'active';
                }

                return classes;
            }
        },
        computed : {
            ...mapGetters([
                'activeElement',
            ]),
        }
    }
</script>

<style scoped lang="scss">
    @import "../../assets/scss/column";
</style>