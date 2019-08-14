<?php
/**
 *
 * @var $params
 * @var $elements
 * @var $number
 *
 */
$module = 'column';
$params = stm_x_builder_get_params($module, $params);
extract($params);
$module_id = stm_x_builder_module_id('x_module_x', $params);

$inline_styles = (empty($custom_css)) ? '' : $custom_css;

stm_x_builder_register_style($module, array(), $inline_styles);

$number = (!empty($number)) ? $number : 0;

$columns = array();

/*Lg is number as default column width*/
if (!empty($xs)) $columns[] = "col-{$xs}";
if (!empty($sm)) $columns[] = "col-sm-{$sm}";
if (!empty($md)) $columns[] = "col-md-{$md}";
if (!empty($xlg)) $columns[] = "col-xl-{$xlg}";
if (!empty($number)) $columns[] = "col-lg-{$number}";

/*If md and sm columns empty, set them from lg source*/
if (empty($xs)) $columns[] = "col-xs-{$number}";
if (empty($sm)) $columns[] = "col-sm-{$number}";
if (empty($md)) $columns[] = "col-md-{$number}";

?>

<div class="col <?php echo esc_attr(implode(' ', $columns)); ?> <?php echo esc_attr($module_id); ?>">
    <div class="col-inner">

        <?php if (!empty($elements)): ?>

            <?php foreach ($elements as $element):

                if(!empty($element['params']['x_design']) &&
                    !empty($element['params']['x_design']['hidden']) &&
                    $element['params']['x_design']['hidden'] === 'hidden') continue;

                ?>


                <?php STM_X_Templates::show_x_template($element['module'], $element); ?>


            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</div>