<?php

/*
*
* @package yariko
*
*/

namespace Igj\Inc\Base;

class Deactivate{

    public static function deactivate(){
        flush_rewrite_rules();
    }
}
