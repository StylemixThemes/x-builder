<template>
    <div class="x-colorpicker-wrapper">
        <h4>{{label}}</h4>
        <div class="x-colorpicker">

            <span class="colorpicker-clear" @click="clearColor()">
                <span class="xbuilder-close"></span>
            </span>

            <div class="colorpicker-toggle form-control" @click="$store.commit('colorPickerHide', {enabled : false, id: id})">
                <label>{{color}}</label>
                <span class="colorpicker-toggle-preview" :style="{background: color}"></span>
                <color-picker :color="color"
                              :sucker-hide="hideColorPicker[id]"
                              v-show="!hideColorPicker[id]"
                              @changeColor="changeColor"/>
            </div>

        </div>
    </div>
</template>

<script>

    import colorPicker from '@caohenghu/vue-colorpicker'
    import {mapGetters} from 'vuex'


    export default {
        name: 'colorpicker',
        props: ['source_color', 'label'],
        components: {
            colorPicker
        },
        data: function () {
            return {
                color: '',
                id : this.generateRandomId()
            }
        },
        created: function () {
            let _this = this;
            if (_this.source_color) _this.color = _this.source_color;

            /*Hide ColorPicker on start*/
            _this.$store.commit('colorPickerHide', {enabled : true, id: _this.id});


            document.body.addEventListener("click", function (evt) {
                let isParent = _this.hasClass(evt.target, 'colorpicker-toggle');
                if (!isParent) _this.$store.commit('colorPickerHide', {enabled : true, id: _this.id});
            });

        },
        methods: {
            changeColor(color) {
                const {rgba: {r, g, b, a}} = color;
                this.color = `rgba(${r}, ${g}, ${b}, ${a})`;
                this.$emit('color-changed', this.color);
            },
            clearColor() {
                this.$set(this, 'color', '');
                this.$emit('color-changed', this.color);
            },
            hasClass(element, className) {
                var regex = new RegExp('\\b' + className + '\\b');
                do {
                    if (regex.exec(element.className)) {
                        return true;
                    }
                    element = element.parentNode;
                } while (element);
                return false;
            },
            generateRandomId: function () {
                return parseFloat(Math.round(Math.random() * 100) / 100).toFixed(4) * 1000;
            },
        },
        computed : {
            ...mapGetters([
                'hideColorPicker',
                'colorPickerAttached',
            ]),
        },
        beforeDestroy() {
            this.hideColorPicker[this.id] = false;
        }
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/forms/colorpicker";
    @import "../../../node_modules/bootstrap/scss/functions";
    @import "../../../node_modules/bootstrap/scss/mixins";
    @import "../../../node_modules/bootstrap/scss/variables";
    @import "../../../node_modules/bootstrap/scss/input-group";
    @import "../../../node_modules/bootstrap/scss/forms";
    @import "../../assets/scss/forms/text.scss";
</style>