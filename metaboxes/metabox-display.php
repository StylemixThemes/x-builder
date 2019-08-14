<?php

if ( ! defined( 'ABSPATH' ) ) exit; //Exit if accessed directly


/***
 * @var $post
 * @var $metabox
 * @var $args_id
 *
 */

$id = $metabox['id'];
$sections = $metabox['args'][$id];

$active = '';
$uniq = uniqid('stm_vue_'); ?>
    <script>
        var <?php echo esc_js($uniq) ?> = <?php echo str_replace('\'', '`', json_encode($sections)); ?>;
    </script>
<?php
$data_vue = (!empty($data_vue)) ? '' : "data-vue='" . $uniq . "'";

if (!empty($sections)): ?>
    <div class="stmt_metaboxes_grid" <?php echo stm_x_filtered_output($data_vue); ?>>
        <div class="stmt_metaboxes_grid__inner">

            <div class="container">

                <div class="stmt-to-tab-nav">
					<?php
					$i = 0;
					foreach ($sections as $section_name => $section):
						if($i == 0) $active = $section_name;
						?>
                        <div class="stmt-to-nav <?php if ($active == $section_name) echo 'active'; ?>"
                             data-section="<?php echo esc_attr($section_name); ?>"
                             @click="changeTab('<?php echo esc_attr($section_name); ?>')">
							<?php echo sanitize_text_field($section['name']); ?>
                        </div>
						<?php $i++; endforeach; ?>
                </div>

                <?php foreach ($sections as $section_name => $section): ?>
                    <div id="<?php echo esc_attr($section_name); ?>" class="stmt-to-tab <?php if($section_name == $active) echo 'active'; ?>">
                        <div class="container container-constructed">
                            <div class="row">
                                <div class="column">
                                    <?php foreach ($section['fields'] as $field_name => $field):
                                        if($field_name == 'wrapper_l_start' || $field_name == 'wrapper_r_start') :
                                    ?>
                                        <div class="wrapper column-50">
                                    <?php
                                        elseif($field_name != 'wrapper_l_start' && $field_name != 'wrapper_r_start' && $field_name != 'wrapper_l_end' && $field_name != 'wrapper_r_end') :
                                            $dependency = stmt_to_metaboxes_deps($field, $section_name);

                                            $width = (empty($field['columns'])) ? 'column-1' : "column-{$field['columns']}";

                                            ?>

                                            <transition name="slide-fade">
                                                <div class="<?php echo esc_attr($width); ?>" <?php echo sanitize_text_field($dependency); ?>>
                                                    <?php include STM_X_BUILDER_DIR . '/metaboxes/fields/' . $field['type'] . '.php'; ?>
                                                </div>
                                            </transition>
                                    <?php elseif($field_name == 'wrapper_l_end' || $field_name == 'wrapper_r_end') : echo '</div>'; ?>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>


        </div>
    </div>
<?php endif; ?>