<template>
    <div class="control_panel">

        <elements v-if="module === 'elements' && !hideElements"></elements>
        <edit_module :key="data.id"
                     :module="module"
                     :data="data"
                     :adds="adds" v-else>
        </edit_module>
    </div>
</template>

<script>

    import edit_module from './edit_module.vue'
    import elements from './elements.vue'
    import {EventBus} from './../../event-bus';
    import {mapGetters} from 'vuex'

    export default {
        name: 'control_panel',
        data() {
            return {
                module: 'elements',
                data: [],
                adds: [],
            }
        },
        created: function () {
            let _this = this;
            EventBus.$on('EditModule', function (module, data, adds) {
                _this.module = module;
                _this.data = data;
                _this.adds = adds;
            });
        },
        components: {
            edit_module,
            elements,
        },
        beforeDestroy: function () {
            this.$destroy();
        },
        computed: {
            ...mapGetters([
                'hideElements'
            ]),
        },
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/control_panel.scss";
</style>
