import {mixins} from './../mixins';

export const shortcodes = {
    mixins: [mixins],
    methods: {
        generateShortcodes(data) {
            let _this = this;
            _this.short_codes = '';
            /*For testing*/
            _this.br = '';
            _this.sections.forEach(function (section, sectionIndex) {
                _this.short_codes += _this.getElementShortcode('x_section', section['params']);
                section['rows'].forEach(function (row, rowIndex) {
                    _this.short_codes += _this.getElementShortcode('x_row', row['params']);
                    row['columns'].forEach(function (column, columnIndex) {
                        _this.short_codes += _this.getElementShortcode('x_column', column['params']);
                        column['elements'].forEach(function (element, elementIndex) {
                            _this.short_codes += _this.getElementShortcode(element['module'], _this._lodash.cloneDeep(element['params']['fields']), true);
                            _this.short_codes += _this.br + '[/' + element['module'] + ']' + _this.br + '' + _this.br + '';
                        });
                        _this.short_codes += _this.br + '[/x_column]' + _this.br + '';
                    });
                    _this.short_codes += _this.br + '[/x_row]' + _this.br + '';
                });
                _this.short_codes += _this.br + '[/x_section]' + _this.br + '';
            });
        },
        getElementShortcode(element, params, elements) {
            let _this = this;
            elements = (_this._lodash.isBoolean(elements)) ? elements : false;
            if (elements) {
                let elementFields = {};
                params.forEach(function(field){
                    _this.$set(elementFields, [field.id], field[field['id']]);
                });

                params = elementFields;
            }

            //console.log(params, 'PARAMS');
            params = (this._lodash.isObject(params)) ? this.objToParams(params) : '';

            return '[' + element + params + ']';
        }
    }
};