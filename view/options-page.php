<?php
/**
 * save options
 */
if($_POST && isset($_POST['tonjoo_hsc_options']))
{
	/**
	 * Tonjoo License
	 */
	if(class_exists('TonjooPluginLicenseHSC'))
	{
		$PluginLicense = new TonjooPluginLicenseHSC($_POST['tonjoo_hsc_options']['license_key']);
		$_POST = $PluginLicense->license_on_save($_POST);
	}	

	// update options
	update_option('tonjoo_hsc_options', $_POST['tonjoo_hsc_options']);	
	
	$location = admin_url("options-general.php?page=hide-show-comment/view/options-page.php") . '&settings-updated=true';
	echo "<meta http-equiv='refresh' content='0;url=$location' />";
	echo "<h2>Loading...</h2>";
	exit();
}
?>
	
<style>
	label{
		vertical-align: top
	}

	.form-table input{
		width: 275px;
	}

	#setting-error-settings_updated {
		display: none;
	}
</style>

<div class="wrap">
<?php echo "<h2>".__("Hide Show Comment Options")."</h2>"; ?>

<br>
<?php _e("Hide Show Comment by",TONJOO_HSCOMMENT) ?> 
<a href='https://tonjoostudio.com' target="_blank">Tonjoo Studio</a> ~ 
<a href='https://tonjoostudio.com/addons/hide-show-comment-premium/?utm_source=upgrade&utm_medium=link&utm_campaign=hsc' target="_blank"><?php _e("Plugin Page",TONJOO_HSCOMMENT) ?></a> | 
<a href='http://wordpress.org/support/view/plugin-reviews/hide-show-comment?filter=5' target="_blank"><?php _e("Please Rate :)",TONJOO_HSCOMMENT) ?></a> |
<a href='http://wordpress.org/extend/plugins/hide-show-comment/' target="_blank"><?php _e("Comment",TONJOO_HSCOMMENT) ?></a> | 
<a href='https://forum.tonjoostudio.com' target="_blank"><?php _e("Bug Report",TONJOO_HSCOMMENT) ?></a> |
<a href='https://tonjoostudio.com/addons/hide-show-comment/#faq' target="_blank"><?php _e("FAQ",TONJOO_HSCOMMENT) ?></a> |
<a href='https://tonjoostudio.com/donate' target="_blank"><?php _e("Donate Us",TONJOO_HSCOMMENT) ?></a> 
<br>
<br>

<?php if(isset($_REQUEST['settings-updated']) && $_REQUEST['settings-updated']==true) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.') ?></strong></p>
    </div>
<?php } ?>

