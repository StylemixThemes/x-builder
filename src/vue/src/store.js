import Vue from 'vue'
import Vuex from 'vuex'
import {endpoints} from "./helpers/endpoints";

Vue.use(Vuex);

export default new Vuex.Store({
    mixins: [endpoints],
    state: {
        hideElements: false,
        elementsStore: {},
        sections: {},
        designTab: 'screen',
        addNewElement: false,
        hideColorPicker: {},
        colorPickerAttached: {},
        currentClick: {x: 0, y: 0},
        activeElement: '',
    },
    mutations: {
        reloadElements(state, active) {
            state.hideElements = active;
        },
        changeActiveElement(state, active) {
            state.activeElement = active;
        },
        saveElements(state, elements) {
            state.elementsStore = elements;
        },
        changeDesignTab(state, tab) {
            state.designTab = tab;
        },
        addingNewElement(state, $event) {
            state.addNewElement = true;

            let coords = xGetCoords(document.getElementById('x_builder'));

            let x = $event['pageX'] - coords.left - 185;
            let y = $event['pageY'] - coords.top - 25;
            if (x < 80) x = 80;

            state.currentClick['x'] = x;
            state.currentClick['y'] = y;
            document.body.addEventListener("click", function (evt) {
                let isParent1 = xHasClass(evt.target, 'add_new_element');
                let isParent2 = xHasClass(evt.target, 'x-mini-elements');

                if (!isParent1 && !isParent2 ) state.addNewElement = false;
            });
        },
        colorPickerAttach(state, data) {
            //this.$set(state.colorPickerAttached, data.id, data.attached);
        },
        colorPickerHide(state, data) {
            Vue.set(state.hideColorPicker, data.id, data.enabled);
        },
    },
    getters: {
        hideElements: state => state.hideElements,
        activeElement: state => state.activeElement,
        elementsStore: state => state.elementsStore,
        designTab: state => state.designTab,
        addNewElement: state => state.addNewElement,
        hideColorPicker: state => state.hideColorPicker,
        colorPickerAttached: state => state.colorPickerAttached,
        currentClick: state => state.currentClick,
    },
});

function xHasClass(element, className) {
    let regex = new RegExp('\\b' + className + '\\b');
    do {
        if (regex.exec(element.className)) {
            return true;
        }
        element = element.parentNode;
    } while (element);
    return false;
}

function xGetCoords(elem) { // crossbrowser version
    let box = elem.getBoundingClientRect();

    let body = document.body;
    let docEl = document.documentElement;

    let scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
    let scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;

    let clientTop = docEl.clientTop || body.clientTop || 0;
    let clientLeft = docEl.clientLeft || body.clientLeft || 0;

    let top = box.top + scrollTop - clientTop;
    let left = box.left + scrollLeft - clientLeft;

    return {top: Math.round(top), left: Math.round(left)};
}