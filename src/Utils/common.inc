<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/19
 * Time: 13:58
 */


/**
 * 打印
 */
if(!function_exists('pre')){
    function pre($param){
        echo '<pre>';
        print_r($param);
        echo '</pre>';
        exit();
    }
}

/**
 * 打印
 */
if(!function_exists('pr')){
    function pr($param){
        echo '<pre>';
        print_r($param);
        echo '</pre>';
    }
}