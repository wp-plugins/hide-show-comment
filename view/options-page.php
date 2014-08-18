<?php
/**
 * save options
 */
if($_POST)
{
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
<a href='http://tonjoo.com' target="_blank">tonjoo</a> ~ 
<a href='http://tonjoo.com/addons/hide-show-comment/' target="_blank"><?php _e("Plugin Page",TONJOO_HSCOMMENT) ?></a> | 
<a href='http://wordpress.org/support/view/plugin-reviews/hide-show-comment?filter=5' target="_blank"><?php _e("Please Rate :)",TONJOO_HSCOMMENT) ?></a> |
<a href='http://wordpress.org/extend/plugins/hide-show-comment/' target="_blank"><?php _e("Comment",TONJOO_HSCOMMENT) ?></a> | 
<a href='http://forum.tonjoo.com' target="_blank"><?php _e("Bug Report",TONJOO_HSCOMMENT) ?></a> |
<a href='http://tonjoo.com/addons/hide-show-comment/#faq' target="_blank"><?php _e("FAQ",TONJOO_HSCOMMENT) ?></a> |
<a href='http://tonjoo.com/donate' target="_blank"><?php _e("Donate Us",TONJOO_HSCOMMENT) ?></a> 
<br>
<br>

<?php if(isset($_REQUEST['settings-updated']) && $_REQUEST['settings-updated']==true) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.') ?></strong></p>
    </div>
<?php } ?>

