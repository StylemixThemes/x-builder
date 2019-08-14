<script type="text/javascript">
    <?php
    ob_start();
    include STM_X_BUILDER_DIR . '/metaboxes/components/iconpicker.php';
    $template = preg_replace("/\r|\n/", "", addslashes(ob_get_clean()));

    $icons = array();
    $linear_icons = get_template_directory() . '/assets/icons/linearicons/selection.json';
    if (file_exists($linear_icons)) {

        global $wp_filesystem;

        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        $icons['Linear'] = array();
        $linear_icons = json_decode($wp_filesystem->get_contents($linear_icons), true);

        foreach ($linear_icons['icons'] as $icon) {
            $icons['Linear'][] = "lnricons-{$icon['properties']['name']}";
        }
    }
    ?>


    Vue.component('stmt-iconpicker', {
        props: ['stored_icon'],
        data: function () {
            return {
                newIcon: '',
                sets : <?php echo json_encode($icons); ?>,
                openSets : false,
                searchQuery : ''
            }
        },
        mounted: function () {
            this.newIcon = this.stored_icon;
        },
        template: '<?php echo stm_x_filtered_output($template); ?>',
        methods: {
            filterItems: function(presets) {
                var app = this;
                return presets.filter(function(preset) {
                    let regex = new RegExp('(' + app.searchQuery + ')', 'i');
                    return preset.match(regex);
                })
            },
            addIcon(icon) {
                this.newIcon = icon;
                this.openSets = false;
            }
        },
        watch: {
            newIcon: function () {
                this.$emit('get-icon', this.newIcon);
            }
        }
    });

    Vue.component('v-style', {
        render: function (createElement) {
            return createElement('style', this.$slots.default)
        }
    });

</script>