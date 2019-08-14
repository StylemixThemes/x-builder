<?php include STM_X_BUILDER_DIR . '/metaboxes/components_js/image.php'; ?>

<script type="text/javascript">
    <?php
    ob_start();
    include STM_X_BUILDER_DIR . '/metaboxes/components/hint_image.php';
    $template = preg_replace("/\r|\n/", "", addslashes(ob_get_clean()));
    ?>


    Vue.component('stmt-hintimage', {
        props: ['data'],
        data: function () {
            return {
                image_url: '',
                image_id: '',
                hints: [],
                currentX: '',
                currentY: '',
                currentHint: '',
            }
        },
        mounted: function () {
            var _this = this;
            var dataStored = (this.data !== '') ? JSON.parse(this.data) : '';

            if (dataStored.image_url) _this.$set(_this, 'image_url', dataStored.image_url);
            if (dataStored.image_id) _this.$set(_this, 'image_id', dataStored.image_id);
            if (dataStored.hints) _this.$set(_this, 'hints', dataStored.hints);

        },
        template: '<?php echo stm_x_filtered_output($template); ?>',
        methods: {
            startAddingHint(event) {
                var _this = this;
                Vue.nextTick(function () {
                    var $image = $(event.target);
                    if($image.context.nodeName !== 'IMG') return false;

                    var x = event.pageX - $image.offset().left - 23;
                    var y = event.pageY - $image.offset().top - 43;

                    var imageW = $image.width();
                    var imageH = $image.height();

                    x = Math.round((100 * x) / imageW * 100) / 100;
                    y = Math.round((100 * y) / imageH * 100) / 100;

                    if(x< 0) x = 0;
                    if(y < 0) y = 0;

                    if(x > 93) x = 93;
                    if(y > 86) y = 86;

                    _this.currentX = x + '%';
                    _this.currentY = y + '%';
                })
            },
            saveData() {
                var _this = this;
                var data = {
                    image_id: _this.image_id,
                    image_url: _this.image_url,
                    hints: _this.hints,
                };
                _this.$emit('get-data', JSON.stringify(data));
            },
            addHint() {
                var _this = this;
                if(!_this.currentHint) return false;
                var hintData = {
                    x : _this.currentX,
                    y : _this.currentY,
                    hint : this.currentHint
                };
                _this.hints.push(hintData);
                _this.currentY = _this.currentX = _this.currentHint = '';
            },
            deleteHint(hint_index) {
                this.hints.splice(hint_index, 1);
            }
        },
        watch: {
            image_id: function () {
                this.saveData();
            },
            image_url: function () {
                this.saveData();
            },
            hints: function () {
                this.saveData();
            }
        }
    });

    Vue.component('v-style', {
        render: function (createElement) {
            return createElement('style', this.$slots.default)
        }
    });

</script>