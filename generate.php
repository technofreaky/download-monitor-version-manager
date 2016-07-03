<?php 
if(isset($_REQUEST['change'])){
	$files_check = array();
	get_php_files(__DIR__);
	foreach ($files_check as $f){
		$file = file_get_contents($f);
		
		$file = str_replace('WooCommerce Plugin Boiler Plate','Download Monitor Latest Version',$file);
		$file = str_replace('woocommerce-plugin-boiler-plate','download-monitor-latest-version',$file);
		$file = str_replace('WooCommerce_Plugin_Boiler_Plate','Download_Monitor_Latest_Version',$file);
		$file = str_replace('https://wordpress.org/plugins/woocommerce-plugin-boiler-plate/', 'http://google.com/' , $file ); 
		$file = str_replace('[version]', '1.0' , $file ); 
		$file = str_replace('[package]', 'Download Monitor Latest Version' , $file ); 
		$file = str_replace('[plugin_name]', 'Download Monitor Latest Version' , $file ); 
		$file = str_replace('[plugin_url]', 'http://google.com' , $file ); 
		$file = str_replace('wc_pbp_','dlm_lv_',$file);
		$file = str_replace('PLUGIN_FILE', 'DLM_LV_FILE' , $file);
		$file = str_replace('PLUGIN_PATH', 'DLM_LV_PATH' , $file);
		$file = str_replace('PLUGIN_INC', 'DLM_LV_INC' , $file);
		$file = str_replace('PLUGIN_DEPEN', 'DLM_LV_DEPEN' , $file);
		$file = str_replace('PLUGIN_NAME', 'DLM_LV_NAME' , $file);
		$file = str_replace('PLUGIN_SLUG', 'DLM_LV_SLUG' , $file);
		$file = str_replace('PLUGIN_TXT', 'DLM_LV_TXT' , $file);
		$file = str_replace('PLUGIN_DB', 'DLM_LV_DB' , $file);
		$file = str_replace('PLUGIN_V', 'DLM_LV_V' , $file);
		$file = str_replace('PLUGIN_LANGUAGE_PATH', 'DLM_LV_LANGUAGE_PATH' , $file);
		$file = str_replace('PLUGIN_ADMIN', 'DLM_LV_ADMIN' , $file);
		$file = str_replace('PLUGIN_SETTINGS', 'DLM_LV_SETTINGS' , $file);
		$file = str_replace('PLUGIN_URL', 'DLM_LV_URL' , $file);
		$file = str_replace('PLUGIN_CSS', 'DLM_LV_CSS' , $file);
		$file = str_replace('PLUGIN_IMG', 'DLM_LV_IMG' , $file);
		$file = str_replace('PLUGIN_JS', 'DLM_LV_JS' , $file);		
		
		file_put_contents($f,$file); 
	}
}

function get_php_files($dir = __DIR__){
	global $files_check;
	$files = scandir($dir); 
	foreach($files as $file) {
		if($file == '' || $file == '.' || $file == '..' ){continue;}
		if(is_dir($dir.'/'.$file)){
			get_php_files($dir.'/'.$file);
		} else {
			if(pathinfo($dir.'/'.$file, PATHINFO_EXTENSION) == 'php' || pathinfo($dir.'/'.$file, PATHINFO_EXTENSION) == 'txt'){
				if($file == 'generate.php'){continue;}
				$files_check[$file] = $dir.'/'.$file;
			}
		}
	}
}
?>


