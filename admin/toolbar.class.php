<?php
/**
 * Class STM_X_Toolbar
 */

if (!class_exists('STM_X_Toolbar')) {

	class STM_X_Toolbar
	{
		function __construct()
		{
			//add_action('admin_bar_menu', 'STM_X_Toolbar::toolbar_link', 999);
		}

		public static function toolbar_link($wp_admin_bar)
		{
			global $post;
			$post_type = '';
			if (!empty($post->post_type)) $post_type = $post->post_type;
			if (in_array($post_type, array('page'))) {

				$editor_active = (STM_X_Builder::editor_active()) ? '0' : '1';
				$link_text = (STM_X_Builder::editor_active())
					? esc_html__('Edit with Default Builder', 'x-builder')
					: esc_html__('Edit with X Builder', 'x-builder');
				$link = add_query_arg('stmx_builder', $editor_active, get_edit_post_link($post->ID));
				$args = array(
					'id'    => 'stmx_page_editor',
					'title' => $link_text,
					'href'  => $link,
					'meta'  => array(
						'class'  => 'stmx_page_editor',
						'title'  => $link_text,
					)
				);
				$wp_admin_bar->add_node($args);
			}
		}

	}

	new STM_X_Toolbar();
}