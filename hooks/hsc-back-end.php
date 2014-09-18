<?php
/**
 * Init plugin options to white list our options
 */
add_action( 'admin_init', 'tonjoo_hsc_options_init' );
function tonjoo_hsc_options_init()
{
	register_setting( 'tonjoo_options', 'tonjoo_hsc_options' );
}

/**
 * Load up the menu page
 */
add_action( 'admin_menu', 'tonjoo_hsc_options_page' );
function tonjoo_hsc_options_page() 
{	
	add_options_page( 
		__("Tonjoo Hide Show Comment Options Page",TONJOO_HSCOMMENT), 
		'Hide Show Comment', 
		'moderate_comments', 
		'hide-show-comment/view/options-page.php');
}

/**
 * admin_enqueue_scripts
 */
add_action('admin_enqueue_scripts', 'hsc_admin_enqueue_scripts', 100);
function hsc_admin_enqueue_scripts()
{
    HSCOption::admin_enqueue_script($_GET);
}

/** 
 * Display a notice that can be dismissed 
 */
add_action('admin_notices', 'hsc_premium_notice');
function hsc_premium_notice() 
{
    global $current_user ;

    HSCNotice::premium_notice($current_user);
}

add_action('admin_init', 'hsc_premium_nag_ignore');
function hsc_premium_nag_ignore() 
{
    global $current_user;

    HSCNotice::premium_nag_ignore($current_user, $_GET);
}

/**
 * Ajax preview button
 */
add_action('wp_ajax_hsc_preview_button', 'hsc_preview_button' );
function hsc_preview_button() {
    global $wpdb; // this is how you get access to the database
    
    HSCGenerate::generate_in_ajax_backend();
}

add_action('wp_ajax_hsc_preview_button_loadmore', 'hsc_preview_button_loadmore' );
function hsc_preview_button_loadmore() {
    global $wpdb; // this is how you get access to the database
    
    HSCGenerate::generate_in_ajax_backend('load-more');
}