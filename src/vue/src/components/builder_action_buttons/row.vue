<template>
    <div class="x-row-actions-wrapper">
        <div class="x-row-actions">
            <div class="right_part">
                <a v-bind:href="'#'"
                   class="edit"
                   @click.prevent="editModule('row', row['params'], sectionIndex, rowIndex)">
                    <span class="xbuilder-edit"></span>
                    <div class="hint">Edit Row</div>
                </a>
                <a v-bind:href="'#'"
                   class="duplicate"
                   @click.prevent="duplicateRow(sections, sectionIndex, rowIndex, row)">
                    <span class="xbuilder-duplicate"></span>
                    <div class="hint">Duplicate Row</div>
                </a>
                <a v-bind:href="'#'"
                   class="delete"
                   @click.prevent="deleteRow(sections, sectionIndex, rowIndex)">
                    <span class="xbuilder-close"></span>
                    <div class="hint">Delete Row</div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import {mixins} from "../../mixins";
    import {rows} from "../../helpers/rows";

    export default {
        name: 'row_actions',
        props: ['sections', 'sectionIndex', 'rowIndex', 'row'],
        mixins: [mixins, rows],
    }
</script>


<style lang="scss">
    @import "../../assets/scss/actions.scss";
</style>
