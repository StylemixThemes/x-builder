<script type="text/javascript">
	<?php
	ob_start();
	include STM_X_BUILDER_DIR . '/metaboxes/components/faq.php';
	$template = preg_replace( "/\r|\n/", "", addslashes(ob_get_clean()));
	?>

    Vue.component('stmt-faq', {
        props: ['stored_faq'],
        data: function () {
            return {
                faq: [],
                add_new: '',
                isEmpty: false,
                timeout: ''
            }
        },
        mounted: function() {
            if(this.stored_faq) {
                this.faq = JSON.parse(this.stored_faq);
            }
        },
        template: '<?php echo stm_x_filtered_output($template); ?>',
        methods: {
            addNew: function() {
                var vm = this;


                clearTimeout(vm.timeout);
                vm.isEmpty = false;

                if(this.add_new) {
                    this.faq.unshift({
                        'question': this.add_new,
                        'answer': '',
                    });
                    this.add_new = '';
                } else {
                    vm.isEmpty = true;
                    vm.timeout = setTimeout(function(){
                        vm.isEmpty = false;
                    }, 400);
                }
            },
            deleteItem: function(key) {
                var r = confirm("Delete FAQ Item");
                if(r) this.faq.splice(key, 1);
            },
        },
        watch: {
            faq: {
                handler: function () {
                    this.$emit('get-faq', JSON.stringify(this.faq));
                },
                deep: true
            }
        }
    })
</script>