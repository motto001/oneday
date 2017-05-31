<?php
namespace app\login;

class ViewInit
{
static public  function Res($html) {
    $html=\PATH::$MOttoDir.DS.'app'.DS.'login'.DS.'view'.DS.$html;
//echo 'sssss'. $html;
     return file_get_contents( $html,true);
  }  
    
} 



/*
\GOB::$paramT['head']['js']['goref']= <<<js
function goref() {
    var x = document.referrer;
	window.location = x;	
}
js
;
*/