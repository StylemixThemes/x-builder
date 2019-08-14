<template>
    <div class="form-group form-group-hint-image">

        <h4>
            {{label}}
        </h4>

        <media_library :stored_image="form_data[data_prop].image_id" :justAdd="'false'"
                       v-on:get-image="imageGet($event)"></media_library>

        <div class="hint-holder-image"
             v-if="form_data[data_prop].image_url"
             @click="startAddingHint">
            <img v-bind:src="form_data[data_prop].image_url"/>

            <div class="hint-current-adding"
                 v-bind:style="{top: currentY, left: currentX}"
                 v-if="currentX !== '' && currentY !== ''">
                <div class="hint-current-adding__plus">+</div>
                <div class="hint-current-adding__form">
                    <input type="text"
                           v-model="currentHint"
                           placeholder="Hint text"/>
                    <span @click.enter="addHint()">Add</span>
                </div>
            </div>

            <div class="hint-on-image" v-for="(hint, hint_index) in hints" v-bind:style="{top: hint.y, left: hint.x}">
                <div class="hint-on-image__plus">+</div>
                <div class="hint-on-image__form">
                    <input type="text"
                           v-model="hint['hint']"
                           placeholder="Edit hint text"/>
                    <span @click.enter="deleteHint(hint_index)">Delete</span>
                </div>
            </div>

        </div>

    </div>
</template>

<script>

    import media_library from './../helpers/media_library'

    export default {
        name: 'x_hint_image',
        props: ['data', 'data_prop', 'label'],
        data: function () {
            return {
                form_data: this.data,
                hints: [],
                currentX: '',
                currentY: '',
                currentHint: '',
            }
        },
        components: {
            media_library
        },
        mounted: function () {
            let _this = this;
            let dataStored = (_this.form_data[_this.data_prop]) ? _this.form_data[_this.data_prop] : '';

            if (dataStored.image_id) _this.$set(_this, 'image', dataStored.image);
            if (dataStored.image_url) _this.$set(_this, 'image_url', dataStored.image_url);
            if (dataStored.hints) _this.$set(_this, 'hints', dataStored.hints);

        },
        watch: {
            hints: {
                handler: function () {
                    this.$set(this.form_data[this.data_prop], 'hints', this.hints);
                },
                deep: true
            }
        },
        methods: {
            imageGet($event) {
                let _this = this;
                _this.$set(_this.form_data, _this.data_prop, {});
                _this.$set(_this.form_data[_this.data_prop], 'image_id', $event.id);
                _this.$set(_this.form_data[_this.data_prop], 'image_url', $event.url);
            },
            startAddingHint(event) {
                let _this = this;

                if (event.target.nodeName !== 'IMG') return false;

                let x = event.offsetX - 24;
                let y = event.offsetY - 28;

                let imageW = event.target.clientWidth;
                let imageH = event.target.clientHeight;

                x = Math.round((100 * x) / imageW * 100) / 100;
                y = Math.round((100 * y) / imageH * 100) / 100;

                if (x < 0) x = 0;
                if (y < 0) y = 0;

                if (x > 93) x = 93;
                if (y > 86) y = 86;

                _this.currentX = x + '%';
                _this.currentY = y + '%';

                return false;
            },
            addHint() {
                let _this = this;
                if (!_this.currentHint) return false;
                let hintData = {
                    x: _this.currentX,
                    y: _this.currentY,
                    hint: this.currentHint
                };
                _this.hints.push(hintData);
                _this.currentY = _this.currentX = _this.currentHint = '';
            },
            deleteHint(hint_index) {
                this.hints.splice(hint_index, 1);
            }
        }
    }
</script>


<style lang="scss">
    @import "../../assets/scss/forms/hint_image.scss";
</style>