<template>
    <div class="element-actions-wrapper">
        <div class="element-actions">
            <div class="right_part">
                <a v-bind:href="'#'"
                   @click.prevent="editModule('row', items[itemIndex]['params'], sectionIndex, rowIndex, colIndex, itemIndex); setElementId(items[itemIndex]);">
                    <span class="xbuilder-edit"></span>
                </a>
                <a v-bind:href="'#'"
                   class="delete"
                   @click.prevent="deleteModule(items, itemIndex)">
                    <span class="xbuilder-close"></span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import {mixins} from "../../mixins";
    import {elements} from './../../helpers/elements';

    export default {
        name: 'inner_row_actions',
        props: ['cols', 'items', 'sectionIndex', 'rowIndex', 'colIndex', 'itemIndex'],
        mixins: [mixins, elements],
    }
</script>