<form method="post" action="">
	<?php settings_fields('tonjoo_options'); ?>
	<?php 

	$options = HSCOption::get_options();

	?>

	<div class="metabox-holder columns-2" style="margin-right: 300px;">
	<div class="postbox-container" style="width: 100%;min-width: 463px;float: left; ">
	<div class="meta-box-sortables ui-sortable">
	<div id="adminform" class="postbox">
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

		label.error{
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
		// Show Text
		$text_options = array(
			'label'=>__('"Show" Button Text',TONJOO_HSCOMMENT),
			'name'=>'tonjoo_hsc_options[show_button_text]',
			'value'=>$options['show_button_text'],
			'description'=>""
			);
		tj_print_text_option($text_options);

		// Hide Text
		$text_options = array(
			'label'=>__('"Hide" Button Text',TONJOO_HSCOMMENT),
			'name'=>'tonjoo_hsc_options[hide_button_text]',
			'value'=>$options['hide_button_text'],
			'description'=>""
			);
		tj_print_text_option($text_options);

		?>

		<tr valign="top">
			<th>Button Font Size</th>
			<td><input type="number" name="tonjoo_hsc_options[button_font_size]" value="<?php echo $options['button_font_size'] ?>"></td>
			<td>&nbsp;</td>
		</tr>

		<?php	

		// Align
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
			"label" => __("Align",TONJOO_HSCOMMENT),
			"value" => $options['align'],
			"select_array" => $align_options
			);
		tj_print_select_option($align_options_select);	

		// premium anouncement
		if(! function_exists('is_hsc_premium_exist'))
		{			
			echo "<tr><td colspan=3><h3 class='meta-subtitle'>Purchase the <a href='https://tonjoo.com/addons/hide-show-comment-premium/' target='_blank'>Premium Edition</a> to enable all feature below</h3></td></tr>";
		}	

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
			"label" => __("Template",TONJOO_HSCOMMENT),
			"value" => $options['template'],
			"select_array" => $template_options
			);
		tj_print_select_option($template_options_select);	

		?>

		<tr valign="top">
        	<th>Custom Template</th>
			<td>
				<textarea id="custom_template" name="tonjoo_hsc_options[custom_template]" ></textarea>
				<script type="text/javascript">document.getElementById('custom_template').value = '<?php echo $options["custom_template"] ?>';</script>
			</td>
			<td>&nbsp;</td>
		</tr>

		<?php

		// Button font
		$button_font_array = array(
			'0' => array(
				'value' =>	'Open Sans',
				'label' =>  __('Open Sans',TONJOO_HSCOMMENT)
				),
			'1' => array(
				'value' =>	'Lobster',
				'label' =>  __('Lobster',TONJOO_HSCOMMENT) 
				),
			'2' => array(
				'value' =>	'Lobster Two',
				'label' =>  __('Lobster Two',TONJOO_HSCOMMENT) 
				),
			'3' => array(
				'value' =>	'Ubuntu',
				'label' =>  __('Ubuntu',TONJOO_HSCOMMENT) 
				),
			'4' => array(
				'value' =>	'Ubuntu Mono',
				'label' =>  __('Ubuntu Mono',TONJOO_HSCOMMENT) 
				),
			'5' => array(
				'value' =>	'Titillium Web',
				'label' =>  __('Titillium Web',TONJOO_HSCOMMENT) 
				),
			'6' => array(
				'value' =>	'Grand Hotel',
				'label' =>  __('Grand Hotel',TONJOO_HSCOMMENT) 
				),
			'7' => array(
				'value' =>	'Pacifico',
				'label' =>  __('Pacifico',TONJOO_HSCOMMENT) 
				),
			'8' => array(
				'value' =>	'Crafty Girls',
				'label' =>  __('Crafty Girls',TONJOO_HSCOMMENT) 
				),
			'9' => array(
				'value' =>	'Bevan',
				'label' =>  __('Bevan',TONJOO_HSCOMMENT) 
				)
		);

		if(! function_exists('is_hsc_premium_exist')) {
        	for ($i=0; $i <= 9; $i++) { 
        		$button_font_array[$i]['value'] = __('Open Sans',TONJOO_HSCOMMENT);
        	}
        }

		$button_font = array(
			"name"=>"tonjoo_hsc_options[button_font]",
			"description" => "",
			"label" => __("Button Font",TONJOO_HSCOMMENT),
			"value" => $options['button_font'],
			"select_array" => $button_font_array
			);

		echo tj_print_select_option($button_font);

		
		// Button skin
        $dir = ABSPATH . 'wp-content/plugins/'.HSCOMMENT_DIR_NAME."/assets/buttons";
        $skins = scandir($dir);
        $button_skin =  array();
        $button_skin_val = $options['button_skin'];

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
                        "label" => "Button Skin",
                        "value" => $button_skin_val,
                        "select_array" => $button_skin,
                        "id"=>"tonjoo-hsc-button_skin"
                    );
        
        tj_print_select_option($option_select);
    ?>

        <tr><td colspan=3><h3 class="meta-subtitle">Show Comment Live Preview</h3></td></tr>
        <tr>
        	<td colspan=3>
        		<div id="hsc_ajax_preview_button"></div>
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

		<tr><td colspan=3><h3 class="meta-subtitle">Advanced Setting</h3></td></tr>
		<tr valign="top">
			<th>WP Comment Identifier</th>
			<td><input type="text" name="tonjoo_hsc_options[comment_identifier]" value="<?php echo $options['comment_identifier'] ?>"></td>
			<td>&nbsp;</td>
		</tr>
		<tr valign="top">
			<th>&nbsp;</th>
			<td colspan="2">The default WordPress comment ID is "#comments", but if you use another identifier, you can change here. The value can be ID ( # ) or Class ( . ) </td>
		</tr>
	</table>

	<br><br>
	<input type="submit" class="button-primary" value="<?php _e('Save Options', 'pjc_slideshow_options'); ?>" />	

	</div>			
	</div>			
	</div>			
	</div>			


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

		<div class="postbox">
			<script type="text/javascript">
				jQuery(function(){
					var url = 'http://tonjoo.com/about/?hsc-jsonp=promo';

					jQuery.ajax({url: url, dataType:'jsonp'}).done(function(data){
						//promo_1
						if(typeof data =='object'){
							jQuery("#promo_1 a").attr("href",data.permalink_promo_1);
							jQuery("#promo_1 img").attr("src",data.img_promo_1);

							//promo_2
							jQuery("#promo_2 a").attr("href",data.permalink_promo_2);
							jQuery("#promo_2 img").attr("src",data.img_promo_2);
						}
					});
				});
			</script>

			<!-- <h3 class="hndle"><span>This may interest you</span></h3> -->
			<div class="inside" style="margin: 23px 10px 6px 10px;">
				<div id="promo_1" style="text-align: center;padding-bottom:17px;">
					<a href="http://tonjoo.com" target="_blank">
						<img src="<?php echo plugins_url(HSCOMMENT_DIR_NAME."/assets/loading-big.gif") ?>" width="100%" alt="WordPress Security - A Pocket Guide">
					</a>
				</div>
				<div id="promo_2" style="text-align: center;">
					<a href="http://tonjoo.com" target="_blank">
						<img src="<?php echo plugins_url(HSCOMMENT_DIR_NAME."/assets/loading-big.gif") ?>" width="100%" alt="WordPress Security - A Pocket Guide">
					</a>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>	

	</div>
</form>
</div>