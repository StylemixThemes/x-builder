<template>
    <div class="form-group">

        <h4>
            {{label}}
        </h4>

        <datepicker placeholder="Select Date" v-model="form_data[data_prop]" :format="'dd.MM.YYYY'" :inline="true" :input-class="'form-control'"></datepicker>

    </div>
</template>

<script>

    import Datepicker from 'vuejs-datepicker';

    export default {
        name: 'x_date',
        props: ['data', 'data_prop', 'label'],
        data: function () {
            return {
                image_id : '',
                form_data: this.data,
            }
        },
        components: {
            Datepicker
        },
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/forms/image.scss";
</style>