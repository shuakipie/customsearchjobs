<?php

use Igj\Inc\Services\AvionteServices;
/*function wrpl_get_product_controller(){
    return new ProductController();
}*/


function igj_single_job($id){

    $avionte = new AvionteServices();

    return $avionte->getSingleJob($id);

}

function igj_get_user_city(){
    $ip = $_SERVER['REMOTE_ADDR'];
    $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    if($details){
        return $details->city;
    }
    return '';
}