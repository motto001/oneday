<?php
defined( '_MOTTO' ) or die( 'Restricted access' );



class GOB
{ 
	private static $userjogT=Array();
/**
mindeféle paraméterek elhelyezése applikációknak ,HTML-nek 
js css og stb betöltése alapértelmezett kulcsok: $headT['head'],$headT['body'],$headT['bodyend']
 a Fejlec_s::ChangeFull() függvény a kulcsoknak megfelelő html cserestringet (pl.:<!--|head|-->)
  cseréli a tömbértékekből generált stringre
   */  
	public static $paramT=[];
	public static $lang=''; 
/**
view bescatoláshoz kellhet de valszeg nem kell(namespace utolsó eleme)
 */	
	public static $app=''; 
	public static $tmpl='';
	public static $tmplNamespace;
	public static $tmplDir='';
	public static $db='';
	public static $html='';
/**
ide regisztrálnak be a appok ha egyedi azonosítöra van szükségük
*/
	public static $appIDT=[];
/**
ide irányítunk minden rendszerkiiratást err,alert,info
 */   
    public static $hibaT=[];
    public static $logT=[];
    public static $messageT=[];
    /**
     tmpl inicializálásra modulok is tehetik ide a szótáraikat ha nem akarják külön betölteni
     lib\html\dom\trt\Dom_HTML_ChangeLT innen tölti fel Aa GOB::$HTML-t AZ ADT['LT']-vel felülrja,kiegészíti
     */
    public static $LT=[];
 /**
ki kell vezetni!! szerepét a $logT veszi át aminek egyike altömbje lesz: $logT['hiba']
  */   
    public static $hiba=true;    
    public static $userT=Array();    
    /**
     * '' (alapértelmezés) az adminok csak saját cikkeiket szerkeszthetik
     * 'kozos' az adminok egymás cikkeit szerkeszthetik
     * 'tulajdonos' Az adminok szerkeszthetnek minden cikket
     */
    public static $admin_mod='';
    
    public static function get_userjog($jogname){
      //  print_r(self::$userjogT);
        if(in_array($jogname,self::$userjogT)){return true;}
        else{return false;}
    }
    public static function set_userjog(){
        self::$userjogT=\lib\jog\Jog::fromGOB();
    }

}



