import {EventBus} from './event-bus.js';
import {endpoints} from './helpers/endpoints';
import {mapGetters} from 'vuex'

export const mixins = {
    data: function () {
        return {
            elementsData: {},
        }
    },
    mixins: [endpoints],
    mounted: function () {
        let _this = this;
        _this.getElementsData();
    },
    beforeCreate: function () {
        //console.log(this.$options._componentTag);
    },
    methods: {
        onEnd() {
            this.fillRows(this);
        },
        editModule: function (module, data, ...adds) {
            /**
             *
             * 0 - Section index (number)
             * 1 - Row index (number)
             * 2 - Column index (number)
             * 3 - Element index (number)
             * 4 - Show field
             */

            data = (typeof data === 'undefined') ? {} : data;
            if(typeof data['id'] === 'undefined') data['id'] = this.generateRandomId();

            /*Add Element as active current*/
            this.$store.commit('changeActiveElement', data['id']);


            EventBus.$emit('EditModule', module, data, adds);
        },
        generateRandomId: function () {
            return parseFloat(Math.round(Math.random() * 100) / 100).toFixed(4) * 1000;
        },
        confirmMessage(message) {
            return confirm(message);
        },
        objToParams(data) {

            let props = Object
                .keys(data)
                .map(key => `${key}="${data[key]}"`)
                .join(" ");

            return ` ${props}`;
        },
        replaceAll(strData, search, replacement) {
            return strData.replace(new RegExp(search, 'g'), replacement);
        },
        checkIfComponentExists(contentComponent) {
            const keys = Object.keys(this.$options.components);
            const names = keys.map(key => {
                const component = this.$options.components[key];
                let name = '';
                if (component) {
                    name = component.name;
                }
                return name;
            });
            return names.includes(contentComponent);
        },
        elementsFetched() {
            let _this = this;

            if(typeof _this.elementsStore['inner_row'] === 'object') {

                /*Get From Store*/
                _this.$set(_this, 'elementsData', _this.elementsStore);
                _this.parseElements(_this.elementsStore);

            } else {
                _this.$http.get(_this.apiEndpoints.elements).then(response => {
                    
                    _this.$set(_this, 'elementsData', response.body);
                    EventBus.$emit('Elements Fetched', _this.elementsData);

                    // Save to Store
                    _this.$store.commit('saveElements', response.body);
                });
            }
        },
        getElementsData() {
            let elements = localStorage.getItem('elementsData');
            if (this._lodash.isString(elements)) this.$set(this, 'elementsData', JSON.parse(elements));
        },
        showToast(text) {
            this.$toasted.show(text, {
                position: "bottom-right",
                duration: 5000
            });
        }
    },
    computed: {
        ...mapGetters([
            'elementsStore',
        ]),
    },
};