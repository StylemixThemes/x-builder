<template>
    <div class="elements">

        <span class="elements-link">Elements</span>

        <div class="navigation" style="margin-bottom: 30px;">
            <a href="#" v-for="group in groups"
               @click.prevent="activeGroup = group"
               v-bind:class="{'active' : activeGroup === group}">
                {{group}}
            </a>
        </div>


        <input type="text" class="form-control elements-search" v-model="search" placeholder="Search..."/>

        <!--Basic Elements-->
        <draggable :list="elements"
                   :options="{group:{ name: 'elements', pull:'clone', put:false}}"
                   class="draggable_wrapper row"
                   data-source="'basic'"
                   @end="onEnd">
            <div v-for="element in elements"
                 class="draggabble_inner element col-12"
                 :data-source="'basic'"
                 v-bind:class="filteredElementsList(element.name)"
                 v-if="element.type === 'Basic' && activeGroup === element.group">
                <div class="element-x">{{element.name}}</div>
            </div>
        </draggable>

        <!--Simple Elements-->
        <draggable :list="elements"
                   :options="{group:{ name: 'elements', pull:'clone', put:false}}"
                   class="draggable_wrapper row"
                   data-source="'elements'"
                   @end="onEnd">
            <div v-for="element in elements"
                 :data-source="'elements'"
                 class="draggabble_inner element col-6"
                 v-bind:class="filteredElementsList(element.name)"
                 v-if="element.type !== 'Basic' && activeGroup === element.group">
                <div class="element-x" v-bind:style="{'background-color' : element.element_color}">{{element.name}}</div>
            </div>
        </draggable>

    </div>
</template>

<script>

    import draggable from 'vuedraggable'
    import {mixins} from '../../mixins'
    import {EventBus} from '../../event-bus'

    export default {
        name: 'elements',
        mixins: [mixins],
        data() {
            return {
                search: '',
                elements: [],
                groups: [],
                activeGroup: 'Basic'
            }
        },
        methods: {
            filteredElementsList(element_class) {
                return (element_class.toLowerCase().includes(this.search.toLowerCase())) ? 'active' : 'inactive';
            },
            onEnd(e) {
                let source = e.from.dataset.source;
                let dataSet = e.to.children[e.newIndex].dataset;
                EventBus.$emit('NewModuleAdded', dataSet, source);
            },
            parseElements(elements) {
                let _this = this;
                let i = 0;

                _this._lodash.forOwn(elements, function (element) {

                    let elementData = {};
                    let elementGroup = (typeof element.group !== 'undefined') ? element.group : 'Basic';
                    let elementColor = (typeof element.element_color !== 'undefined') ? element.element_color : '#f78a8f';
                    if (!_this.groups.includes(elementGroup)) _this.groups.push(elementGroup);

                    _this.$set(elementData, 'module', element.module);
                    _this.$set(elementData, 'name', element.name);
                    _this.$set(elementData, 'type', element.type);
                    _this.$set(elementData, 'element_color', elementColor);
                    _this.$set(elementData, 'group', elementGroup);
                    _this.$set(elementData, 'params', {});
                    _this.$set(elementData.params, 'module_name', element.module);
                    element.params.fields.forEach((field) => {
                        _this.$set(elementData.params, field.id, field.value);
                    });
                    _this.$set(_this.elements, i, elementData);

                    i++;
                });

                _this.$set(_this, 'elements', _this.elements);
            },
        },
        created: function () {
            let _this = this;
            this.elementsFetched();
            EventBus.$on('Elements Fetched', function (elementsData) {
                _this.parseElements(elementsData);
            })
        },
        components: {
            draggable
        },
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/elements.scss";
    @import "../../../node_modules/bootstrap/scss/functions";
    @import "../../../node_modules/bootstrap/scss/mixins";
    @import "../../../node_modules/bootstrap/scss/variables";
    @import "../../../node_modules/bootstrap/scss/input-group";
    @import "../../../node_modules/bootstrap/scss/forms";
    @import "../../assets/scss/forms/text.scss";
</style>
