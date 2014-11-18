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

	function get_attributes($data, $type)
	{
		$this->type 		= $type;
		$this->font 		= $type == 'hide-show' ? $data['button_font'] : $data['loadmore_font'];
		$this->font_size 	= $type == 'hide-show' ? $data['button_font_size'] : $data['loadmore_font_size'];
		$this->align 		= $type == 'hide-show' ? $data['align'] : $data['loadmore_align'];
		$this->skin 		= $type == 'hide-show' ? $data['button_skin'] : $data['loadmore_skin'];
		$this->text 		= $type == 'hide-show' ? $data['show_button_text'] : $data['loadmore_button_text'];
		
		$this->custom_css	= $data['custom_css'];

		if($type == 'hide-show')
		{
			$this->class = 'hsc-button-hideshow';
			$this->template		= $data['template'];
			$this->cus_template	= $data['custom_template'];
		}
		else
		{
			$this->class = 'hsc-button-loadmore';
			$this->loadmore_load_number = isset($data['loadmore_load_number']) ? $data['loadmore_load_number'] : 0;
		}
	}

	private function get_font_style()
	{
		echo "<style type='text/css'>";

	    switch ($this->font)
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

	    echo "p.{$this->class} { font-family: '".$this->font."', Helvetica, Arial, sans-serif; }";    
	    echo "</style>";
	}

	private function get_custom_style()
	{
		$style = "<style type='text/css'>";
	    $style.= $this->custom_css;
	    $style.= ".{$this->class} { font-size: ".$this->font_size."px !important; }";
	    $style.= "</style>";

	    echo $style;
	}

	private function get_print_button($count = 16)
	{
		if($this->type == 'hide-show')
		{
			if(function_exists('is_hsc_premium_exist'))
		    {
		        $template = $this->cus_template;
		    }
		    else
		    {
		        $template = '{button}';
		    }

		    $template = str_replace('{button}', "<a class='hsc-link' id='hsc-btn-hideshow' href='javascript:;'><span>{$this->text}</span></a>", $template);
		    $template = str_replace('{count}', $count, $template);

		    if($this->template == "count" && function_exists('is_hsc_premium_exist'))
		    {
		        $template = "<a class='hsc-count-only' id='hsc-count-hideshow' href='javascript:;'>$template</a>";
		    }
		}
		else
		{
			$template = "<a class='hsc-link' id='hsc-btn-loadmore' href='javascript:;'><span>{$this->text}</span></a>";
		}
	    
	  
	    $button_skin = explode('-PREMIUM', $this->skin);
	    
	    return "<p class='hsc-button {$this->class} {$button_skin[0]}' style='text-align:{$this->align};' >$template</p>";
	}

	public function generate_in_frontend($type = 'hide-show')
	{
		$this->get_attributes($this->options,$type);

		wp_enqueue_script('hsc-js', plugin_dir_url(__DIR__)."assets/js/hsc.js", array(),HSCOMMENT_VERSION);
	    wp_enqueue_style('hsc-css', plugin_dir_url(__DIR__)."assets/css/hsc.css", array(),HSCOMMENT_VERSION);

		/**
	     * Font
	     */
	    $this->get_font_style();

	    /**
	     * button style
	     */
	    $exp = explode('-PREMIUM', $this->skin);

	    if(count($exp) > 1 AND $exp[1] == 'true')
	    {
	    	wp_enqueue_style('hsc-button-skin'.$type, plugins_url(HSCOMMENT_PREMIUM_DIR_NAME."/buttons/{$exp[0]}.css"), array(),HSCOMMENT_VERSION);
	    }
	    else
	    {
	    	wp_enqueue_style('hsc-button-skin'.$type, plugins_url(HSCOMMENT_DIR_NAME."/assets/buttons/{$exp[0]}.css"), array(),HSCOMMENT_VERSION);
	    }

	    /**
	     * custom css
	     */
	    $this->get_custom_style();

	    /**
	     * print button
	     */
	    $print = $this->get_print_button(get_comments_number());

	    echo '<script type="text/javascript">';

	    if($this->type == 'hide-show')
	    {
	    	echo 'var hsc_hideshow_print = "'.$print.'";';
	    	echo "var hsc_show_button_text = '{$this->options['show_button_text']}';";
	    	echo "var hsc_hide_button_text = '{$this->options['hide_button_text']}';";
	    }
	    else
	    {
	    	echo 'var hsc_loadmore_print = "'.$print.'";';	    	
	    	echo 'var loadmore_load_number = "'.$this->options['loadmore_load_number'].'";';	    	
	    }

	    $hide_show = $this->options['plugin_type'] == 'load-more' ? 'false' : 'true';
	    $load_more = $this->options['plugin_type'] == 'hide-show' ? 'false' : 'true';
	    
	    echo "var comment_identifier = '{$this->options['comment_identifier']}';";
	    echo "var loadmore_identifier = '{$this->options['loadmore_identifier']}';";
	    echo "var identifier_type = '{$this->options['identifier_type']}';";
	    echo "var hide_show = $hide_show;";
	    echo "var load_more = $load_more;";
	    echo "var load_more_animation = '{$this->options['loadmore_animation']}';";
	    echo "var hide_show_animation = '{$this->options['hideshow_animation']}';";
	    echo "</script>";
	}

	public function generate_in_ajax_backend($type = 'hide-show')
	{
		$this->get_attributes($_POST,$type);

		/**
	     * Font
	     */
		$this->get_font_style();

	    /**
	     * button style
	     */
	    $exp = explode('-PREMIUM', $this->skin);
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
	    $this->get_custom_style();

	    /**
	     * print button
	     */
	    echo $this->get_print_button(16);

	    die();
	}
}
