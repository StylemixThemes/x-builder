(function ($) {
    $(document).ready(function () {

        $('[data-vue]').each(function () {

            let $this = $(this);
            let data = window[$this.attr('data-vue')];

            new Vue({
                el: $(this)[0],
                data: function () {
                    return {
                        loading: false,
                        data: data,
                        customToolbar: [
                            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                            ["bold", "italic", "underline"],
                            [{list: "ordered"}, {list: "bullet"}],
                            ["image", "code-block"],
                            [{ 'color': [
                                    '#e60000',
                                    '#ff9900',
                                    '#ffff00',
                                    '#008a00',
                                    '#0066cc',
                                    '#9933ff',
                                    '#ae56c2',
                                    '#ffffff',
                                    '#facccc',
                                    '#ffebcc',
                                    '#ffffcc',
                                    '#cce8cc',
                                    '#cce0f5',
                                    '#ebd6ff',
                                    '#bbbbbb',
                                    '#f06666',
                                    '#ffc266',
                                    '#ffff66',
                                    '#66b966',
                                    '#66a3e0',
                                    '#c285ff',
                                    '#888888',
                                    '#a10000',
                                    '#b26b00',
                                    '#b2b200',
                                    '#006100',
                                    '#0047b2',
                                    '#6b24b2',
                                    '#444444',
                                    '#5c0000',
                                    '#663d00',
                                    '#666600',
                                    '#003700',
                                    '#002966',
                                    '#3d1466',
                                    '#2e1212',
                                    '#2659cf',
                                    '#022248',
                                    '#1241cd',
                                    '#fde3ee',
                                    '#222832',
                                    '#FFC400',
                                    '#2a2c32',
                                    '#6e62e2',
                                    '#24c37d'
                                ] }, { 'background': [] }],
                            [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }]
                        ]
                    }
                },
                mounted: function() {
                },
                methods: {
                    changeTab: function(tab) {
                        let $tab = $('#' + tab);
                        console.log($tab);
                        $tab.closest('.stmt_metaboxes_grid__inner').find('.stmt-to-tab').removeClass('active');
                        $tab.addClass('active');

                        let $section = $('div[data-section="' + tab + '"]');
                        $tab.closest('.stmt_metaboxes_grid__inner').find('.stmt-to-nav').removeClass('active');
                        $section.addClass('active');

                    },
                    saveSettings: function(id) {
                        var vm = this;
                        vm.loading = true;
                        this.$http.post(stmt_to_ajaxurl + '?action=stmt_save_settings&name=' + id, JSON.stringify(vm.data)).then(function(response){
                            vm.loading = false;
                        });
                    }
                }
            });

        });
    });
})(jQuery);