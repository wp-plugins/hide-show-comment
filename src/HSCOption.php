<?php

namespace Tonjoo\HSC;

class HSCOption
{
	public $options; 

	public function __construct($container)
	{		
		$this->app = $container;
		$this->options = get_option('tonjoo_hsc_options');
	}

	public function get_options()
	{	
		return $this->load_default($this->options);
	}

	public function load_default($options)
	{	
		if(!isset($options['show_button_text'])||$options['show_button_text']==''){
			$options['show_button_text']='Show Comments';		
		}

		if(!isset($options['hide_button_text'])||$options['hide_button_text']==''){
			$options['hide_button_text']='Hide Comments';		
		}

		if(!isset($options['align'])){
			$options['align']='left';		
		}

		if(!isset($options['template']) || !function_exists('is_hsc_premium_exist')){
			$options['template']="button";
		}

		if(!isset($options['custom_template']) || !function_exists('is_hsc_premium_exist')){
			$options['custom_template']="{button}";
		}

		if(!isset($options['custom_css'])){
			$options['custom_css']="";
		}

		if(!isset($options['button_skin']) || !function_exists('is_hsc_premium_exist') && strpos($options['button_skin'], "-PREMIUMtrue")){
			$options['button_skin']="none";
		}

		if(!isset($options['button_font']) || !function_exists('is_hsc_premium_exist')){
			$options['button_font']="Open Sans";
		}

		if(!isset($options['button_font_size'])){
			$options['button_font_size']="14";
		}

		if(!isset($options['comment_identifier']) || $options['comment_identifier'] == ''){
			$options['comment_identifier']="#comments";
		}

		return $options;
	}

	public function admin_enqueue_script($data)
	{
		if(isset($data['page']) && $data['page'] == "hide-show-comment/view/options-page.php")
	    {
	        //print script
	        echo "<script type='text/javascript'>";
	        echo "var hsc_dir_name = '".plugins_url().'/'.HSCOMMENT_DIR_NAME."';";
	        echo "var hsc_button_dir_name = '".plugins_url().'/'.HSCOMMENT_DIR_NAME.'/assets/buttons/'."';";        

	        if(function_exists('is_hsc_premium_exist')) {
	            echo "var hsc_premium_dir_name = '".plugins_url().'/'.HSCOMMENT_PREMIUM_DIR_NAME."';";            
	            echo "var hsc_button_premium_dir_name = '".plugins_url().'/'.HSCOMMENT_PREMIUM_DIR_NAME.'/buttons/'."';";
	            echo "var hsc_premium_enable = true;";
	        }
	        else
	        {
	        	echo "var hsc_button_premium_dir_name = '".plugins_url().'/'.HSCOMMENT_DIR_NAME.'/assets/premium-promo/'."';";
	            echo "var hsc_premium_enable = false;";
	        }
	        
	        echo "</script>";

	        // javascript
	        wp_enqueue_script('ace-js',plugins_url().'/'.HSCOMMENT_DIR_NAME."/assets/ace-min-noconflict-css-monokai/ace.js",array(),HSCOMMENT_VERSION);
	        wp_enqueue_script('select2-js',plugins_url().'/'.HSCOMMENT_DIR_NAME."/assets/select2/select2.js",array(),HSCOMMENT_VERSION);  

	        // css
	        wp_enqueue_style('select2-css',plugins_url().'/'.HSCOMMENT_DIR_NAME."/assets/select2/select2.css",array(),HSCOMMENT_VERSION);

	        // admin script and style
	        wp_enqueue_script('hsc-admin-js',plugins_url().'/'.HSCOMMENT_DIR_NAME."/assets/js/hsc-admin.js",array(),HSCOMMENT_VERSION);
	        wp_enqueue_style('hsc-admin-css',plugins_url().'/'.HSCOMMENT_DIR_NAME."/assets/css/hsc-admin.css",array(),HSCOMMENT_VERSION);
	    }
	}
}