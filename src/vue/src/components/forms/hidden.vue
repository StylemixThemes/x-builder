<template>
    <div class="form-group hidden">
        <input type="hidden" v-model="form_data[data_prop]" class="form-control">
    </div>
</template>

<script>
    export default {
        name: 'x_hidden',
        props: ['data', 'data_prop', 'label'],
        data: function () {
            return {
                form_data: this.data
            }
        }
    }
</script>