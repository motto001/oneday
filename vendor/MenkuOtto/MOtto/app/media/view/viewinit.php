<?php
namespace app\media\view;

class ViewInit
{
static public  function Res($html) {
    $dir=dirname(__FILE__);
    
     return file_get_contents( $dir.'/'.$html,true);
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