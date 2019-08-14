<?php

class STM_X_Templates {

	public static function locate_x_template($template_name) {
		$template_name = "/x_builder/{$template_name}.php";
		$x_template =  apply_filters('x_template_file', STM_X_BUILDER_DIR . $template_name);

		return (locate_template($template_name)) ? get_template_directory() . $template_name : $x_template;
	}

	public static function load_x_template($template_name, $x_vars = array()) {
		$x_vars = STM_X_Builder_Css::add_module_styles($x_vars);
		ob_start();
		extract($x_vars);
		$template = self::locate_x_template($template_name);
		if(file_exists($template)) include($template);
		return ob_get_clean();
	}

    public static function load_x_template_legal($template_name, $x_vars = array()) {
        ob_start();
        extract($x_vars);
        $template = self::locate_x_template($template_name);
        if(file_exists($template)) include($template);
        return ob_get_clean();
    }

	public static function show_x_template($template_name, $x_vars = array()) {
		echo self::load_x_template($template_name, $x_vars);
	}

    public static function show_x_template_legal($template_name, $x_vars = array()) {
        echo self::load_x_template_legal($template_name, $x_vars);
    }

}