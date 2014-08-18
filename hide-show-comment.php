<?php
/*
Plugin Name: Hide Show Comment
Plugin URI: http://www.tonjoo.com/addons/hide-show-comment
Description: Keep your reader focused on your content. Use this plugin "hide and show" your comment form !
Version: 1.0.0
Author: tonjoo
Author URI: http://www.tonjoo.com/
Contributor: Todi Adiyatmo Wijoyo, Haris Ainur Rozak
*/

define("TONJOO_HSCOMMENT", 'show-hide-comment');
define('HSCOMMENT_VERSION','1.0.0');
define('HSCOMMENT_BASE_PATH',__DIR__);
define('HSCOMMENT_DIR_NAME', str_replace("/hide-show-comment.php", "", plugin_basename(__FILE__)));

// require_once( plugin_dir_path( __FILE__ ) . 'src/ajax.php');

//Included Files
include __DIR__.'/vendor/autoload.php';
include __DIR__.'/src/tonjoo-library.php';


// HSCGenerate
add_action('plugins_loaded', 'hsc_generate_init');

function hsc_generate_init()
{
	$hsc = new Lotus\Almari\Container();
	
	$hsc_option =  new Tonjoo\HSC\HSCOption($hsc);	
	$hsc_generate =  new Tonjoo\HSC\HSCGenerate($hsc,$hsc_option);
	$hsc_notice =  new Tonjoo\HSC\HSCNotice($hsc,$hsc_option);

	$hsc->register('hsc',$hsc);
	$hsc->register('hsc_option',$hsc_option);
	$hsc->register('hsc_generate',$hsc_generate);	
	$hsc->register('hsc_notice',$hsc_notice);	

	// Load the alias mapper
	$aliasMapper = Lotus\Almari\AliasMapper::getInstance();

	// Create facade for HSC
	$alias['HSC'] = 'Tonjoo\HSC\Facade\HSCFacade';
	$alias['HSCOption'] = 'Tonjoo\HSC\Facade\HSCOptionFacade';
	$alias['HSCGenerate'] = 'Tonjoo\HSC\Facade\HSCGenerateFacade';
	$alias['HSCNotice'] = 'Tonjoo\HSC\Facade\HSCNoticeFacade';
	
	$aliasMapper->facadeClassAlias($alias);

	//Register container to facade
	Tonjoo\HSC\Facade\HSCFacade::setFacadeContainer($hsc);
	Tonjoo\HSC\Facade\HSCOptionFacade::setFacadeContainer($hsc);
	Tonjoo\HSC\Facade\HSCGenerateFacade::setFacadeContainer($hsc);
	Tonjoo\HSC\Facade\HSCNoticeFacade::setFacadeContainer($hsc);
}


include __DIR__.'/hooks/hsc-back-end.php';
include __DIR__.'/hooks/hsc-front-end.php';