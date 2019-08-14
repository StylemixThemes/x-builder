<template>
    <div class="element_content">

        <h4>{{item['name']}}</h4>

        <span class="element_content_field"
              v-for="(field, key) in item['show_params']"
              v-if="typeof item['show_params'] === 'object' && typeof item['params'][key] !== 'undefined'"
              v-html="field['pre'] + item['params'][key]">
        </span>

    </div>
</template>

<script>

    export default {
        name: 'x_element',
        props: ['item'],
        data: function() {
            return {
                key : this.field_key
            }
        }
    }
</script>


<style scoped lang="scss">
    @import "../../assets/scss/element.scss";
</style>