<form method="post" action="">
	<?php 
		settings_fields('tonjoo_options'); 

		$options = HSCOption::get_options();
	?>

	
	<?php if(function_exists('is_hsc_premium_exist')): ?>
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab" id='opt-general-tab' href='#opt-general'><?php _e('General Options',TONJOO_HSCOMMENT) ?></a>
		<a class="nav-tab" id='opt-license-tab' href='#opt-license'><?php _e('License',TONJOO_HSCOMMENT) ?></a>
	</h2>
	<?php endif ?>


	<div class="metabox-holder columns-2" style="margin-right: 300px;">	

	<!-- GENERAL OPTIONS -->
	<div id='opt-general' class="postbox-container group" style="width: 100%;min-width: 463px;float: left; ">
	<div class="meta-box-sortables ui-sortable">
	<div id="adminform" class="postbox">
	
	<?php
		$premium_message = '';

		// premium anouncement
		if(! function_exists('is_hsc_premium_exist'))
		{		
			$premium_url = 'https://tonjoostudio.com/addons/hide-show-comment-premium/';

			echo "<h3 class='hndle'><span>Purchase The <a style='font-size:14px;font-weight:bold;' href='$premium_url' target='_blank'>Premium Edition</a> To Enable All Premium Features</span></h3>";
			$premium_message = "<br/><span style='color:#B23843;'>Unable to change? <a href='$premium_url' target='_blank' ><b>unlock</b></a></span>";
		}	
	?>

	<h3 class="hndle"><span>General Options</span></h3>
	<div class="inside" style="z-index:1;">
	<!-- Extra style for options -->
	<style>
		.form-table td {
			vertical-align: middle;
		}

		.form-table th {
			width: 200px
		}

		.form-table input,.form-table select,.form-table textarea {
			width: 350px;
			margin-right: 10px;
		}

		.form-table textarea {
			height: 100px;
		}

		label.error {
		    margin-left: 5px;
		    color: red;
		}

		.form-table tr th {
		    text-align: left;
		    font-weight: normal;
		}

		.meta-subtitle {
		    margin: 0px -22px !important;
		    border-top:1px solid rgb(238, 238, 238);
		    background-color:#f6f6f6;
		}

		@media (max-width: 767px) {
			    .meta-subtitle {
			      margin-left: -12px !important;
			    }
		}
	</style>

	<table class="form-table">

		<?php
			// Plugin Type
			$plugin_type = array(
				'0' => array(
					'value' =>	'all',
					'label' =>  __('Enable All',TONJOO_HSCOMMENT)
					),
				'1' => array(
					'value' =>	'hide-show',
					'label' =>  __('Hide Show Comment',TONJOO_HSCOMMENT) 
					),
				'2' => array(
					'value' =>	'load-more',
					'label' =>  __('Load More Comment',TONJOO_HSCOMMENT) 
					)
				);		
			$plugin_type_select = array(
				"name"=>"tonjoo_hsc_options[plugin_type]",
				"description" => "",
				"label" => __("Enabled Feature",TONJOO_HSCOMMENT),
				"value" => $options['plugin_type'],
				"select_array" => $plugin_type
				);
			tj_print_select_option($plugin_type_select);
		?>
		<tr valign="top">
			<th>Load More Button Identifier</th>
			<td><input type="text" name="tonjoo_hsc_options[loadmore_identifier]" value="<?php echo $options['loadmore_identifier'] ?>"></td>
			<td>&nbsp;</td>
		</tr>
		<tr valign="top">
			<th>&nbsp;</th>
			<td colspan="2">
				This setting is for <b>Manual</b> load more button identifier. 
				<br>By default, the plugin will add a class ".hsc-comment-class" to each comment child / item, but in some case this class not added because every theme has his own method. 
				<br>So please identify your child comment class manually and put the class name (class name begin with ".") here if the load more button did't work.
			</td>
		</tr>
		
		<?php
			// Identifier Type
			$options_identifier = array(
				'0' => array(
					'value' =>	'auto',
					'label' =>  __('Automatic',TONJOO_HSCOMMENT)
					),
				'1' => array(
					'value' =>	'manual',
					'label' =>  __('Manual',TONJOO_HSCOMMENT) 
					)
				);		
			$options_identifier_select = array(
				"name"=>"tonjoo_hsc_options[identifier_type]",
				"description" => "",
				"label" => __("Hide Show Button",TONJOO_HSCOMMENT),
				"value" => $options['identifier_type'],
				"select_array" => $options_identifier
				);
			tj_print_select_option($options_identifier_select);
		?>
		
		<tr valign="top" class="advanced-form">
			<th>Hide Show Button Identifier</th>
			<td><input type="text" name="tonjoo_hsc_options[comment_identifier]" value="<?php echo $options['comment_identifier'] ?>"></td>
			<td>&nbsp;</td>
		</tr>
		<tr valign="top" class="advanced-form">
			<th>&nbsp;</th>
			<td colspan="2">
				This setting is for <b>Manual</b> hide show button identifier. 
				<br>The default WordPress comment ID is "#comments", but if your theme use another identifier, you can change here. The value can be ID ( # ) or Class ( . ) 
			</td>
		</tr>

		<?php
		// Button font
		$button_font_array = array(
			'0' => array(
				'value' =>	'',
				'label' =>  'Use Content Font'
				),
			'1' => array(
				'value' =>	'Open Sans',
				'label' =>  'Open Sans'
				),
			'2' => array(
				'value' =>	'Lobster',
				'label' =>  'Lobster'
				),
			'3' => array(
				'value' =>	'Lobster Two',
				'label' =>  'Lobster Two'
				),
			'4' => array(
				'value' =>	'Ubuntu',
				'label' =>  'Ubuntu'
				),
			'5' => array(
				'value' =>	'Ubuntu Mono',
				'label' =>  'Ubuntu Mono'
				),
			'6' => array(
				'value' =>	'Titillium Web',
				'label' =>  'Titillium Web'
				),
			'7' => array(
				'value' =>	'Grand Hotel',
				'label' =>  'Grand Hotel'
				),
			'8' => array(
				'value' =>	'Pacifico',
				'label' =>  'Pacifico'
				),
			'9' => array(
				'value' =>	'Crafty Girls',
				'label' =>  'Crafty Girls'
				),
			'10' => array(
				'value' =>	'Bevan',
				'label' =>  'Bevan'
				)
		);
		?>

		<tr>
        	<td colspan=3>
        		<h3 class='meta-subtitle'>Hide Show Comment Options</h3>
    		</td>
    	</tr>

		<?php

		/**
         * Hide Show Comment Options
         *
         * @since 	1.0.5
         */

		// Show Text
		$text_options = array(
			'label'=>__('Show Button Text',TONJOO_HSCOMMENT),
			'name'=>'tonjoo_hsc_options[show_button_text]',
			'value'=>$options['show_button_text'],
			'description'=>""
			);
		tj_print_text_option($text_options);

		// Hide Text
		$text_options = array(
			'label'=>__('Hide Button Text',TONJOO_HSCOMMENT),
			'name'=>'tonjoo_hsc_options[hide_button_text]',
			'value'=>$options['hide_button_text'],
			'description'=>""
			);
		tj_print_text_option($text_options);


		// Hide Show Align
		$align_options = array(
			'0' => array(
				'value' =>	'left',
				'label' =>  __('Left',TONJOO_HSCOMMENT)
				),
			'1' => array(
				'value' =>	'center',
				'label' =>  __('Center',TONJOO_HSCOMMENT) 
				),
			'2' => array(
				'value' =>	'right',
				'label' =>  __('Right',TONJOO_HSCOMMENT) 
				)
			);		
		$align_options_select = array(
			"name"=>"tonjoo_hsc_options[align]",
			"description" => "",
			"label" => __("Button Align",TONJOO_HSCOMMENT),
			"value" => $options['align'],
			"select_array" => $align_options
			);
		tj_print_select_option($align_options_select);
		?>

		<tr valign="top">
			<th>Button Font Size</th>
			<td><input type="number" name="tonjoo_hsc_options[button_font_size]" value="<?php echo $options['button_font_size'] ?>"></td>
			<td>&nbsp;</td>
		</tr>

		<?php	
		// Template
		$template_options = array(
			'0' => array(
				'value' =>	'button_only',
				'label' =>  __('Button Only',TONJOO_HSCOMMENT)
				),
			'1' => array(
				'value' =>	'count_and_button',
				'label' =>  __('Comment Count and Button',TONJOO_HSCOMMENT) 
				),
			'2' => array(
				'value' =>	'count',
				'label' =>  __('Count Only',TONJOO_HSCOMMENT) 
				)
			);
		$template_options_select = array(
			"name"=>"tonjoo_hsc_options[template]",
			"description" => "",
			"label" => __("Template $premium_message",TONJOO_HSCOMMENT),
			"value" => $options['template'],
			"select_array" => $template_options
			);
		tj_print_select_option($template_options_select);

		?>

		<tr valign="top">
        	<th>Custom Template <?php echo $premium_message ?></th>
			<td>
				<textarea id="custom_template" name="tonjoo_hsc_options[custom_template]" ></textarea>
				<script type="text/javascript">document.getElementById('custom_template').value = '<?php echo $options["custom_template"] ?>';</script>
			</td>
			<td>&nbsp;</td>
		</tr>

		<?php

		// Animation
		$animation_type = array(
			'0' => array(
				'value' =>	'none',
				'label' =>  __('None',TONJOO_HSCOMMENT)
				),
			'1' => array(
				'value' =>	'slide',
				'label' =>  __('Slide',TONJOO_HSCOMMENT) 
				),
			'2' => array(
				'value' =>	'fade',
				'label' =>  __('Fade',TONJOO_HSCOMMENT) 
				)
			);		
		$animation_type_select = array(
			"name"=>"tonjoo_hsc_options[hideshow_animation]",
			"description" => "",
			"label" => __("Animation $premium_message",TONJOO_HSCOMMENT),
			"value" => $options['hideshow_animation'],
			"select_array" => $animation_type
			);
		tj_print_select_option($animation_type_select);


		$button_font = array(
			"name"=>"tonjoo_hsc_options[button_font]",
			"description" => "",
			"label" => __("Button Font $premium_message",TONJOO_HSCOMMENT),
			"value" => $options['button_font'],
			"select_array" => $button_font_array
			);

		echo tj_print_select_option($button_font);

		
		// Button skin
        $dir = ABSPATH . 'wp-content/plugins/'.HSCOMMENT_DIR_NAME."/assets/buttons";
        $skins = scandir($dir);
        $button_skin =  array();
        $button_skin_val = $options['button_skin'];
        $button_skin_loadmore_val = $options['loadmore_skin'];

        array_push($button_skin, array("label"=>"None","value"=>"hsc-buttonskin-none"));
        array_push($button_skin, array("label"=>"Black","value"=>"hsc-buttonskin-black"));
        array_push($button_skin, array("label"=>"White","value"=>"hsc-buttonskin-white"));

        if(function_exists('is_hsc_premium_exist')) 
        {                
            $dir = ABSPATH . 'wp-content/plugins/'.HSCOMMENT_PREMIUM_DIR_NAME.'/buttons';

            $skins = scandir($dir);

            foreach ($skins as $key => $value) {

                $extension = pathinfo($value, PATHINFO_EXTENSION); 
                $filename = pathinfo($value, PATHINFO_FILENAME); 
                $extension = strtolower($extension);
                $the_value = strtolower($filename);
                $filename_ucwords = str_replace('-', ' ', $filename);
                $filename_ucwords = ucwords($filename_ucwords);
                $filename_ucwords = str_replace('Hsc Buttonskin ', '', ucwords($filename_ucwords));

                if($extension=='css'){
                    $data = array(
                                "label"=>"$filename_ucwords (Premium)",
                                "value"=>"$the_value-PREMIUMtrue"
                            );

                    array_push($button_skin,$data);
                }
            }
        }
        else
	    {
	        $skins = scandir(ABSPATH . 'wp-content/plugins/'.HSCOMMENT_DIR_NAME.'/assets/premium-promo');

            foreach ($skins as $key => $value) {

                $extension = pathinfo($value, PATHINFO_EXTENSION); 
                $filename = pathinfo($value, PATHINFO_FILENAME); 
                $extension = strtolower($extension);
                $the_value = strtolower($filename);
                $filename_ucwords = str_replace('-', ' ', $filename);
                $filename_ucwords = ucwords($filename_ucwords);
                $filename_ucwords = str_replace('Hsc Buttonskin ', '', ucwords($filename_ucwords));

                if($extension=='png'){
                    $data = array(
                                "label"=>"$filename_ucwords (Premium)",
                                "value"=>"$the_value-PREMIUMtrue"
                            );

                    array_push($button_skin,$data);
                }
            }

            if(substr($button_skin_val, -12) == "-PREMIUMtrue")
            {
            	$button_skin_val = "hsc-buttonskin-none";
            }
	    }

        $option_select = array(
                        "name"=>"tonjoo_hsc_options[button_skin]",
                        "description" => "",
                        "label" => "Button Skin $premium_message",
                        "value" => $button_skin_val,
                        "select_array" => $button_skin,
                        "id"=>"tonjoo-hsc-button_skin"
                    );
        
        tj_print_select_option($option_select);
        ?>

        <tr>
        	<th>Live Preview</th>
        	<td colspan=2>
        		<div id="hsc_ajax_preview_button"></div>
        	</td>
        </tr>        

        <tr>
        	<td colspan=3>
        		<h3 class='meta-subtitle'>Load More Comment Options</h3>
    		</td>
    	</tr>

    	<?php   

        /**
         * Load More Comment Options
         *
         * @since 	1.0.5
         */

        $text_options = array(
			'label'=>__('Button Text',TONJOO_HSCOMMENT),
			'name'=>'tonjoo_hsc_options[loadmore_button_text]',
			'value'=>$options['loadmore_button_text'],
			'description'=>""
			);
		tj_print_text_option($text_options);

        $align_options = array(
			'0' => array(
				'value' =>	'left',
				'label' =>  __('Left',TONJOO_HSCOMMENT)
				),
			'1' => array(
				'value' =>	'center',
				'label' =>  __('Center',TONJOO_HSCOMMENT) 
				),
			'2' => array(
				'value' =>	'right',
				'label' =>  __('Right',TONJOO_HSCOMMENT) 
				)
			);		
		$align_options_select = array(
			"name"=>"tonjoo_hsc_options[loadmore_align]",
			"description" => "",
			"label" => __("Button Align",TONJOO_HSCOMMENT),
			"value" => $options['loadmore_align'],
			"select_array" => $align_options
			);
		tj_print_select_option($align_options_select);	
		?>

		<tr valign="top">
			<th>Button Font Size</th>
			<td><input type="number" name="tonjoo_hsc_options[loadmore_font_size]" value="<?php echo $options['loadmore_font_size'] ?>"></td>
			<td>&nbsp;</td>
		</tr>

		<?php

		$load_number = array();
		
		for ($i=1; $i <= 20; $i++) 
		{
			array_push($load_number, array(
				'value' =>	$i,
				'label' =>  __($i,TONJOO_HSCOMMENT)
			));
		}

		$load_number_select = array(
			"name"=>"tonjoo_hsc_options[loadmore_load_number]",
			"description" => "",
			"label" => __("Comment To Load $premium_message",TONJOO_HSCOMMENT),
			"value" => $options['loadmore_load_number'],
			"select_array" => $load_number
			);
		tj_print_select_option($load_number_select);


		// Animation
		$animation_type = array(
			'0' => array(
				'value' =>	'none',
				'label' =>  __('None',TONJOO_HSCOMMENT)
				),
			'1' => array(
				'value' =>	'slide',
				'label' =>  __('Slide',TONJOO_HSCOMMENT) 
				),
			'2' => array(
				'value' =>	'fade',
				'label' =>  __('Fade',TONJOO_HSCOMMENT) 
				)
			);		
		$animation_type_select = array(
			"name"=>"tonjoo_hsc_options[loadmore_animation]",
			"description" => "",
			"label" => __("Animation $premium_message",TONJOO_HSCOMMENT),
			"value" => $options['loadmore_animation'],
			"select_array" => $animation_type
			);
		tj_print_select_option($animation_type_select);


        $loadmore_font = array(
			"name"=>"tonjoo_hsc_options[loadmore_font]",
			"description" => "",
			"label" => __("Button Font $premium_message",TONJOO_HSCOMMENT),
			"value" => $options['loadmore_font'],
			"select_array" => $button_font_array
			);

		echo tj_print_select_option($loadmore_font);


		$loadmore_skin = array(
                        "name"=>"tonjoo_hsc_options[loadmore_skin]",
                        "description" => "",
                        "label" => "Button Skin $premium_message",
                        "value" => $button_skin_loadmore_val,
                        "select_array" => $button_skin,
                        "id"=>"tonjoo-hsc-loadmore_skin"
                    );
        
        tj_print_select_option($loadmore_skin);
    	?>

    	<tr>
        	<th>Live Preview</th>
        	<td colspan=2>
        		<div id="hsc_ajax_preview_button_loadmore"></div>
        	</td>
        </tr>     

		<tr><td colspan=3><h3 class="meta-subtitle">Custom CSS</h3></td></tr>
		<tr valign="top">
			<th colspan=3>
				<p style="margin-top:-25px;font-size:14px;">
					Some css attribute need to use <code>!important</code> value to affect
				</p>
				<div id="ace-editor"><?php echo $options["custom_css"]; ?></div>
				<textarea id="ace_editor_value" name="tonjoo_hsc_options[custom_css]" ><?php echo $options["custom_css"]; ?></textarea>
			</th>
		</tr>
	</table>

	<br><br>
	<input type="submit" class="button-primary" value="<?php _e('Save Options', 'pjc_slideshow_options'); ?>" />	

	</div>			
	</div>			
	</div>			
	</div>	


	<?php if(function_exists('is_hsc_premium_exist')): ?>
	<!-- LICENSE OPTIONS -->
	<div id='opt-license' class="postbox-container group" style="width: 100%;min-width: 463px;float: left; ">
	<div class="meta-box-sortables ui-sortable">
	<div id="adminform" class="postbox">
	<h3 class="hndle"><span><?php _e('License',TONJOO_HSCOMMENT) ?></span></h3>
	<div class="inside" style="z-index:1;">
	<table class="form-table">
		
		<style type="text/css">
			#license_status input {
				width: 200px;
			}
		</style>		

		<?php
			/** 
			 * license status 
			 */	
			$license = isset($options['license_status']) ? unserialize($options['license_status']) : false;	

			$license_status = "<span style='color:red'>Unregistered</span>";
			$license_email = "<span style='color:red'>None</span>";
			$license_date = "<span style='color:red'>Not checked</span>";
			$license_site = "<span style='color:red'>None</span>";

			if($license)
			{
				// status
				if($license['status'])
				{
					$license_status = "<span style='color:blue'>";
					$license_status.= __('Registered',TONJOO_HSCOMMENT);
					$license_status.= "</span>";
				} else {
					$license_status = "<span style='color:red'>";
					$license_status.= __($license['message'],TONJOO_HSCOMMENT);
					$license_status.= "</span>";
				}

				// email
				if(isset($license['email']) && $license['email'] != 'false')
				{
					$license_email = "<span style='font-weight:bold'>{$license['email']}</span>";
				}
				else
				{
					$license_email = "<span style='color:red'>none</span>";
				}

				// date
				if(isset($license['date']) && $license['date'])
				{
					$license_date = $license['date'];
				}
				else
				{
					$license_date = "<span style='color:red'>not checked</span>";
				}

				// site
				if(isset($license['site']) && is_array($license['site']))
				{
					foreach ($license['site'] as $key => $value) 
					{
						$pos = strpos(home_url(), $value);

						if($pos !== false)
						{
							$license_site = $value;

							break;
						}
					}
				}

				// end license if true
			}
		?>

		<tr valign="top" id="license_status">
			<th scope="row">Your License Code</th>
			<td style="width: 300px;" colspan="2">
				<input type="text" name="tonjoo_hsc_options[license_key]" value="<?php echo $options['license_key'] ?>" style="width:300px;">
				<input type="submit" name="save_status_license" class="button-primary" value="Register / Check Status" />
			</td>
		</tr>

		<tr valign="top" id="license_status">
			<th scope="row">Last Checked</th>
			<td style="width: 300px;" colspan="2">
				<?php echo $license_date ?>
			</td>
		</tr>

		<tr valign="top" id="license_status">
			<th scope="row">Last Status</th>
			<td style="width: 300px;" colspan="2">
				<?php echo $license_status ?>
			</td>
		</tr>

		<?php if($license['status']): ?>
			<tr valign="top" id="license_status">
				<th scope="row">Licensed To</th>
				<td style="width: 300px;" colspan="2">
					<?php echo $license_email ?>
				</td>
			</tr>

			<tr valign="top" id="license_status">
				<th scope="row">Registered Sites</th>
				<td style="width: 300px;" colspan="2">
					<?php echo $license_site ?>
				</td>
			</tr>

			<tr valign="top" id="license_status">
				<th scope="row" colspan="3">
					<input type="submit" name="unset_license" class="button" value="Unregister this site" />
				</th>
			</tr>
		<?php endif ?>

		<tr valign="top">
			<th colspan=3>
				<?php 
					_e('Register your license code here to get all benefit of Hide Show Comment. ',TONJOO_HSCOMMENT);
					echo '<div style="height:10px;"></div>';
					_e('<b>Remove Ads</b> by register your license code. ',TONJOO_HSCOMMENT);
					echo '<div style="height:10px;"></div>';
					_e('Find your license code at ',TONJOO_HSCOMMENT);
				?> 
				<a href="https://tonjoostudio.com/manage/plugin" target="_blank">https://tonjoostudio.com/manage/plugin</a>
			</th>
		</tr>

	</table>
	</div>			
	</div>			
	</div>			
	</div>
	<?php endif ?>		


	<div class="postbox-container" style="float: right;margin-right: -300px;width: 280px;">
	<div class="metabox-holder" style="padding-top:0px;">	
	<div class="meta-box-sortables ui-sortable">
		<div id="email-signup" class="postbox">
			<h3 class="hndle"><span>Save Options</span></h3>
			<div class="inside" style="padding-top:10px;">
				Save your changes to apply the options
				<br>
				<br>
				<input type="submit" class="button-primary" value="Save Options" />
				
			</div>
		</div>

		<!-- ADS -->
		<?php
			$license = isset($options['license_status']) ? unserialize($options['license_status']) : false;	
			if(!$license || !$license['status'] || !function_exists('is_hsc_premium_exist')):
		?>

		<div class="postbox">			
			<script type="text/javascript">
				/**
				 * Setiap dicopy-paste, yang find dan dirubah adalah
				 * - var pluginName
				 * - premium_exist
				 */

				jQuery(function(){					
					var pluginName = "hsc";
					var url = 'https://tonjoostudio.com/jsonp/?promo=get&plugin=' + pluginName;
					var promoFirst = new Array();
					var promoSecond = new Array();

					<?php if(function_exists('is_hsc_premium_exist')): ?>
					var url = 'https://tonjoostudio.com/jsonp/?promo=get&plugin=' + pluginName + '&premium=true';
					<?php endif ?>

					// strpos function
					function strpos(haystack, needle, offset) {
						var i = (haystack + '')
							.indexOf(needle, (offset || 0));
						return i === -1 ? false : i;
					}

					jQuery.ajax({url: url, dataType:'jsonp'}).done(function(data){
						
						if(typeof data =='object')
						{
							var fristImg, fristUrl;

						    // looping jsonp object
							jQuery.each(data, function(index, value){

								<?php if(! function_exists('is_hsc_premium_exist')): ?>

								fristImg = pluginName + '-premium-img';
								fristUrl = pluginName + '-premium-url';

								// promoFirst
								if(index == fristImg)
							    {
							    	promoFirst['img'] = value;
							    }

							    if(index == fristUrl)
							    {
							    	promoFirst['url'] = value;
							    }

							    <?php else: ?>

							    if(! fristImg)
							    {
							    	// promoFirst
									if(strpos(index, "-img"))
								    {
								    	promoFirst['img'] = value;

								    	fristImg = index;
								    }

								    if(strpos(index, "-url"))
								    {
								    	promoFirst['url'] = value;

								    	fristUrl = index;
								    }
							    }

							    <?php endif; ?>

								// promoSecond
								if(strpos(index, "-img") && index != fristImg)
							    {
							    	promoSecond['img'] = value;
							    }

							    if(strpos(index, "-url") && index != fristUrl)
							    {
							    	promoSecond['url'] = value;
							    }
							});

							//promo_1
							jQuery("#promo_1 img").attr("src",promoFirst['img']);
							jQuery("#promo_1 a").attr("href",promoFirst['url']);

							//promo_2
							jQuery("#promo_2 img").attr("src",promoSecond['img']);
							jQuery("#promo_2 a").attr("href",promoSecond['url']);
						}
					});
				});
			</script>

			<!-- <h3 class="hndle"><span>This may interest you</span></h3> -->
			<div class="inside" style="margin: 23px 10px 6px 10px;">
				<div id="promo_1" style="text-align: center;padding-bottom:17px;">
					<a href="https://tonjoostudio.com" target="_blank">
						<img src="<?php echo plugins_url(HSCOMMENT_DIR_NAME."/assets/loading-big.gif") ?>" width="100%" alt="Tonjoo Studio">
					</a>
				</div>
				<div id="promo_2" style="text-align: center;">
					<a href="https://tonjoostudio.com" target="_blank">
						<img src="<?php echo plugins_url(HSCOMMENT_DIR_NAME."/assets/loading-big.gif") ?>" width="100%" alt="Tonjoo Studio">
					</a>
				</div>
			</div>
		</div>

		<?php endif; ?>

	</div>
	</div>
	</div>	

	</div>
</form>
</div>