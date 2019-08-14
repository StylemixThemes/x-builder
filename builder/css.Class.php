<?php

class STM_X_Builder_Css
{

    public static function add_module_styles($x_vars)
    {
        $x_vars['custom_css'] = '';

        if (isset($x_vars['params']) and isset($x_vars['params']['x_design'])) {
            $x_vars['custom_css'] .= self::module_x_design_styles($x_vars, 'x_design');
        }

        if (isset($x_vars['params']) and isset($x_vars['params']['x_design'])) {
            $x_vars['custom_css'] .= '@media only screen and (min-width: 1390px) {';
            $x_vars['custom_css'] .= self::module_x_design_styles_adaptive($x_vars, 'x_design');
            $x_vars['custom_css'] .= '}';
        }

        if (isset($x_vars['params']) and isset($x_vars['params']['x_design_md'])) {
            $x_vars['custom_css'] .= '@media only screen and (max-width: 1390px) {';
            $x_vars['custom_css'] .= self::module_x_design_styles($x_vars, 'x_design_md');
            $x_vars['custom_css'] .= '}';
        }

        if (isset($x_vars['params']) and isset($x_vars['params']['x_design_md_sm'])) {
            $x_vars['custom_css'] .= '@media only screen and (max-width: 1025px) and (min-width: 992px) {';
            $x_vars['custom_css'] .= self::module_x_design_styles($x_vars, 'x_design_md_sm');
            $x_vars['custom_css'] .= '}';
        }

        if (isset($x_vars['params']) and isset($x_vars['params']['x_design_sm'])) {
            $x_vars['custom_css'] .= '@media only screen and (max-width: 991px) {';
            $x_vars['custom_css'] .= self::module_x_design_styles($x_vars, 'x_design_sm');
            $x_vars['custom_css'] .= '}';
        }

        if (isset($x_vars['params']) and isset($x_vars['params']['x_design_xs'])) {
            $x_vars['custom_css'] .= '@media only screen and (max-width: 767px) {';
            $x_vars['custom_css'] .= self::module_x_design_styles($x_vars, 'x_design_xs');
            $x_vars['custom_css'] .= '}';
        }

        if (isset($x_vars['params']) and isset($x_vars['params']['x_typography'])) {
            $x_vars['custom_css'] .= self::module_x_typography_styles($x_vars);
        }

        if (isset($x_vars['params']) and isset($x_vars['params']['x_typography'])) {
            $x_vars['custom_css'] .= '@media only screen and (max-width: 1300px) {';
            $x_vars['custom_css'] .= self::module_x_adaptive_typography_styles($x_vars, 'laptop');
            $x_vars['custom_css'] .= '}';
        }

        if (isset($x_vars['params']) and isset($x_vars['params']['x_typography'])) {
            $x_vars['custom_css'] .= '@media only screen and (max-width: 1024px) {';
            $x_vars['custom_css'] .= self::module_x_adaptive_typography_styles($x_vars, 'tablet');
            $x_vars['custom_css'] .= '}';
        }

        if (isset($x_vars['params']) and isset($x_vars['params']['x_typography'])) {
            $x_vars['custom_css'] .= '@media only screen and (max-width: 767px) {';
            $x_vars['custom_css'] .= self::module_x_adaptive_typography_styles($x_vars);
            $x_vars['custom_css'] .= '}';
        }

        return $x_vars;
    }

    public static function module_x_design_styles_adaptive($x_vars, $x_design = 'x_design')
    {
        $module = (!empty($x_vars['module'])) ? $x_vars['module'] : 'x_module_x';
        $params = stm_x_builder_get_params($module, $x_vars['params']);
        $module_id = stm_x_builder_module_id($module, $params);
        $design = $params[$x_design];
        $css = '';


        /*Visibility*/
        if (!empty($design['visibility'])) {
            $css .= ($design['visibility'] == 'hidden') ? 'display: none;' : '';
        }

        if (!empty($css)) {
            $css = ".{$module_id} {{$css}}";
        }

        return $css;
    }

