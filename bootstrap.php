<?php 
/**
 * Plugin Main File
 *
 * @link http://google.com
 * @package Download Monitor Latest Version
 * @subpackage Download Monitor Latest Version/core
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }
 
class Download_Monitor_Latest_Version {
	public $version = '1.0';
	public $plugin_vars = array();
	
	protected static $_instance = null; # Required Plugin Class Instance
    protected static $functions = null; # Required Plugin Class Instance
	protected static $admin = null;     # Required Plugin Class Instance
	protected static $settings = null;  # Required Plugin Class Instance

    /**
     * Creates or returns an instance of this class.
     */
    public static function get_instance() {
        if ( null == self::$_instance ) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    
    /**
     * Class Constructor
     */
    public function __construct() {
        $this->define_constant();
        $this->load_required_files();
        $this->init_class();
        add_action('plugins_loaded', array( $this, 'after_plugins_loaded' ));
        add_filter('load_textdomain_mofile',  array( $this, 'load_plugin_mo_files' ), 10, 2);
    }
	
	/**
	 * Throw error on object clone.
	 *
	 * Cloning instances of the class is forbidden.
	 *
	 * @since 1.0
	 * @return void
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cloning instances of the class is forbidden.', DLM_LV_TXT), DLM_LV_V );
	}	

	/**
	 * Disable unserializing of the class
	 *
	 * Unserializing instances of the class is forbidden.
	 *
	 * @since 1.0
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of the class is forbidden.',DLM_LV_TXT), DLM_LV_V);
	}

    /**
     * Loads Required Plugins For Plugin
     */
    private function load_required_files(){
       $this->load_files(DLM_LV_INC.'class-*.php');

       if(dlm_lv_is_request('admin')){
           $this->load_files(DLM_LV_ADMIN.'class-*.php');
       } 

    }
    
    /**
     * Inits loaded Class
     */
    private function init_class(){ 
        self::$functions = new Download_Monitor_Latest_Version_Functions;
        new Download_Monitor_Latest_Version_Shortcode_Handler;
        if(dlm_lv_is_request('admin')){
            self::$admin = new Download_Monitor_Latest_Version_Admin;
        } 
    }
    
    
	# Returns Plugin's Functions Instance
	public function func(){
		return self::$functions;
	}
	
	# Returns Plugin's Settings Instance
	public function settings(){
		return self::$settings;
	}
	
	# Returns Plugin's Admin Instance
	public function admin(){
		return self::$admin;
	}
    
    /**
     * Loads Files Based On Give Path & regex
     */
    protected function load_files($path,$type = 'require'){
        foreach( glob( $path ) as $files ){
            if($type == 'require'){ require_once( $files ); } 
			else if($type == 'include'){ include_once( $files ); }
        } 
    }
    
    /**
     * Set Plugin Text Domain
     */
    public function after_plugins_loaded(){
        load_plugin_textdomain(DLM_LV_TXT, false, DLM_LV_LANGUAGE_PATH );
    }
    
    /**
     * load translated mo file based on wp settings
     */
    public function load_plugin_mo_files($mofile, $domain) {
        if (DLM_LV_TXT === $domain)
            return DLM_LV_LANGUAGE_PATH.'/'.get_locale().'.mo';

        return $mofile;
    }
    
    /**
     * Define Required Constant
     */
    private function define_constant(){
        $this->define('DLM_LV_NAME', 'Download Monitor Latest Version'); # Plugin Name
        $this->define('DLM_LV_SLUG', 'download-monitor-latest-version'); # Plugin Slug
        $this->define('DLM_LV_TXT',  'download-monitor-latest-version'); #plugin lang Domain
		$this->define('DLM_LV_DB', 'dlm_lv_');
		$this->define('DLM_LV_V',$this->version); # Plugin Version
		
		$this->define('DLM_LV_LANGUAGE_PATH',DLM_LV_PATH.'languages'); # Plugin Language Folder
		$this->define('DLM_LV_ADMIN',DLM_LV_INC.'admin/'); # Plugin Admin Folder
		$this->define('DLM_LV_TEMPLATE',DLM_LV_PATH.'template/');
        
		$this->define('DLM_LV_URL',plugins_url('', __FILE__ ).'/');  # Plugin URL
		$this->define('DLM_LV_CSS',DLM_LV_URL.'includes/css/'); # Plugin CSS URL
		$this->define('DLM_LV_IMG',DLM_LV_URL.'includes/img/'); # Plugin IMG URL
		$this->define('DLM_LV_JS',DLM_LV_URL.'includes/js/'); # Plugin JS URL
    }
	
    /**
	 * Define constant if not already set
	 * @param  string $name
	 * @param  string|bool $value
	 */
    protected function define($key,$value){
        if(!defined($key)){
            define($key,$value);
        }
    }
    
}