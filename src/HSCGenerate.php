<?php

namespace Tonjoo\HSC;

class HSCGenerate
{
	private $options; 
	private $app;

	public function __construct($container,$hsc)
	{
		$this->app = $container;
		
		$this->options = $hsc->get_options();
	}

	private function get_font_style($data)
	{
		echo "<style type='text/css'>";

	    switch ($data['button_font'])
	    {
	        case "Open Sans":
	            echo "@import url(http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext);"; //Open Sans
	            break;
	        case "Lobster":
	            echo "@import url(http://fonts.googleapis.com/css?family=Lobster);"; //Lobster
	            break;
	        case "Lobster Two":
	            echo "@import url(http://fonts.googleapis.com/css?family=Lobster+Two:400,400italic,700,700italic);"; //Lobster Two
	            break;
	        case "Ubuntu":
	            echo "@import url(http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic);"; //Ubuntu
	            break;
	        case "Ubuntu Mono":
	            echo "@import url(http://fonts.googleapis.com/css?family=Ubuntu+Mono:400,700,400italic,700italic);"; //Ubuntu Mono
	            break;
	        case "Titillium Web":
	            echo "@import url(http://fonts.googleapis.com/css?family=Titillium+Web:400,300,700,300italic,400italic,700italic);"; //Titillium Web
	            break;
	        case "Grand Hotel":
	            echo "@import url(http://fonts.googleapis.com/css?family=Grand+Hotel);"; //Grand Hotel
	            break;
	        case "Pacifico":
	            echo "@import url(http://fonts.googleapis.com/css?family=Pacifico);"; //Pacifico
	            break;
	        case "Crafty Girls":
	            echo "@import url(http://fonts.googleapis.com/css?family=Crafty+Girls);"; //Crafty Girls
	            break;
	        case "Bevan":
	            echo "@import url(http://fonts.googleapis.com/css?family=Bevan);"; //Bevan
	            break;
	        default:
	            echo "@import url(http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext);"; //Open Sans
	    }

	    echo "p.hsc-button { font-family: '".$data['button_font']."', Helvetica, Arial, sans-serif; }";    
	    echo "</style>";
	}

	private function get_custom_style($data)
	{
		$style = "<style type='text/css'>";
	    $style.= $data["custom_css"];
	    $style.= '.hsc-button { font-size: '.$data["button_font_size"].'px !important; }';	    
	    $style.= "</style>";

	    echo $style;
	}

	private function get_print_button($data, $count = 16)
	{
		if(function_exists('is_hsc_premium_exist'))
	    {
	        $template = $data['custom_template'];
	    }
	    else
	    {
	        $template = '{button}';
	    }

	    $template = str_replace('{button}', "<a class='hsc-link' href='javascript:;' hsc-comment-button><span>{$data['show_button_text']}</span></a>", $template);
	    $template = str_replace('{count}', $count, $template);

	    if($data['template'] == "count" && function_exists('is_hsc_premium_exist'))
	    {
	        $template = "<a class='hsc-count-only' href='javascript:;' hsc-comment-count>$template</a>";
	    }

	    $button_skin = explode('-PREMIUM', $data['button_skin']);
	    
	    return "<p class='hsc-button {$button_skin[0]}' style='text-align:{$data['align']};' >$template</p>";
	}

	public function generate_in_frontend()
	{
		echo "<script type='text/javascript'>";
	    echo "var hsc_show_button_text = '{$this->options['show_button_text']}';";
	    echo "var hsc_hide_button_text = '{$this->options['hide_button_text']}';";
	    echo "</script>";

	    wp_enqueue_script('hsc-js', plugin_dir_url(__DIR__)."assets/js/hsc.js", array(),HSCOMMENT_VERSION);
	    wp_enqueue_style('hsc-css', plugin_dir_url(__DIR__)."assets/css/hsc.css", array(),HSCOMMENT_VERSION);

		/**
	     * Font
	     */
	    $this->get_font_style($this->options);

	    /**
	     * button style
	     */
	    $exp = explode('-PREMIUM', $this->options['button_skin']);
	    if(count($exp) > 1 AND $exp[1] == 'true')
	    {
	    	wp_enqueue_style('hsc-button-skin', plugins_url(HSCOMMENT_PREMIUM_DIR_NAME."/buttons/{$exp[0]}.css"), array(),HSCOMMENT_VERSION);
	    }
	    else
	    {
	    	wp_enqueue_style('hsc-button-skin', plugins_url(HSCOMMENT_DIR_NAME."/assets/buttons/{$exp[0]}.css"), array(),HSCOMMENT_VERSION);
	    }

	    /**
	     * custom css
	     */
	    $this->get_custom_style($this->options);

	    /**
	     * print button
	     */
	    $print = $this->get_print_button($this->options,get_comments_number());

	    echo '<script type="text/javascript">';
	    echo 'var hsc_print = "'.$print.'";';
	    echo 'var hsc_identifier = "'.$this->options['comment_identifier'].'";';
	    echo '</script>';
	}

	public function generate_in_ajax_backend()
	{
		/**
	     * Font
	     */
		$this->get_font_style($_POST);

	    /**
	     * button style
	     */
	    $exp = explode('-PREMIUM', $_POST['button_skin']);
	    if(count($exp) > 1 AND $exp[1] == 'true')
	    {
	        echo '<link rel="stylesheet" href="'.plugins_url(HSCOMMENT_PREMIUM_DIR_NAME."/buttons/{$exp[0]}.css").'" type="text/css" media="all">';
	    }
	    else
	    {
	        echo '<link rel="stylesheet" href="'.plugins_url(HSCOMMENT_DIR_NAME."/assets/buttons/{$exp[0]}.css").'" type="text/css" media="all">';
	    }

	    /**
	     * custom css
	     */
	    $this->get_custom_style($_POST);

	    /**
	     * print button
	     */
	    echo $this->get_print_button($_POST);

	    die();
	}
}
