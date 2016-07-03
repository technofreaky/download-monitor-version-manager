<?php
/**
 * Dependency Checker
 *
 * Checks if required Dependency plugin is enabled
 *
 * @link http://google.com
 * @package Download Monitor Latest Version
 * @subpackage Download Monitor Latest Version/FrontEnd
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

class Download_Monitor_Latest_Version_Functions {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
        add_action( 'wp_enqueue_scripts', array($this,'enqueue_styles') );
        add_action( 'wp_enqueue_scripts', array($this,'enqueue_scripts') );
    }
    
    
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() { 
		wp_enqueue_style(DLM_LV_NAME.'frontend_style', DLM_LV_CSS. 'frontend.css', array(), DLM_LV_V, 'all' );
	}
    
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() { 
		wp_enqueue_script(DLM_LV_NAME.'frontend_script', DLM_LV_JS.'frontend.js', array( 'jquery' ), DLM_LV_V, false );
	}

}