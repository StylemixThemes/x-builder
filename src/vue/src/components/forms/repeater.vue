<template>
    <div class="form-group">
        <h4>
            {{label}}
        </h4>

        <div class="repeater" v-if="repeater">
            <div class="repeat" v-for="(repeat, repeat_index) in repeater">
                <div class="action">
                    <div class="pos">{{repeat}}</div>
                    <div class="delete" @click="deleteField(repeat_index)">Delete field</div>
                </div>
                <div class="row">
                    <div v-for="(field, index) in adds" v-bind:class="fieldClass(index)">
                        <component v-bind:is="'x_' + field.type"
                                   :data="form_data[data_prop][repeat_index]"
                                   :label="field.label"
                                   :key="form_data[data_prop][repeat_index].customID"
                                   :data_prop="field.id"></component>
                    </div>
                </div>
            </div>
        </div>

        <div class="addField" @click="addToEnd()">+</div>


    </div>
</template>

<script>

    import x_checkbox from "./../forms/checkbox";
    import x_grid from "./../forms/grid_preset";
    import x_text from "./../forms/text";
    import x_number from "./../forms/number";
    import x_editor from "./../forms/editor";
    import x_image from "./../forms/image";
    import x_hint_image from "./../forms/hint_image";
    import x_color from "./../forms/color";
    import x_select from "./../forms/select";
    import x_date from "./../forms/date";
    import x_multiselect from "./../forms/multiselect";
    import x_gallery from "./../forms/gallery";

    import {mixins} from './../../mixins';

    export default {
        name: 'x_repeater',
        props: ['data', 'data_prop', 'label', 'adds'],
        mixins: [mixins],
        data: function () {
            return {
                form_data: this.data,
                repeater: 0
            }
        },
        components: {
            x_checkbox,
            x_grid,
            x_text,
            x_number,
            x_editor,
            x_select,
            x_multiselect,
            x_image,
            x_hint_image,
            x_color,
            x_date,
            x_gallery,
        },
        created: function () {
            let _this = this;
            /*Create empty model*/
            /*repeater values*/
            if (typeof _this.form_data[_this.data_prop] === 'undefined') _this.$set(_this.form_data, _this.data_prop, []);
            let repeater_values = _this.form_data[_this.data_prop];
            if (!repeater_values.length) {
                _this.$set(repeater_values, 0, {
                    'customID' : _this.generateRandomId()
                });
                _this._lodash.forOwn(_this.adds, function (field_data, field_index) {
                    _this.$set(repeater_values[0], field_data.id, '');
                });
            }

            _this.repeater = repeater_values.length;
        },
        methods: {
            fieldClass(field) {
                return (field.column) ? `col-sm-${field.column}` : 'col-sm-12';
            },
            addToEnd() {
                let _this = this;
                _this.form_data[_this.data_prop].push({});
                _this._lodash.forOwn(_this.adds, function (field_data) {
                    _this.$set(_this.form_data[_this.data_prop][_this.repeater], field_data.id, '');
                });
                _this.$set(_this.form_data[_this.data_prop][_this.repeater], 'customID', _this.generateRandomId());
                _this.$set(_this, 'form_data', _this.form_data);
                _this.repeater = _this.form_data[_this.data_prop].length;
            },
            deleteField(field_index) {
                let _this = this;
                _this.form_data[_this.data_prop].splice(field_index, 1);
                _this.repeater = 0;
                _this.repeater = _this.form_data[_this.data_prop].length;
                _this.$set(_this.form_data, 'data_prop', _this.form_data[_this.data_prop]);
            }
        }
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/repeater.scss";
</style>