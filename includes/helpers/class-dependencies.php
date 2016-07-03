<?php
/**
 * Dependency Checker
 *
 * Checks if required Dependency plugin is enabled
 *
 * @link http://google.com
 * @package Download Monitor Latest Version
 * @subpackage Download Monitor Latest Version/core
 * @since 1.0
 */

if ( ! class_exists( 'Download_Monitor_Latest_Version_Dependencies' ) ){
    class Download_Monitor_Latest_Version_Dependencies {
		
        private static $active_plugins;
		
        public static function init() {
            self::$active_plugins = (array) get_option( 'active_plugins', array() );
            if ( is_multisite() )
                self::$active_plugins = array_merge( self::$active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
        }
		
        public static function active_check($pluginToCheck = '') {
            if ( ! self::$active_plugins ) 
				self::init();
            return in_array($pluginToCheck, self::$active_plugins) || array_key_exists($pluginToCheck, self::$active_plugins);
        }
    }
}
/**
 * WC Detection
 */
if(! function_exists('Download_Monitor_Latest_Version_Dependencies')){
    function Download_Monitor_Latest_Version_Dependencies($pluginToCheck = 'woocommerce/woocommerce.php') {
        return Download_Monitor_Latest_Version_Dependencies::active_check($pluginToCheck);
    }
}
?>