<?php
namespace app\admin\szallas\view;

class SzallasIni
{
static public  function Res($html) {

\GOB::$paramT['html']['bodyhead']['docread'][]= <<<js

js;
       
        $html=\PATH::$rootDir.DS.'app'.DS.'admin'.DS.'szallas'.DS.'view'.DS.$html;

        return file_get_contents($html,true);
    }

}

