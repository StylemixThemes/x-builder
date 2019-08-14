<template>
    <div class="x-design">

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <h4>Disable Block (will not produce any HTML Output)</h4>
                    <select v-model="design['hidden']" class="form-control">
                        <option v-bind:value="'show'">Enable</option>
                        <option v-bind:value="'hidden'">Disable</option>
                    </select>
                </div>
                <div class="form-group">
                    <h4>Visibility (will be hidden by CSS)</h4>
                    <select v-model="design['visibility']" class="form-control">
                        <option v-bind:value="'show'">Visible</option>
                        <option v-bind:value="'hidden'">Hidden</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="x-design-row">
            <h4>Background</h4>
            <div class="row">
                <div class="col">
                    <div class="row align-items-center">
                        <div class="col">
                            <colorpicker v-bind:source_color="design['background']['color']"
                                         v-bind:label="'Background Color'"
                                         v-on:color-changed="design['background']['color'] = $event">
                            </colorpicker>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">

                <h4>Image</h4>

                <media_library :stored_image="design['background']['image']"
                               :justAdd="'false'"
                               v-on:get-image="imageGet($event)">
                </media_library>

            </div>

            <div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <h4>Background size</h4>
                            <select v-model="design['background']['size']" class="form-control">
                                <option v-bind:value="'cover'">Cover</option>
                                <option v-bind:value="'contain'">Contain</option>
                                <option v-bind:value="'auto'">Auto</option>
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <h4>Background repeat</h4>
                            <select v-model="design['background']['repeat']" class="form-control">
                                <option v-bind:value="'no-repeat'">No repeat</option>
                                <option v-bind:value="'repeat'">Repeat</option>
                                <option v-bind:value="'repeat-x'">Repeat-x</option>
                                <option v-bind:value="'repeat-y'">Repeat-y</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <h4>Background position X</h4>
                            <input type="text" class="form-control" v-model="design['background']['position_x']"/>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <h4>Background position Y</h4>
                            <input type="text" class="form-control" v-model="design['background']['position_y']"/>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-xl-12  col-lg-12 ">

                <div class="x-design-row">
                    <h4>Margins</h4>
                    <div class="x-design-structure">
                        <div v-bind:class="'col' + value" v-for="(label, value) in orient">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{label}}</span>
                                </div>
                                <input type="text" class="form-control" v-model="design['margins'][value]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12  col-lg-12 ">
                <div class="x-design-row">
                    <h4>Paddings</h4>
                    <div class="x-design-structure">
                        <div v-bind:class="'col' + value" v-for="(label, value) in orient">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{label}}</span>
                                </div>
                                <input type="text" class="form-control" v-model="design['paddings'][value]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="x-design-row">

            <div class="row">
                <div class="col">
                    <h4>Border</h4>
                    <select v-model="design['border']['style']" class="form-control">
                        <option v-bind:value="''">Default</option>
                        <option v-bind:value="'dashed'">Dashed</option>
                        <option v-bind:value="'solid'">Solid</option>
                    </select>
                </div>
                <div class="col">
                    <div class="row align-items-center">
                        <div class="col">

                            <colorpicker v-bind:source_color="design['border']['color']"
                                         v-bind:label="'Border Color'"
                                         v-on:color-changed="design['border']['color'] = $event">
                            </colorpicker>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xl-12  col-lg-12 ">
                    <h5>Border Width (px)</h5>
                    <div class="x-design-structure">
                        <div v-bind:class="'col' + value" v-for="(label, value) in orient">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{label}}</span>
                                </div>
                                <input type="text" class="form-control" v-model="design['border']['space'][value]">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12  col-lg-12 ">
                    <h5>Border Radius (px)</h5>
                    <div class="x-design-structure-radius">
                        <div v-bind:class="'col' + value" v-for="(label, value) in radius">
                            <div class="input-group input-group-sm mb-3">

                                <input type="text" class="form-control" v-model="design['border']['radius'][value]">
                                <div class="input-group-prepend">

                            <span class="input-group-text"
                                  v-bind:style="design['border']['radius'][value] ? 'border-' + value + '-radius : ' + design['border']['radius'][value] + 'px' : ''">
                                  <!--v-bind:style='{borderRadius(value) : (design["border"]["radius"][value]) ? design["border"]["radius"][value] + "px" : 0}'>-->
                                {{label}}
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12  col-lg-12 ">
                    <h5>Box Shadow</h5>
                    <div class="form-group box-shadow">
                        <input type="number" placeholder="X" v-model="design['box-shadow']['x']" />
                        <input type="number" placeholder="Y" v-model="design['box-shadow']['y']" />
                        <input type="number" placeholder="Radius" v-model="design['box-shadow']['radius']" />
                        <colorpicker v-bind:source_color="design['box-shadow']['color']"
                                     v-bind:label="'Box Shadow Color'"
                                     v-on:color-changed="design['box-shadow']['color'] = $event">
                        </colorpicker>
                    </div>
                </div>

            </div>

        </div>


    </div>
</template>

<script>

    import Media_library from "./media_library";

    export default {
        name: 'design',
        components: {
            Media_library,
            colorpicker: () => import('./../helpers/colorpicker')
        },
        props: ['data', 'saved_design'],
        data: function () {
            return {
                orient: {
                    'top': '↑',
                    'right': '→',
                    'bottom': '↓',
                    'left': '←',
                },
                radius: {
                    'top-left': '↖',
                    'top-right': '↗',
                    'bottom-left': '↙',
                    'bottom-right': '↘',
                },
                design: {
                    "box-shadow": {
                        'x': '',
                        'y': '',
                        'radius': '',
                        'color': '',
                    },
                    hidden: 'show',
                    visibility: 'show',
                    margins: {
                        top: '',
                        right: '',
                        bottom: '',
                        left: '',
                    },
                    paddings: {
                        top: '',
                        right: '',
                        bottom: '',
                        left: '',
                    },
                    border: {
                        space: {
                            top: '',
                            right: '',
                            bottom: '',
                            left: '',
                        },
                        radius: {
                            'top-left': '',
                            'top-right': '',
                            'bottom-left': '',
                            'bottom-right': '',
                        },
                        style: '',
                        color: '',
                    },
                    background: {
                        color: '',
                        image: '',
                        size: 'cover',
                        repeat: 'no-repeat',
                        position_x: '',
                        position_y: '',
                    }
                }
            }
        },
        created: function () {
            if (this.saved_design) this.design = this._lodash.merge(this.design, this.saved_design);
        },
        methods: {
            imageGet($event) {
                this.design.background.image = $event.id;
            },
            borderRadius(value) {
                return "border-radius";
            }
        },
        watch: {
            design: {
                handler: function () {
                    this.$emit('design-changed', this.design);
                },
                deep: true
            }
        },
    }
</script>


<style scoped lang="scss">
    @import "../../../node_modules/bootstrap/scss/functions";
    @import "../../../node_modules/bootstrap/scss/mixins";
    @import "../../../node_modules/bootstrap/scss/variables";
    @import "../../../node_modules/bootstrap/scss/input-group";
    @import "../../../node_modules/bootstrap/scss/forms";
    @import "../../assets/scss/forms/design";
</style>