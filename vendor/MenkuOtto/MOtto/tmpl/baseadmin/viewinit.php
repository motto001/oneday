<?php
namespace tmpl\baseadmin;

class ViewInit
{
static public  function Res($html) {
  
$html=\PATH::$MOttoDir.DS.'tmpl'.DS.'baseadmin'.DS.$html; 
 return file_get_contents($html,true);
//echo '-------- viewinit';
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