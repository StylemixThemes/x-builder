<div>
    <multiselect v-model="multiselect"
                 :options="options"
                 label="name"
                 :multiple="true"
                 track-by="name">
        <template slot="singleLabel"
                  slot-scope="{ option }">
            {{ option.name }}
        </template>
    </multiselect>
</div>