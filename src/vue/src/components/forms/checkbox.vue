<template>
    <div class="form-group form-check">
        <label class="form-check-label">
            <input type="checkbox" v-model="form_data[data_prop]" class="form-check-input">
            {{label}}
        </label>
    </div>
</template>

<script>
    export default {
        name: 'x_checkbox',
        props: ['data', 'data_prop', 'label'],
        data: function () {
            return {
                form_data: this.data
            }
        }
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/forms/checkbox";
</style>
