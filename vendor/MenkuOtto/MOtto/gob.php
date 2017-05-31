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
view bescsatoláshoz kellhet de valszeg nem kell(namespace utolsó eleme)
 */	
	public static $app=''; 
	public static $tmpl='';
	public static $tmplNamespace; //ki kell vezetni
	public static $tmplDir='';  //ki kell vezetni
	public static $db='';
	public static $html='';
	/**
ide regisztrálnak be a appok ha egyedi azonosítöra van szükségük
	 */
	public static $appIDT=[];
/**
minden amit logolni kell hibák:$logT['hibaT']
 */	
    public static $logT=[];
 /**
ide irányítunk minden rendszerkiiratást err,alert,info
 */     
    public static $messageT=[];
    public static $LT=[];
 /**
kritikus hiba a program futását meg kell állítani!
  */   
    public static $hibaT=[]; 
/**
ellenőrzött felhasználói adatok azz ellenőrző függvények ide írják be
 */    
    public static $safeT=[];
/**
item listák apponként
 */    
    public static $itemT=[];
/**
item adatok apponként
 */     
    public static $itemR=[];
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

GOB::$hibaT['ell']=true;

