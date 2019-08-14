<template>
  <div class="form-group">
    <h4>{{label}}</h4>

    <multiselect v-model="form_data[data_prop]" label="name" :options="options" track-by="term_id" :multiple="true"
                 :taggable="true"></multiselect>
  </div>
</template>

<script>
  import {mixins} from "../../mixins"
  import Multiselect from 'vue-multiselect'

  export default {
    name: 'x_multiselect',
    props: ['data', 'data_prop', 'label', 'list', 'adds'],
    components: {Multiselect},
    mixins: [mixins],
    data: function () {
      return {
        form_data: this.data,
        options: this.adds
      }
    },
    mounted: function () {
    },
    methods: {}
  }
</script>

<style lang="scss">
  @import "../../assets/scss/forms/multiselect";
</style>
