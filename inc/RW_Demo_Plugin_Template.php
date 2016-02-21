<?php
/**
 * Class RW_Demo_Plugin_Template
 *
 * loads altenative templates und includes a functions.php
 *
 * @package      RW Demo Plugin
 * @author       Demo Author
 * @license      GPL-2.0+
 * @link         https://github.com/rpi-virtuell/rw-demo-plugin
 * @since        0.0.2
 */
class RW_Demo_Plugin_Template {

	/**
	 * @use_action wp
	 */
	public static function init(){

		add_filter( 'template_include', array( 'RW_Demo_Plugin_Template','load_template_file'),99,1 );
		add_filter( 'template_redirect', array( 'RW_Demo_Plugin_Template','load_functions'));

	}



	/**
	 * loads a template file from the /templates dir
	 *
	 * @param $original_template
	 * @return file (e.g. /path/to/home/wp-content/themes/themename/single.php )
	 * @since 0.0.2
	 */
	public static function load_template_file( $original_template ) {

		//@TODO set post_type
		$post_type =  'customtype' ;

		if(is_singular() && get_post_type() == $post_type ) {

			$plugins_templatedir = RW_Demo_Plugin::$plugin_dir . 'templates/';
			$template_file = basename($original_template);

			if($template_file == 'archive.php'){
				$template_file == 'archive-'.$post_type.'.php';
			}elseif($template_file == 'single.php'){
				$template_file == 'single-'.$post_type.'.php';
			}

			if (file_exists($plugins_templatedir . $template_file)) {
				return $plugins_templatedir . $template_file;
			}
		}

		return $original_template;

	}


	/**
	 * loads a functions.php
	 *
	 * @param $original_template
	 * @return file (e.g. /path/to/home/wp-content/themes/themename/single.php )
	 * @since 0.0.2
	 */
	public static function load_functions(){
		include_once RW_Demo_Plugin::$plugin_dir . 'templates/functions.php';
	}
}