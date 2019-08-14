<template>
    <div>
        <div class="x-mini-elements"
             v-bind:class="{'active' : addNewElement}"
             v-show="addNewElement"
             v-bind:style="{'top' : currentClick['y'] + 'px', 'left' : currentClick['x'] + 'px'}">
            <x_elements></x_elements>
        </div>
    </div>
</template>

<script>

    import x_elements from './../control_panel/elements'
    import {mapGetters} from 'vuex'

    export default {
        name: 'x_mini_elements',
        data: function () {
            return {}
        },
        components: {
            x_elements,
        },
        methods: {},
        computed: {
            ...mapGetters([
                'addNewElement',
                'currentClick',
            ]),
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