import {mixins} from './../mixins';

export const columns = {
    mixins: [mixins],
    methods: {
        setColumnId(column, id) {
            this.$set(column['params'], 'id', id);
        }
    }
};