<template>
    <div class="form-group">

        <h4>
            {{label}}
        </h4>

        <vue-timepicker v-model="form_data[data_prop]" format="HH:mm" @change="changedTime"></vue-timepicker>

    </div>
</template>

<script>

    import VueTimepicker from 'vue2-timepicker'

    export default {
        name: 'x_time',
        props: ['data', 'data_prop', 'label'],
        data: function () {
            return {
                image_id : '',
                form_data: this.data,
            }
        },
        components: {
            VueTimepicker
        },
        methods: {
            changedTime: function(eventData) {
                let _this = this;
                _this.$set(_this.form_data, _this.data_prop, eventData.data);
            }
        }
    }
</script>


<style lang="scss">
    @import "../../../node_modules/vue2-timepicker/src/style/vue-timepicker.css";
</style>