<template>
    <div class="form-group">

        <colorpicker :source_color="form_data[data_prop]"
                     :label="label"
                     v-on:color-changed="getColor($event)"></colorpicker>

    </div>
</template>

<script>
    import colorpicker from "../helpers/colorpicker"

    export default {
        name: 'x_color',
        props: ['data', 'data_prop', 'label'],
        components: {
            colorpicker
        },
        data: function () {
            return {
                form_data: this.data
            }
        },
        methods : {
            getColor($event) {
                this.form_data[this.data_prop] = $event;
            }
        }
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/forms/text.scss";
</style>