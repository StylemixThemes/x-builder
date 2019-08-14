<template>
    <div class="element-actions-wrapper">

        <div class="element-actions">
            <div class="right_part">

                <a v-bind:href="'#'"
                   class="edit"
                   @click.prevent="editModule('element_x', items[itemIndex]['params']); setElementId(items[itemIndex]); ">
                    <span class="xbuilder-edit"></span>
                    <div class="hint">Edit</div>
                </a>
                <a v-bind:href="'#'"
                   class="duplicate"
                   @click.prevent="duplicateModule(items, itemIndex)">
                    <span class="xbuilder-duplicate"></span>
                    <div class="hint">Duplicate</div>
                </a>
                <a v-bind:href="'#'"
                   class="delete"
                   @click.prevent="deleteModule(items, itemIndex)">
                    <span class="xbuilder-close"></span>
                    <div class="hint">Delete</div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import {mixins} from "../../mixins";
    import {elements} from './../../helpers/elements';

    export default {
        name: 'element_actions',
        props: ['cols', 'items', 'itemIndex'],
        mixins: [mixins, elements],
    }
</script>
