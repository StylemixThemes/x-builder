<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $time
 * @var $date
 * @var $custom_css
 */

$params = stm_x_builder_get_params($module, $params);
extract($params);
$classes = array();
$module_id = stm_x_builder_module_id($module, $params);
$classes[] = $module_id;

stm_x_builder_register_style($module, array(), $custom_css);
stm_x_builder_register_script('timer', array('vue.js'));
stm_x_builder_register_script($module, array('vue.js'));


if (!empty($date) and strtotime($date) > time()):
    $date = date('M j, Y ', strtotime($date));
    $date .= (!empty($time)) ? "{$time['H']}:{$time['mm']}:00" : "0:00:00";
    ?>

    <div class="x_countdown <?php echo esc_attr(implode(' ', $classes)); ?>"
         data-module="<?php echo esc_attr($module_id); ?>">
        <Timer :starttime="'<?php echo esc_attr($date); ?>'"
               :endtime="'<?php echo esc_attr($date); ?>'"
               trans='{"day":"Day","hours":"Hours","minutes":"Minutes","seconds":"Seconds"}'>
        </Timer>
    </div>
<?php endif;