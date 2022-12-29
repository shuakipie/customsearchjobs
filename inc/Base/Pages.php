<?php

/*
*
* @package Yariko
*
*/

namespace Igj\Inc\Base;

use Igj\Inc\Services\AvionteServices;

class Pages{

    public function register(){
        add_action('admin_menu', function(){
            add_menu_page('Inergroup Settings', 'Inergroup Settings', 'manage_options', 'igj-settings', array($this,'settings') );
        });

    }

    function settings()
    {

        $ip = 'localhost';
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
        var_dump($details);
    }

    

}
?>