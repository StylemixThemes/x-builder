import {mixins} from './../mixins';
import {endpoints} from './../helpers/endpoints';
import {EventBus} from './../event-bus.js';

export const rows = {
    mixins: [mixins, endpoints],
    methods: {
        getRows() {

            let _this = this;
            _this.$http.get(_this.apiEndpoints.content).then(response => {
                let content = (_this._lodash.isEmpty(response.body))
                    ? [{
                        rows : [
                            {
                                columns : [],
                                params : {}
                            }
                        ],
                        params : {}
                    }]
                    : response.body;
                _this.$set(_this, 'sections', content);
                _this.fillRows(_this);
            });
        },
        saveRows(sections) {
            let _this = this;

            if(typeof sections === 'object') {
                _this.$set(_this, 'sections', sections);

                _this.showToast('Content Added');

                return false;
            }

            _this.showToast('Saving Content');
            
            _this.$http.post(_this.apiEndpoints.save_content, _this.sections).then((data) => {
                // Create the event
                let event = new CustomEvent("x_content_saved");
                document.dispatchEvent(event);
                _this.showToast('Content Saved');
            });
        },
        fillRows(_this) {
            if(_this._lodash.isEmpty(_this.sections)) return false;

            _this.sections.forEach((section) => {
                let sectionRows = section['rows'];
                if (typeof section['rows'] === 'undefined') _this.$set(section, 'rows', {});
                if (typeof section['params'] === 'undefined') _this.$set(section, 'params', {id: _this.generateRandomId()});
                sectionRows.forEach((value) => {
                    /*Set columns*/
                    let id = this.generateRandomId();
                    if (typeof value['columns'] === 'undefined') _this.$set(value, 'columns', []);
                    if (typeof value['params'] === 'undefined') _this.$set(value, 'params', {});
                    if (typeof value['params']['id'] === 'undefined') _this.$set(value['params'], 'id', id);


                    /*Add empty column*/
                    if (!value['columns'].length) _this.$set(value['columns'], 0, {});

                    /*Add content in columns*/
                    value['columns'].forEach((column) => {
                        if (typeof column['elements'] === 'undefined') {
                            _this.$set(column, 'elements', []);
                        }
                        if (typeof column['params'] === 'undefined') _this.$set(column, 'params', {number: 0});
                    });

                });
            });
        },
        onRowChanged() {
            EventBus.$on('RowSettingsChanged', (data, adds) => {
                let _this = this;
                let sectionIndex = adds[0];
                let rowIndex = adds[1];
                let colIndex = adds[2];
                let elementIndex = adds[3];
                let currentRow = _this.sections[sectionIndex]['rows'][rowIndex];
                let newColumn = {};


                /*Is Inner Row?*/
                if(_this._lodash.isNumber(colIndex) && _this._lodash.isNumber(elementIndex)) {
                    currentRow = currentRow['columns'][colIndex]['elements'][elementIndex];
                }

                let currentColumns = currentRow['columns'];
                let currentColumnsLength = currentColumns.length;
                let newGrid = data['grid'];

                /*Fill columns if less than new grid*/
                if (currentColumnsLength < newGrid) {
                    let i = currentColumnsLength;
                    while (i < newGrid) {
                        let newColumn = {
                            elements: [],
                            params: {
                                id: this.generateRandomId(),
                                number: 0
                            }
                        };
                        _this.$set(currentColumns, i, newColumn);
                        i++;
                    }
                    /**
                     * If we have more columns than new layout,
                     * we have to move elements in over columns to last column
                     * */
                } else {
                    let columnToAppend = newGrid - 1;
                    let orphanElements = [];
                    let deleteStartIndex = this._lodash.clone(newGrid);
                    while (newGrid < currentColumnsLength) {
                        if (this._lodash.isObject(currentColumns[newGrid]) &&
                            this._lodash.isObject(currentColumns[newGrid]['elements']) &&
                            currentColumns[newGrid]['elements'].length) {
                            orphanElements = orphanElements.concat(currentColumns[newGrid]['elements']);
                        }
                        newGrid++
                    }

                    currentColumns.splice(deleteStartIndex, currentColumnsLength - deleteStartIndex);

                    /*Move Orphan Elements to Host column (last in row)*/
                    if (orphanElements.length) {
                        let hostElements = currentColumns[columnToAppend]['elements'].concat(orphanElements);
                        _this.$set(currentColumns[columnToAppend], 'elements', hostElements);
                    }
                }
            });
        },
        duplicateRow(sections, sectionIndex, rowIndex, row) {
            sections[sectionIndex]['rows'].splice(rowIndex, 0, this._lodash.cloneDeep(row));
        },
        deleteRow(sections, sectionIndex, rowIndex) {
            let confirmed = this.confirmMessage('Do you really want to delete Row?');
            if (confirmed) sections[sectionIndex]['rows'].splice(rowIndex, 1);
            this.fillRows(this);
        },
    }
};