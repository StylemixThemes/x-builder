<template>
    <div class="edit_module_wrapper">

        <a href="#" @click.prevent="editModule('elements')" class="elements-link">

            <span v-if="module === 'section_x'">
                Edit Section
            </span>

            <span v-else-if="module === 'row'">
                Edit Row
            </span>

            <span v-else-if="module === 'column'">
                Edit Column
            </span>

            <span v-else>
                {{moduleName}}
            </span>

            <i class="lnr lnr-arrow-left"></i>

        </a>

        <div class="edit_module">
            <component v-bind:is="module" v-bind:data="data" v-bind:adds="adds"></component>
        </div>

    </div>
</template>

<script>

    import {mixins} from './../../mixins';
    import section_x from './../modules/section';
    import row from './../modules/row';
    import column from './../modules/column';
    import element_x from './../modules/element';
    import X_element from "../builder_parts/element";

    export default {
        name: 'edit_module',
        data: function(){
            return {
                moduleName : this.editModuleName(this.data.module_name)
            }
        },
        props: ['module', 'data', 'adds'],
        mixins: [mixins],
        components: {
            X_element,
            section_x,
            row,
            column,
            element_x,
        },
        methods: {
            editModuleName(name) {
                return (typeof name !== 'undefined') ? name.replace(new RegExp('x_', 'g'), '_').replace(new RegExp('_', 'g'), ' ') : '';
            }
        },
        mounted: function() {
            if(typeof this.elementsStore[this.data.module_name] !== 'undefined') {
                this.moduleName = this.elementsStore[this.data.module_name].name;
            }
        }
    }
</script>


<style lang="scss">
    @import "../../assets/scss/edit_module.scss";
</style>
