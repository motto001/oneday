<?php
namespace app\admin\slider\view;

class SliderIni
{
static public  function Res($html) {
if($html=='sorrend.html'){
\GOB::$paramT['html']['head']['jsfile'][]= 'vendor/MenkuOtto/MOtto/vendor/jquery/1.11.2.jquery-ui.min.js';    
    
}

       
        $html=\PATH::$rootDir.DS.'app'.DS.'admin'.DS.'slider'.DS.'view'.DS.$html;

        return file_get_contents($html,true);
    }

}

