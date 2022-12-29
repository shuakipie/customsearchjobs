<?php
/*
*
* @package shuakipie


Plugin Name:  Inergroup Jobs
Plugin URI:   https://shuakipie.com/
Description:  Fetch/consume Avionte api to get jobs from
Version:      1.0.0
Author:       Bennet Group
Author URI:   https://shuakipie.com/
Tested up to: 6.0.1
Text Domain:  inergroup_jobs
Domain Path:  /languages
*/

defined('ABSPATH') or die('You do not have access, sally human!!!');

define ( 'IGJ_PLUGIN_VERSION', '1.0.0');

if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php') ){
    require_once  dirname( __FILE__ ) . '/vendor/autoload.php';
}

define('IGJ_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define('IGJ_PLUGIN_URL' , plugin_dir_url(  __FILE__  ) );
define('IGJ_ADMIN_URL' , get_admin_url() );
define('IGJ_PLUGIN_DIR_BASENAME' , dirname(plugin_basename(__FILE__)) );

//include the helpers
include 'inc/util/helpers.php';
if( class_exists( 'Igj\\Inc\\Init' ) ){
    register_activation_hook( __FILE__ , array('Igj\\Inc\\Base\\Activate','activate') );
    Igj\Inc\Init::register_services();
}



