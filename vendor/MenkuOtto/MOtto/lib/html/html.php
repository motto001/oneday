<?php
namespace lib\html;

defined( '_MOTTO' ) or die( 'Restricted access' );
class html{
	/**
Ha az aktuális templét gyökerében van a pathban megadott file (filenevet kiveszi a pathból) akkor annak ha nincs akkor a $path-ban megadott 
úvonalon lévő  file tartalmával tér vissza(string)
	 */
static public function 	get_Tmpl($path){
	$html='';
	$dirB='tmpl/'.\GOB::$tmpl;if(substr($dirB, -1)!='/'){$dirB.='/';}
	$filename=pathinfo($path ,  PATHINFO_BASENAME);
	//echo $filename;
	if(is_file($dirB.$filename)){$html= file_get_contents($dirB.$filename, true);}
	else{$html= file_get_contents($path, true);}
	return $html;
}
	/**
Ha az aktuális templétben mod/$modname könyvtárában van ilyen  file (filenevet kiveszi a pathból) akkor annak ha nincs akkor a $path-ban megadott 
úvonalon lévő file tartalmával tér vissza(string)
	 */
static public function 	get_modTmpl($path,$modname){
	$html='';
	$dirB='tmpl/'.\GOB::$tmpl;if(substr($dirB, -1)!='/'){$dirB.='/';}
	if(substr($modname, -1)!='/'){$modname.='/';}
	$dirB.='mod/'.$modname;
	$filename=pathinfo($path ,  PATHINFO_BASENAME);
	if(is_file($dirB.$filename)){$html= file_get_contents($dirB.$filename, true);}
	else{$html= file_get_contents($path, true);}
	return $html;
}
}
