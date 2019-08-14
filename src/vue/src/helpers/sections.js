import {mixins} from './../mixins';
//import {EventBus} from './../event-bus.js';

export const sections = {
    mixins: [mixins],
    methods: {
        addRowToSection(sections, section, sectionIndex) {
            let _this = this;
            section.rows.push({});
            _this.fillRows(_this);
        },
        addSection(position) {
            let _this = this;
            let posIndex = 0;
            position = (typeof position === 'undefined') ? 'start' : position;
            if (position === 'start') {
                _this.sections.unshift({'rows': [{}]});
            } else {
                posIndex = _this.sections.push({'rows': [{}]}) - 1;
            }
            _this.fillRows(_this);
            _this.editModule('row', _this.sections[posIndex]['rows'][0]['params'], posIndex, 0);
        },
        duplicateSection(sections, section, sectionIndex) {
            sections.splice( sectionIndex, 0, this._lodash.cloneDeep(section));
        },
        deleteSection(sections, section, sectionIndex) {
            let confirmed = this.confirmMessage('Do you really want to delete Section?');
            if (confirmed) sections.splice(sectionIndex, 1);
        },
    }
};