<?php
/**
 * The admin-specific functionality of the plugin.
 * @link http://google.com
 * @package Download Monitor Latest Version
 * @subpackage Download Monitor Latest Version/Admin
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

class DLM_Version_Manager_Admin_Handler {
    
    public function __construct() {
        add_action('dlm_options_start',array($this,'add_latest_version_field'));
        add_action('dlm_save_metabox',array($this,'save_latest_version_field'));
        add_action('download_monitor_settings',array($this,'add_settings'));
    }
    
    public function add_settings($settings){
        $dlmlvs = array(
            array(
                'name'        => DLM_VM_DB.'latest_version_heading',
                'std'         => 'Latest Version',
                'placeholder' => __( 'Latest Version : ', DLM_VM_TXT),
                'label'       => __( 'Latest Version Heading : ', DLM_VM_TXT),
                'desc'        => ''
            ),
            
            array(
                'name'        => DLM_VM_DB.'old_version_heading',
                'std'         => 'Old Version',
                'placeholder' => __( 'Old Version : ', DLM_VM_TXT),
                'label'       => __( 'Old Version Heading : ', DLM_VM_TXT),
                'desc'        => ''
            ),
            
            array(
                'name'        => DLM_VM_DB.'latest_version_file_title',
                'std'         => '{file_name}',
                'placeholder' => __( '{version}', DLM_VM_TXT),
                'label'       => __( 'Latest Version File Display Name : ', DLM_VM_TXT),
                'desc'        => __( 'Use Below Codes for customize the display name ', DLM_VM_TXT ).
                '<br/>
                <code>{download_count}</code> : For file download count <br/>
                <code>{date}</code> : For file date <br/>
                <code>{file_name}</code> For file name <br/>
                <code>{file_size}</code> For file size <br/>
                <code>{file_type}</code> For file type <br/>
                <code>{version}</code> For version number <br/>
                <code>{title}</code> For title number <br/> ',
            ),
            
            array(
                'name'        => DLM_VM_DB.'old_version_file_title',
                'std'         => '{file_name} - {version}',
                'placeholder' => __( '{version}', DLM_VM_TXT),
                'label'       => __( 'Old Version File Display Name : ', DLM_VM_TXT),
                'desc'        => __( 'Use Below Codes for customize the display name ', DLM_VM_TXT ).
                '<br/>
                <code>{download_count}</code> : For file download count <br/>
                <code>{date}</code> : For file date <br/>
                <code>{file_name}</code> For file name <br/>
                <code>{file_size}</code> For file size <br/>
                <code>{file_type}</code> For file type <br/>
                <code>{version}</code> For version number <br/>
                <code>{title}</code> For title number <br/> ',
            ),
        );
        $settings['latestVersion'] = array(__('Latest Version',DLM_VM_TXT),$dlmlvs);
        return $settings; 
    }
    
    public function add_latest_version_field(){
        global $post;
        $postID = $post->ID;
        $versions = $this->generate_version($postID);
        $auto = get_post_meta($postID,'_dlm_latest_version_auto',true);
        
        echo '<p class="form-field form-field-checkbox">';
        echo '<label for="_dlm_latest_version">' . __( 'Latest Version : ', DLM_VM_TXT ) . '</label>';
        echo '<select id="_dlm_latest_version" name="dlm_latest_version" style="width:50%; "> '.$versions.' </select>';
        
        if(!empty($auto)){
            $vid = $this->get_single_version($auto);
            echo '<span class="dlm-description">';
            echo __( 'Auto Selected : ', DLM_VM_TXT );
            echo '<strong>  #'.$auto.' - '.$vid.' </strong> </span>';    
        }
        
        
        echo '</p>';
    }
    
    public function get_single_version($vpid){
        $file_version  = ( $file_version = get_post_meta($vpid, '_version', true ) ) ? $file_version : '';
        return $file_version;
    }
    
    public function get_version_files($postID){
        $version_post_id = get_posts( 'post_parent=' .$postID . '&post_type=dlm_download_version&orderby=menu_order&order=ASC&post_status=any&numberposts=-1&fields=ids' );
        $return = array();
        
        foreach($version_post_id as $vpid){
            $file_version  = ( $file_version = get_post_meta($vpid, '_version', true ) ) ? $file_version : '';
            $return[$vpid] = $file_version;
        } 
        
        return $return;
    }
    
    public function generate_version($postID){
        $versions = $this->get_version_files($postID);
        $selected_latest_version = get_post_meta($postID,'_dlm_latest_version',true);
        
        $mattr = '';
        if($selected_latest_version == 'auto'){$mattr = 'selected';}
        $return = '<option value="auto" '.$mattr.'>'.__('Auto Select',DLM_VM_TXT).'</option> ';
        
        foreach($versions as $vpid => $vid){
            $attr = '';
            if($selected_latest_version == $vpid){$attr = 'selected';}
            $return .= ' <option '.$attr.' value="'.$vpid.'" >#'.$vpid.' - '.$vid.'</option> ';
        }
        
        
        return $return;
    }
    
    public function save_latest_version_field($postID){
        if(isset($_REQUEST['dlm_latest_version'])){
            $val = $_REQUEST['dlm_latest_version'];
            
            if($val == 'auto'){
                $versions = $this->get_version_files($postID);
                $latest = max($versions);
                $latest = array_search($latest, $versions);
                update_post_meta($postID,'_dlm_latest_version_auto',$latest);
            } else {
                update_post_meta($postID,'_dlm_latest_version_auto','');
            }
            
            update_post_meta($postID,'_dlm_latest_version',$val);
        }
    }
}