<?php
/**
 * Plugin's Admin code
 *
 * @link http://google.com
 * @package Download Monitor Latest Version
 * @subpackage Download Monitor Latest Version/Admin
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

class Download_Monitor_Version_Manager_Admin {

    /**
	 * Initialize the class and set its properties.
	 * @since      0.1
	 */
	public function __construct() {
        //add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ),99);
        //add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_init', array( $this, 'admin_init' ));

        add_filter( 'plugin_row_meta', array($this, 'plugin_row_links' ), 10, 2 );
        add_filter( 'plugin_action_links_'.DLM_VM_FILE, array($this,'plugin_action_links'),10,10);
	} 
    /**
     * Inits Admin Sttings
     */
    public function admin_init(){
        new Download_Monitor_Version_Manager_Admin_Handler;
    }
 
     
    
    /**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() { 
        wp_register_style(DLM_VM_SLUG.'_backend_style',DLM_VM_CSS.'backend.css' , array(), DLM_VM_V, 'all' );  
        wp_enqueue_style(DLM_VM_SLUG.'_backend_style');  
	}
	
    
    /**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {
        wp_register_script(DLM_VM_SLUG.'_backend_script', DLM_VM_JS.'backend.js', array('jquery'), DLM_VM_V, false ); 
        wp_enqueue_script(DLM_VM_SLUG.'_backend_script' ); 
	}
     
 
    /**
	 * Adds Some Plugin Options
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 * @since 0.11
	 * @return array
	 */
    public function plugin_action_links($action,$file,$plugin_meta,$status){
        $url = admin_url('edit.php?post_type=dlm_download&page=download-monitor-settings#settings-latestversion');
        $actions[] = sprintf('<a href="%s">%s</a>', $url, __('Settings',DLM_VM_TXT) );
        $actions[] = sprintf('<a href="%s">%s</a>', 'http://varunsridharan.in/plugin-support/', __('Contact Author',DLM_VM_TXT) );
        $action = array_merge($actions,$action);
        return $action;
    }
    
    /**
	 * Adds Some Plugin Options
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 * @since 0.11
	 * @return array
	 */
	public function plugin_row_links( $plugin_meta, $plugin_file ) {
		if ( DLM_VM_FILE == $plugin_file ) {
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', '#', __('F.A.Q',DLM_VM_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', '#', __('View On Github',DLM_VM_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', '#', __('Report Issue',DLM_VM_TXT) );
            $plugin_meta[] = sprintf('&hearts; <a href="%s">%s</a>', '#', __('Donate',DLM_VM_TXT) );
		}
		return $plugin_meta;
	}	    
}