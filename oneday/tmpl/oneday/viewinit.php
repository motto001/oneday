<?php
namespace tmpl\oneday;
class ViewInit
{
static public  function Res($html) {
  
$html=\PATH::$rootDir.DS.'tmpl'.DS.'oneday'.DS.$html; 
 return file_get_contents($html,true);
//echo '-------- viewinit';
  }  
  
}
