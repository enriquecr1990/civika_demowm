<?php
/**
 * Created by PhpStorm.
 * User: enriq
 * Date: 03/05/2019
 * Time: 04:40 PM
 */

class Pdf
{
    function __construct(){
        $CI = &get_instance();
        log_message('Debug','mpdf80 is loaded.');
    }

    function load($param=NULL){
        require_once FCPATH.'vendor/autoload.php';
        return new \Mpdf\Mpdf($param);
    }
}