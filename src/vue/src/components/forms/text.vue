<template>
    <div class="form-group">
        <h4>
            {{label}}
        </h4>
        <input type="text" v-model="form_data[data_prop]" class="form-control">

    </div>
</template>

<script>
    export default {
        name: 'x_text',
        props: ['data', 'data_prop', 'label'],
        data: function () {
            return {
                form_data: this.data,

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
    @import "../../assets/scss/forms/text.scss";
</style>