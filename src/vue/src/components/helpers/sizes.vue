<template>
    <div class="input-group-append">

        <div class="input-group-text"
             v-for="(label, size_x) in sizes"
             @click="changeSize(size_x)"
             v-bind:class="{'active' : size_x === size}">
            {{label}}
        </div>
    </div>
</template>

<script>

    export default {
        name: 'sizes',
        props: ['saved_size'],
        data: function(){
            return {
                size : 'px',
                sizes : {
                    'px' : 'px',
                    '%' : '%',
                    'em' : 'em',
                }
            }
        },
        mounted: function() {
            if(this.saved_size) this.size = this.saved_size;
        },
        methods: {
            changeSize(value) {
                this.$set(this, 'size', value);
                this.$emit('size-changed', value);
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
    @import "../../assets/scss/forms/sizes";
</style>