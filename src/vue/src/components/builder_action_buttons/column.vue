<template>
    <div class="col-actions-wrapper">
        <div class="col-actions">
            <div class="right_part">
                <a v-bind:href="'#'"
                   class="edit"
                   @click.prevent="editModule('column', col['params']);">
                    <span class="xbuilder-edit"></span>
                    <div class="hint">Edit Column</div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import {mixins} from "../../mixins";
    import {columns} from './../../helpers/columns';

    export default {
        name: 'column_actions',
        props: ['col', 'colKey'],
        mixins: [mixins, columns],
    }
</script>


<style lang="scss">
    @import "../../assets/scss/actions.scss";
</style>
