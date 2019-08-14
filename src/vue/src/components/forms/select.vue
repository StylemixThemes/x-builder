<template>
    <div class="form-group">

        <h4>{{label}}</h4>
        <select class="form-control" v-model="form_data[data_prop]">
            <option v-bind:value="column" v-for="(width, column) in options">{{width}}</option>
        </select>
    </div>
</template>

<script>
    import {mixins} from "../../mixins"
    import {mapGetters} from 'vuex'

    export default {
        name: 'x_select',
        props: ['data', 'data_prop', 'label', 'list'],
        mixins: [mixins],
        data: function () {
            return {
                form_data: this.data,
                elementsData : {},
                options : this.list
            }
        },
        mounted: function() {
            this.setDefaultColumn();
            this.generateList();
        },
        methods: {
            setDefaultColumn: function() {
                if(typeof this.data[this.data_prop] === 'undefined') this.$set(this.data, this.data_prop, '');
            },
            generateList: function() {
                let _this = this;
                if(typeof _this.list !== 'undefined') return;
                let module_name = _this.form_data['module_name'];
                let module = _this.elementsStore[module_name];
                let fields = module.params.fields;
                fields.forEach(function(value){
                    if(value.id === _this.data_prop) {
                        _this.$set(_this, 'options', value.options);
                    }
                })
            }
        },
        computed: {
            ...mapGetters([
                'elementsStore'
            ]),
        },
    }
</script>


<style scoped lang="scss">
    @import "../../../node_modules/bootstrap/scss/functions";
    @import "../../../node_modules/bootstrap/scss/mixins";
    @import "../../../node_modules/bootstrap/scss/variables";
    @import "../../../node_modules/bootstrap/scss/input-group";
    @import "../../../node_modules/bootstrap/scss/forms";
    //@import "../assets/scss/elements.scss";
</style>
