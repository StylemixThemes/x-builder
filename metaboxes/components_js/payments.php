<script type="text/javascript">
	<?php
	ob_start();
	include STM_X_BUILDER_DIR . '/metaboxes/components/payments.php';
	$template = preg_replace("/\r|\n/", "", addslashes(ob_get_clean()));
	?>
    Vue.component('stmt-payments', {
        props: ['saved_payments'],
        data: function () {
            return {
                payment_values : {},
                payments: {
                    cash: {
                        enabled: '',
                        name: "<?php esc_html_e('Offline payment', 'stmt_theme_options'); ?>",
                        fields: {
                            description: {
                                type: 'textarea',
                                placeholder: '<?php esc_html_e('Payment method description', 'stmt_theme_options'); ?>'
                            },
                        },
                    },
                    wire_transfer: {
                        enabled: '',
                        name: "<?php esc_html_e('Wire Transfer', 'stmt_theme_options'); ?>",
                        fields: {
                            account_number: {
                                type: 'text',
                                placeholder: '<?php esc_html_e('Account number', 'stmt_theme_options'); ?>'
                            },
                            holder_name: {
                                type: 'text',
                                placeholder: '<?php esc_html_e('Holder name', 'stmt_theme_options'); ?>'
                            },
                            bank_name: {
                                type: 'text',
                                placeholder: '<?php esc_html_e('Bank name', 'stmt_theme_options'); ?>'
                            },
                            swift: {
                                type: 'text',
                                placeholder: '<?php esc_html_e('Swift', 'stmt_theme_options'); ?>'
                            },
                            description: {
                                type: 'textarea',
                                placeholder: '<?php esc_html_e('Payment method description', 'stmt_theme_options'); ?>'
                            },
                        },
                    },
                    paypal: {
                        enabled: '',
                        name: "<?php esc_html_e('Paypal', 'stmt_theme_options'); ?>",
                        fields: {
                            paypal_email: {
                                type: 'text',
                                placeholder: '<?php esc_html_e('PayPal Email', 'stmt_theme_options'); ?>'
                            },
                            currency_code: {
                                type: 'select',
                                source: 'codes',
                                value : 'USD',
                                placeholder: '<?php esc_html_e('Currency code', 'stmt_theme_options'); ?>'
                            },
                            paypal_mode: {
                                type: 'select',
                                source: 'modes',
                                value : 'sandbox',
                                placeholder: '<?php esc_html_e('PayPal mode', 'stmt_theme_options'); ?>'
                            },
                            description: {
                                type: 'textarea',
                                placeholder: '<?php esc_html_e('Payment method description', 'stmt_theme_options'); ?>'
                            },
                        },
                    },
                    stripe: {
                        enabled: '',
                        name: "<?php esc_html_e('Stripe', 'stmt_theme_options'); ?>",
                        fields: {
                            stripe_public_api_key: {
                                type: 'text',
                                placeholder: '<?php esc_html_e('Publishable key', 'stmt_theme_options'); ?>'
                            },
                            secret_key: {
                                type: 'text',
                                placeholder: '<?php esc_html_e('Secret key', 'stmt_theme_options'); ?>'
                            },
                            description: {
                                type: 'textarea',
                                placeholder: '<?php esc_html_e('Payment method description', 'stmt_theme_options'); ?>'
                            },
                        },
                    },
                },
                sources: {
                    codes: {
                        '<?php esc_html_e('Select Currency code', 'stmt_theme_options'); ?>' : '',
                        '<?php esc_html_e('Australian dollar', 'stmt_theme_options'); ?>' : 'AUD',
                        '<?php esc_html_e('Brazilian real', 'stmt_theme_options'); ?>' : 'BRL',
                        '<?php esc_html_e('Canadian dollar', 'stmt_theme_options'); ?>' : 'CAD',
                        '<?php esc_html_e('Czech koruna', 'stmt_theme_options'); ?>' : 'CZK',
                        '<?php esc_html_e('Danish krone', 'stmt_theme_options'); ?>' : 'DKK',
                        '<?php esc_html_e('Euro', 'stmt_theme_options'); ?>' : 'EUR',
                        '<?php esc_html_e('Hong Kong dollar', 'stmt_theme_options'); ?>' : 'HKD',
                        '<?php esc_html_e('Hungarian forint 1', 'stmt_theme_options'); ?>' : 'HUF',
                        '<?php esc_html_e('Indian rupee', 'stmt_theme_options'); ?>' : 'INR',
                        '<?php esc_html_e('Israeli new shekel', 'stmt_theme_options'); ?>' : 'ILS',
                        '<?php esc_html_e('Japanese yen 1', 'stmt_theme_options'); ?>' : 'JPY',
                        '<?php esc_html_e('Malaysian ringgit 2	', 'stmt_theme_options'); ?>' : 'MYR',
                        '<?php esc_html_e('Mexican peso', 'stmt_theme_options'); ?>' : 'MXN',
                        '<?php esc_html_e('New Taiwan dollar 1', 'stmt_theme_options'); ?>' : 'TWD',
                        '<?php esc_html_e('New Zealand dollar', 'stmt_theme_options'); ?>' : 'NZD',
                        '<?php esc_html_e('Norwegian krone', 'stmt_theme_options'); ?>' : 'NOK',
                        '<?php esc_html_e('Philippine peso', 'stmt_theme_options'); ?>' : 'PHP',
                        '<?php esc_html_e('Polish złoty', 'stmt_theme_options'); ?>' : 'PLN',
                        '<?php esc_html_e('Pound sterling', 'stmt_theme_options'); ?>' : 'GBP',
                        '<?php esc_html_e('Russian ruble', 'stmt_theme_options'); ?>' : 'RUB',
                        '<?php esc_html_e('Singapore dollar', 'stmt_theme_options'); ?>' : 'SGD',
                        '<?php esc_html_e('Swedish krona', 'stmt_theme_options'); ?>' : 'SEK',
                        '<?php esc_html_e('Swiss franc', 'stmt_theme_options'); ?>' : 'CHF',
                        '<?php esc_html_e('Thai baht', 'stmt_theme_options'); ?>' : 'THB',
                        '<?php esc_html_e('United States dollar', 'stmt_theme_options'); ?>' : 'USD',
                    },
                    modes : {
                        '<?php esc_html_e('Sandbox', 'stmt_theme_options'); ?>' : 'sandbox',
                        '<?php esc_html_e('Live', 'stmt_theme_options'); ?>' : 'live',
                    }
                }
            }
        },
        template: '<?php echo stm_x_filtered_output($template); ?>',
        mounted: function () {
            if (this.saved_payments) this.setPaymentValues();
        },
        methods: {
            setPaymentValues() {
                var vm = this;
                for(var payment_method in vm.payments) {
                    if (!vm.payments.hasOwnProperty(payment_method) && !vm.saved_payments.hasOwnProperty(payment_method)) continue;
                    vm.payments[payment_method]['enabled'] = vm.saved_payments[payment_method]['enabled'];

                    for(var field_name in vm.payments[payment_method]['fields']) {
                        vm.$set(vm.payments[payment_method]['fields'][field_name], 'value', vm.saved_payments[payment_method]['fields'][field_name]);
                    }
                }
            },
            getPaymentValues() {
                var vm = this;
                for(var payment_method in vm.payments) {

                    if (!vm.payments.hasOwnProperty(payment_method)) continue;
                    vm.payment_values[payment_method] = {
                        'enabled' : vm.payments[payment_method]['enabled'],
                    };

                    if(typeof vm.payment_values[payment_method]['fields'] === 'undefined') vm.payment_values[payment_method]['fields'] = {};

                    for(var field_name in vm.payments[payment_method]['fields']) {
                        if (! vm.payments[payment_method]['fields'].hasOwnProperty(field_name)) continue;
                        var value = (typeof vm.payments[payment_method]['fields'][field_name]['value'] === 'undefined') ? '' : vm.payments[payment_method]['fields'][field_name]['value'];

                        vm.payment_values[payment_method]['fields'][field_name] = value;

                    }
                }

                this.$emit('update-payments', vm.payment_values);
            }
        },
        watch: {
            payments: {
                handler: function () {
                    this.getPaymentValues();
                },
                deep: true
            },
        }
    })
</script>