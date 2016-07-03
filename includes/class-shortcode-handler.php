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

class Download_Monitor_Version_Manager_Shortcode_Handler {

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
        add_shortcode('dlm_latest_version',array($this,'latest_version_handler'));
    }
    
    
    public function get_default_shortcode_atts(){
        $return = array();
        $return['id'] = '';
        $return['latest_v_text'] = get_option(DLM_VM_DB.'latest_version_heading');
        if(empty($return['latest_v_text'])){$return['latest_v_text'] == __("Latest Version : ",DLM_VM_TXT); }
        
        $return['old_v_text'] = get_option(DLM_VM_DB.'old_version_heading');
        if(empty($return['old_v_text'])){$return['old_v_text'] == __("Old Versions : ",DLM_VM_TXT); }
        
        return $return;
    }
    
    public function get_download_title($is_latestversion = false){
        $template = get_option(DLM_VM_DB.'old_version_file_title',true);    
        if($is_latestversion){
            $template = get_option(DLM_VM_DB.'latest_version_file_title',true);    
        }
        
        $version = '';

        $download_count = $this->current_download->get_the_download_count();
        $date = $this->current_download->get_the_file_date();
        $filename = $this->current_download->get_the_filename();
        $filesize = $this->current_download->get_the_filesize();
        $filetype = $this->current_download->get_the_filetype();
        $title = $this->current_download->get_the_title();
        
        if ( $this->current_download->has_version_number() ) {
            $version = $this->current_download->get_the_version_number();
        }
        
        $search = array('{download_count}','{date}','{file_name}','{file_size}','{file_type}','{version}','{title}');
        $replace = array($download_count,$date,$filename,$filesize,$filetype,$version,$title,);
        $template = str_replace($search,$replace,$template);
        return $template;           
    }
    
    public function latest_version_handler( $atts ){
        $defaults = $this->get_default_shortcode_atts();
        $atts = shortcode_atts($defaults,$atts,'dlm_latest_version');
        $id = $atts['id'];
        $id = apply_filters( 'dlm_shortcode_download_id', $id );
        if ( empty( $id ) ) { return; }
		$output = '';
		$download = new DLM_Download( $id );
        $this->current_download = $download;
		if ( $download->exists() ) { 
            $template_handler = new DLM_Template_Handler();
            ob_start();
            $template_handler->get_template_part('content-latest-version-download', 
                                                 '', 
                                                 DLM_VM_TEMPLATE, 
                                                 array( 
                                                     'scatts' => $atts,
                                                     'handler' => $this,
                                                     'dlm_download' => $download 
                                                 ) 
                                                );
            $output = ob_get_clean();
            //if ( 'true' === $autop || true === $autop ) { $output = wpautop( $output ); }
            //$output = wpautop( $output );

        } else {
			$output = '[' . __( 'Download not found', 'download-monitor' ) . ']';
		}
		wp_reset_postdata();      
        return $output;
    }
}