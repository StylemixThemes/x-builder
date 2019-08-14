import {mixins} from './../mixins';
import {EventBus} from "../event-bus";
import {mapGetters} from 'vuex'

export const elements = {
    mixins: [mixins],
    methods: {
        duplicateModule(items, itemIndex) {
            items.splice( itemIndex, 0, this._lodash.cloneDeep(items[itemIndex]));
        },
        deleteModule(item, itemIndex) {
            let confirmed = this.confirmMessage('Do you really want to delete Element?');
            if (confirmed) item.splice(itemIndex, 1);
            this.editModule('elements');
        },
        setElementId(item) {
            let _this = this;
            if(!_this._lodash.isObject(item['params'])) _this.$set(item, 'params', {});
            _this.$set(item['params'], 'id', _this.generateRandomId());
            _this.$store.commit('changeActiveElement', item['params']['id']);
        },
        newModuleAdded() {
            let _this = this;
            EventBus.$on('NewModuleAdded', function(dataSet, source) {
                let sectionIndex = _this._lodash.clone(dataSet['sectionindex']);
                let rowIndex = _this._lodash.clone(dataSet['rowindex']);
                let colIndex = _this._lodash.clone(dataSet['colindex']);
                let elementIndex = _this._lodash.clone(dataSet['itemindex']);
                let item = _this.sections[sectionIndex]['rows'][rowIndex]['columns'][colIndex]['elements'][elementIndex];
                _this.setElementId(item);

                // source = (source === '\'elements\'') ? 'element_x' : 'row';
                // _this.editModule(source, item.params, sectionIndex, rowIndex, colIndex, elementIndex, false);

                /**
                 * TODO
                 * Make something with this unknown code
                 */
                _this.$store.commit('reloadElements', true);

                setTimeout(function(){
                    _this.$store.commit('reloadElements', false);
                }, 10);



            });
        },
        computed: {
            ...mapGetters([
                'activeElement',
                'elementsStore',
            ]),
        },
    }
};