    public static function module_x_design_styles($x_vars, $x_design = 'x_design')
    {
        $module = (isset($x_vars['module'])) ? $x_vars['module'] : 'x_module_x';
        $params = stm_x_builder_get_params($module, $x_vars['params']);
        $module_id = stm_x_builder_module_id($module, $params);
        $design = $params[$x_design];
        $css = '';
        /*MARGINS*/
        if (isset($design['margins'])) $css .= self::spacings('margin', $design['margins']);

        /*PADDINGS*/
        if (isset($design['paddings'])) $css .= self::spacings('padding', $design['paddings']);

        /*Visibility*/
        if (!empty($design['visibility']) and $x_design !== 'x_design') {
            $css .= ($design['visibility'] == 'hidden') ? 'display: none;' : '';
        }

        /*BORDERS*/
        if (!empty($design['border'])) {
            $css .= 'border-width: 0;';
            if (!empty($design['border']['space'])) {
                $css .= self::spacings('border', $design['border']['space'], '-width');
            }
            if (!empty($design['border']['radius'])) {
                $css .= self::spacings('border', $design['border']['radius'], '-radius');
            }
            if (!empty($design['border']['style'])) {
                $css .= "border-style: {$design['border']['style']};";
            }
            if (!empty($design['border']['color'])) {
                $css .= "border-color: {$design['border']['color']};";
            }
        }

        /*BACKGROUND*/
        if (!empty($design['background'])) {
            if (!empty($design['background']['color'])) {
                $css .= "background-color: {$design['background']['color']};";
            }
            if (!empty($design['background']['image'])) {
                $image_url = stm_x_builder_get_image_src($design['background']['image']);
                $css .= "background-image: url('{$image_url}');";
            }
            if (!empty($design['background']['size'])) {
                $css .= "background-size: {$design['background']['size']};";
            }
            if (isset($design['background']['repeat']) && !empty($design['background']['repeat'])) {
                $css .= "background-repeat: {$design['background']['repeat']};";
            }
            if (isset($design['background']['position_x']) && !empty($design['background']['position_x'])) {
                $css .= "background-position-x: {$design['background']['position_x']};";
            }
            if (isset($design['background']['position_y']) && !empty($design['background']['position_y'])) {
                $css .= "background-position-y: {$design['background']['position_y']};";
            }
        }

        if (!empty($css)) {
            $css = ".{$module_id} {{$css}} ";
        }

        /*Box Shadow*/
        if (!empty($design['box-shadow'])) {

            $box_shadow = $design['box-shadow'];

            $css .= ".{$module_id} ";

            if(!empty($x_vars['box_shadow'])) {
                $css .= "{$x_vars['box_shadow']}";
            }

            $css .= " {";

            if(isset($box_shadow['x']) and isset($box_shadow['y']) and isset($box_shadow['radius']) and isset($box_shadow['color'])) {
                $css .= "box-shadow: {$box_shadow['x']}px {$box_shadow['y']}px {$box_shadow['radius']}px {$box_shadow['color']};";
            }

            $css .= "}";

        }

        return $css;

    }

    public static function spacings($property, $values, $affix = '')
    {
        $r = '';

        foreach ($values as $orientation => $orientation_value) {
            if (!isset($orientation_value) || $orientation_value == '') continue;
            $units = (is_numeric($orientation_value)) ? 'px' : '';

            $r .= "{$property}-{$orientation}{$affix}:{$orientation_value}{$units};";
        }

        return $r;
    }

    public static function module_x_typography_styles($x_vars)
    {
        $css = '';
        $module = $x_vars['module'];
        $params = stm_x_builder_get_params($module, $x_vars['params']);
        $module_id = stm_x_builder_module_id($module, $params);
        $typography = $params['x_typography'];

        $invalid_props = array(
            'line-height-size',
            'font-size-size',
            'word-spacing-size',
            'letter-spacing-size',
            'laptop-font-size-size',
            'laptop-line-height-size',
            'tablet-font-size-size',
            'tablet-line-height-size',
            'mobile-font-size-size',
            'mobile-line-height-size'
        );

        $default_params = STM_X_Api_Elements::getElement($module, false);
        $fields = !empty($default_params['params']['fields']) ? $default_params['params']['fields'] : array();

        if (empty($typography)) return '';

        foreach ($typography as $selector => $properties) {

            $additional_selectors = '';

            if (!empty($fields)) {
                $selectors = array_search($selector, array_column($fields, 'id'));
                if (!empty($selectors)) {
                    $selectors = $fields[$selectors]['typography'];
                    if (is_array($selectors)) $additional_selectors .= ".{$module_id} " . implode(",.{$module_id} ", $selectors);
                }
            }

            $main_selector = ".{$module_id} .{$selector}";
            $selectors = (!empty($additional_selectors)) ? "{$additional_selectors}, {$main_selector}" : $main_selector;

            $css .= "{$selectors} {";
            foreach ($properties as $property => $property_value) {

                /*Skip invalid css properties*/
                if (in_array($property, $invalid_props) or empty($property_value)) continue;

                $prefix = (isset($typography[$selector]["{$property}-size"])) ? $typography[$selector]["{$property}-size"] : '';
                $css .= "{$property}:{$property_value}{$prefix};";

            }
            $css .= "}";
        }

        return $css;
    }


    public static function module_x_adaptive_typography_styles($x_vars, $screen = "mobile")
    {
        $css = '';
        $module = $x_vars['module'];
        $params = stm_x_builder_get_params($module, $x_vars['params']);
        $module_id = stm_x_builder_module_id($module, $params);
        $typography = $params['x_typography'];

        if (empty($typography)) return '';

        $additional_selectors = '';


        foreach ($typography as $selector => $properties) {

            if (!empty($fields)) {
                $selectors = array_search($selector, array_column($fields, 'id'));
                if (!empty($selectors)) {
                    $selectors = $fields[$selectors]['typography'];
                    if (is_array($selectors)) $additional_selectors .= ".{$module_id} " . implode(",.{$module_id} ", $selectors);
                }
            }

            $main_selector = ".{$module_id} .{$selector}";
            $selectors = (!empty($additional_selectors)) ? "{$additional_selectors}, {$main_selector}" : $main_selector;


            $css .= "{$selectors} {";
            if (!empty($properties[$screen . '-font-size'])) {
                $css .= "font-size : {$properties[$screen . '-font-size']}px;";
            }
            if (!empty($properties[$screen . '-line-height'])) {
                $css .= "line-height : {$properties[$screen . '-line-height']}px;";
            }
            $css .= "}";
        }

        return $css;
    }


}