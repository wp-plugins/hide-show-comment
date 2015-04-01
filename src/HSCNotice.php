<?php

namespace Tonjoo\HSC;

class HSCNotice
{
	private $options; 
	private $app;

	public function __construct($container,$hsc)
	{
		$this->app = $container;
		
		$this->options = $hsc->get_options();
	}

	public function premium_notice($current_user)
	{
		$user_id = $current_user->ID;
	    $ignore_notice = get_user_meta($user_id, 'hsc_premium_ignore_notice', true);
	    $ignore_count_notice = get_user_meta($user_id, 'hsc_premium_ignore_count_notice', true);
	    $max_count_notice = 15;

	    // if usermeta(ignore_count_notice) is not exist
	    if($ignore_count_notice == "")
	    {
	        add_user_meta($user_id, 'hsc_premium_ignore_count_notice', $max_count_notice, true);

	        $ignore_count_notice = 0;
	    }

	    // display the notice or not
	    if($ignore_notice == 'forever')
	    {
	        $is_ignore_notice = true;
	    }
	    else if($ignore_notice == 'later' && $ignore_count_notice < $max_count_notice)
	    {
	        $is_ignore_notice = true;

	        update_user_meta($user_id, 'hsc_premium_ignore_count_notice', intval($ignore_count_notice) + 1);
	    }
	    else
	    {
	        $is_ignore_notice = false;
	    }

	    /* Check that the user hasn't already clicked to ignore the message & if premium not installed */
	    if (! $is_ignore_notice  && ! function_exists("is_hsc_premium_exist")) 
	    {
	        echo '<div class="updated"><p>';
	        printf(__('Get 40+ button style, <a href="%1$s" target="_blank">Get Hide Show Comment Premium !</a> <span style="float:right;"><a href="%2$s" style="color:#a00;">Don\'t bug me again</a> <a href="%3$s" class="button button-primary" style="margin:-5px -5px 0 5px;vertical-align:baseline;">Not Now</a></span>'), 'https://tonjoostudio.com/addons/hide-show-comment-premium/', '?hsc_premium_nag_ignore=forever', '?hsc_premium_nag_ignore=later');
	        echo "</p></div>";
	    }
	}

	public function premium_nag_ignore($current_user, $data)
	{
		$user_id = $current_user->ID;

	    // If user clicks to ignore the notice, add that to their user meta
	    if (isset($data['hsc_premium_nag_ignore']) && $data['hsc_premium_nag_ignore'] == 'forever') 
	    {
	        update_user_meta($user_id, 'hsc_premium_ignore_notice', 'forever');
	    }
	    else if (isset($data['hsc_premium_nag_ignore']) && $data['hsc_premium_nag_ignore'] == 'later') 
	    {
	        update_user_meta($user_id, 'hsc_premium_ignore_notice', 'later');
	        update_user_meta($user_id, 'hsc_premium_ignore_count_notice', 0);

	        $total_ignore_notice = get_user_meta($user_id, 'hsc_premium_ignore_count_notice_total', true); 

	        if($total_ignore_notice == '') $total_ignore_notice = 0;

	        update_user_meta($user_id, 'hsc_premium_ignore_count_notice_total', intval($total_ignore_notice) + 1);

	        if(intval($total_ignore_notice) >= 5)
	        {
	            update_user_meta($user_id, 'hsc_premium_ignore_notice', 'forever');
	        }
	    }
	}
}