<template>
    <div class="section-actions-wrapper">
        <div class="section-actions">
            <a v-bind:href="'#'"
               class="add"
               @click.prevent="addRowToSection(sections, section, sectionIndex)">
                <span class="xbuilder-add_plus"></span>
                <div class="hint">Add Row</div>
            </a>
            <div class="right_part">
                <a v-bind:href="'#'"
                   class="edit"
                   @click.prevent="editModule('section_x', section['params'])">
                    <span class="xbuilder-edit"></span>
                    <div class="hint">Edit Section</div>
                </a>
                <a v-bind:href="'#'"
                   class="duplicate"
                   @click.prevent="duplicateSection(sections, section, sectionIndex)">
                    <span class="xbuilder-duplicate"></span>
                    <div class="hint">Duplicate Section</div>
                </a>
                <a v-bind:href="'#'"
                   class="delete"
                   @click.prevent="deleteSection(sections, section, sectionIndex)">
                    <span class="xbuilder-close"></span>
                    <div class="hint">Delete Section</div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import {sections} from "../../helpers/sections";
    import {rows} from "../../helpers/rows";

    export default {
        name: 'section_actions',
        props: ['sections', 'section', 'sectionIndex'],
        mixins: [sections, rows],
    }
</script>


<style lang="scss">
    @import "../../assets/scss/actions.scss";
</style>
