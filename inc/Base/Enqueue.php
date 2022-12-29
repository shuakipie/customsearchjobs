<?php

/*
*
* @package Yariko
*
*/

namespace Igj\Inc\Base;

class Enqueue{

    public function register(){

        add_action( 'wp_enqueue_scripts',  array($this,'igj_enqueue_frontend'));

    }

    /**
     * Enqueueing the main scripts with all the javascript logic that this plugin offer
     */
    function igj_enqueue_frontend(){
        wp_enqueue_style('main-css', IGJ_PLUGIN_URL . '/assets/css/main.css');

        wp_enqueue_script('main-js', IGJ_PLUGIN_URL  . '/assets/js/main.js' ,array('jquery'),'1.0', true);
        wp_localize_script( 'main-js', 'parameters', ['ajax_url'=> admin_url('admin-ajax.php'), 'site_url' => site_url(), 'plugin_url' => IGJ_PLUGIN_URL]);
    }

}