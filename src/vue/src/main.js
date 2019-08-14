// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import Toasted from 'vue-toasted';
import VueResource from 'vue-resource'
import store from './store'

Vue.use(VueResource);
Vue.use(Toasted);

/*Import lodash functions*/
import clone from 'lodash/clone';
import cloneDeep from 'lodash/cloneDeep';
import isString from 'lodash/isString';
import isNumber from 'lodash/isNumber';
import isObject from 'lodash/isObject';
import isEmpty from 'lodash/isEmpty';
import isBoolean from 'lodash/isBoolean';
import forOwn from 'lodash/forOwn';
import merge from 'lodash/merge';

Object.defineProperty(Vue.prototype, '_lodash',
    {
        value: {
            clone: clone,
            cloneDeep: cloneDeep,
            isString: isString,
            isNumber: isNumber,
            isEmpty: isEmpty,
            isObject: isObject,
            isBoolean: isBoolean,
            forOwn: forOwn,
            merge: merge,
        }
    }
);

/*Mixins*/
new Vue({
    el: '#x_builder',
    store,
    components: {App},
    template: '<App/>',
});