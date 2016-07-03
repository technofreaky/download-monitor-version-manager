<?php 
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://google.com
 * @since             1.0
 * @package           Download Monitor Latest Version
 *
 * @wordpress-plugin
 * Plugin Name:       Download Monitor Latest Version
 * Plugin URI:        http://wordpress.org/plugins/download-monitor-version-manager/
 * Description:       A Plugin to manage your software version using Download Monitor.
 * Version:           1.0
 * Author:            Varun Sridharan
 * Author URI:        http://varunsridharan.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       download-monitor-version-manager
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) { die; }
 
define('DLM_VM_FILE',plugin_basename( __FILE__ ));
define('DLM_VM_PATH',plugin_dir_path( __FILE__ )); # Plugin DIR
define('DLM_VM_INC',DLM_VM_PATH.'includes/'); # Plugin INC Folder
define('DLM_VM_DEPEN','download-monitor/download-monitor.php');

register_activation_hook( __FILE__, 'dlm_vm_activate_plugin' );
register_deactivation_hook( __FILE__, 'dlm_vm_deactivate_plugin' );
register_deactivation_hook( DLM_VM_DEPEN, 'dlm_vm_dependency_deactivate' );



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function dlm_vm_activate_plugin() {
	require_once(DLM_VM_INC.'helpers/class-activator.php');
	Download_Monitor_Version_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function dlm_vm_deactivate_plugin() {
	require_once(DLM_VM_INC.'helpers/class-deactivator.php');
	Download_Monitor_Version_Manager_Deactivator::deactivate();
}


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function dlm_vm_dependency_deactivate() {
	require_once(DLM_VM_INC.'helpers/class-deactivator.php');
	Download_Monitor_Version_Manager_Deactivator::dependency_deactivate();
}



require_once(DLM_VM_INC.'functions.php');
require_once(plugin_dir_path(__FILE__).'bootstrap.php');
	
if(!function_exists('Download_Monitor_Version_Manager')){
    function Download_Monitor_Version_Manager(){
        return Download_Monitor_Version_Manager::get_instance();
    }
}
Download_Monitor_Version_Manager();