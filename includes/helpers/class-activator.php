<?php 
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link http://google.com
 * @package Download Monitor Latest Version
 * @subpackage Download Monitor Latest Version/core
 * @since 1.0
 */
class Download_Monitor_Version_Manager_Activator {
	
    public function __construct() {
    }
	
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		require_once(DLM_VM_INC.'helpers/class-version-check.php');
		require_once(DLM_VM_INC.'helpers/class-dependencies.php');
		
		if(Download_Monitor_Version_Manager_Dependencies(DLM_VM_DEPEN)){
			Download_Monitor_Version_Manager_Version_Check::activation_check('3.7');	
		} else {
			if ( is_plugin_active(DLM_VM_FILE) ) { deactivate_plugins(DLM_VM_FILE);} 
			wp_die(dlm_vm_dependency_message());
		}
	} 
 
}