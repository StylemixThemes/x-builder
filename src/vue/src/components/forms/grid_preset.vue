<template>
    <div class="grid_preset_wrapper">
        <h4>{{label}}</h4>
        <div class="grid_preset">
            <label v-for="column in grid" v-bind:class="{'active' : form_data[data_prop] === column}">
                <span class="grid_preset_column" v-bind:class="'grid_preset_column__' + column">
                    <span v-for="i in column"></span>
                </span>
                <input type="radio" v-model="form_data[data_prop]" v-bind:value="column"/>
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'x_grid_preset',
        props: ['data', 'data_prop', 'label'],
        data: function () {
            return {
                form_data: this.data,
                grid: []
            }
        },
        mounted: function () {
            this.generateGrid();
        },
        methods: {
            generateGrid: function () {
                if(typeof this.form_data['grid'] === 'undefined') this.$set(this.form_data, 'grid', 1);
                let i = 1;
                while (i < 7) {
                    this.grid.push(i);
                    i++;
                }
            }
        },
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/forms/grid_preset";
</style>