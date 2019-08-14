<template>
    <div class="x-typography">

        <h4 class="typo-settings">
            <span>{{label}} Typography</span>
        </h4>

        <div class="row">

            <div class="col">
                <label>Color</label>
                <colorpicker :source_color="typography['color']"
                             v-on:color-changed="getColor($event)"></colorpicker>
            </div>

        </div>

        <div class="row">

            <div class="col">
                <label>Text align</label>
                <select v-model="typography['text-align']" class="form-control">
                    <option v-bind:value="''">Default</option>
                    <option v-bind:value="'center'">Center</option>
                    <option v-bind:value="'left'">Left</option>
                    <option v-bind:value="'right'">Right</option>
                </select>
            </div>

            <div class="col">
                <label>Font Weight</label>
                <select v-model="typography['font-weight']" class="form-control">
                    <option v-bind:value="''">Default</option>
                    <option v-bind:value="200">Thin</option>
                    <option v-bind:value="300">Light</option>
                    <option v-bind:value="300">Regular</option>
                    <option v-bind:value="500">Medium</option>
                    <option v-bind:value="600">Semi-bold</option>
                    <option v-bind:value="700">Bold</option>
                    <option v-bind:value="900">Ultra Bold</option>
                </select>
            </div>

        </div>

        <div class="row">

            <div class="col">

                <label>Font size</label>
                <div class="input-group">
                    <input type="number" v-model="typography['font-size']" class="form-control"/>
                    <sizes :saved_size="typography['font-size-size']"
                           :key="generateRandomId()"
                           v-on:size-changed="typography['font-size-size'] = $event"></sizes>
                </div>

            </div>

            <div class="col">
                <label>Line height</label>
                <div class="input-group">
                    <input type="number" v-model="typography['line-height']" class="form-control"/>
                    <sizes :saved_size="typography['line-height-size']"
                           :key="generateRandomId()"
                           v-on:size-changed="typography['line-height-size'] = $event"></sizes>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col">
                <label>Word Spacing</label>
                <div class="input-group">
                    <input type="number" v-model="typography['word-spacing']" class="form-control"/>
                    <sizes :saved_size="typography['word-spacing-size']"
                           :key="generateRandomId()"
                           v-on:size-changed="typography['word-spacing-size'] = $event"></sizes>
                </div>
            </div>

            <div class="col">
                <label>Letter Spacing</label>
                <div class="input-group">
                    <input type="number" v-model="typography['letter-spacing']" class="form-control"/>
                    <sizes :saved_size="typography['letter-spacing-size']"
                           :key="generateRandomId()"
                           v-on:size-changed="typography['letter-spacing-size'] = $event"></sizes>
                </div>
            </div>

        </div>

        <h4>Laptop Settings</h4>

        <div class="row">

            <div class="col">

                <label>Font size</label>
                <div class="input-group">
                    <input type="number" v-model="typography['laptop-font-size']" class="form-control"/>
                    <sizes :saved_size="typography['laptop-font-size-size']"
                           :key="generateRandomId()"
                           v-on:size-changed="typography['laptop-font-size-size'] = $event"></sizes>
                </div>

            </div>

            <div class="col">
                <label>Line height</label>
                <div class="input-group">
                    <input type="number" v-model="typography['laptop-line-height']" class="form-control"/>
                    <sizes :saved_size="typography['laptop-line-height-size']"
                           :key="generateRandomId()"
                           v-on:size-changed="typography['laptop-line-height-size'] = $event"></sizes>
                </div>
            </div>

        </div>

        <h4>Tablet Settings</h4>

        <div class="row">

            <div class="col">

                <label>Font size</label>
                <div class="input-group">
                    <input type="number" v-model="typography['tablet-font-size']" class="form-control"/>
                    <sizes :saved_size="typography['tablet-font-size-size']"
                           :key="generateRandomId()"
                           v-on:size-changed="typography['tablet-font-size-size'] = $event"></sizes>
                </div>

            </div>

            <div class="col">
                <label>Line height</label>
                <div class="input-group">
                    <input type="number" v-model="typography['tablet-line-height']" class="form-control"/>
                    <sizes :saved_size="typography['tablet-line-height-size']"
                           :key="generateRandomId()"
                           v-on:size-changed="typography['tablet-line-height-size'] = $event"></sizes>
                </div>
            </div>

        </div>


        <h4>Mobile Settings</h4>

        <div class="row">

            <div class="col">

                <label>Font size</label>
                <div class="input-group">
                    <input type="number" v-model="typography['mobile-font-size']" class="form-control"/>
                    <sizes :saved_size="typography['mobile-font-size-size']"
                           :key="generateRandomId()"
                           v-on:size-changed="typography['mobile-font-size-size'] = $event"></sizes>
                </div>

            </div>

            <div class="col">
                <label>Line height</label>
                <div class="input-group">
                    <input type="number" v-model="typography['mobile-line-height']" class="form-control"/>
                    <sizes :saved_size="typography['mobile-line-height-size']"
                           :key="generateRandomId()"
                           v-on:size-changed="typography['mobile-line-height-size'] = $event"></sizes>
                </div>
            </div>

        </div>


    </div>
</template>

<script>

    import Sizes from "./sizes";

    export default {
        name: 'typography',
        props: ['saved_typo', 'label'],
        data: function () {
            return {
                typography: {
                    'font-size-size': 'px',
                    'line-height-size': 'px',
                    'word-spacing-size': 'px',
                    'letter-spacing-size': 'px',
                    'font-weight': '',
                    'color': '',
                    'text-align': '',
                    'laptop-font-size' : 'px',
                    'laptop-line-height' : 'px',
                    'tablet-font-size' : 'px',
                    'tablet-line-height' : 'px',
                    'mobile-font-size' : 'px',
                    'mobile-line-height' : 'px',
                }
            }
        },
        created: function () {
            if (this.saved_typo) this.$set(this, 'typography', this.saved_typo);
        },
        components: {
            Sizes,
            colorpicker: () => import('./../helpers/colorpicker')
        },
        methods: {
            getColor($event) {
                this.$set(this.typography, 'color', $event);
            },
            generateRandomId: function () {
                return parseFloat(Math.round(Math.random() * 100) / 100).toFixed(4) * 1000;
            },
        },
        watch: {
            typography: {
                handler: function () {
                    this.$emit('typo-changed', this.typography);
                },
                deep: true
            }
        }
    }
</script>


<style scoped lang="scss">
    @import "../../../node_modules/bootstrap/scss/functions";
    @import "../../../node_modules/bootstrap/scss/mixins";
    @import "../../../node_modules/bootstrap/scss/variables";
    @import "../../../node_modules/bootstrap/scss/input-group";
    @import "../../../node_modules/bootstrap/scss/forms";
    @import "../../assets/scss/forms/typography";
</style>