<?php
namespace lib\base;
defined( '_MOTTO' ) or die( 'Restricted access' );

class Ob_InitMO_S
{
/**
Ha az $ADT['uniq']=true megnézi van e- már GOB::modT-ben regisztrálva ilyen nevű modul.
Ha nincs regisztrálja,ha van indexeli és úgy regisztrálja. 
ADT['uniq']-ot false-ra állítja hogy a construktor már ne csinálja újra
ha nincs megadva getID beáállítja az obNev-re 
 */    
static   public function modReg($ADT)
    {  $uniq= $ADT['uniq'] ?? false;
        if( $uniq)
        {
            $i=0;$vannev=true;
            while($vannev)
            {
                if($i>0){ $ADT['obNev'].=$i;}
                if(\GOB::$modT[$ADT['obNev']])
                {$vannev=true;}else{$vannev=false;}
                $i++;
            }
        }
        
        \GOB::$modT[$ADT['obNev']]=true;
        
        $getId= $ADT['getID'] ?? '';
        if($getId =='') {$ADT['getID'] = $ADT['obNev'];}
        
        $ADT['uniq']=false;
        return $ADT;
    }
    
/**
A parT-t egyesíti az $ADTclass-al (stringel kell megadni,pl.:'\mod\tabla\ADT' )
A modReg-el beállítja a modNev-et és a getID-et, valamint a \GOB::$modT-ben regisztrállja a modult
 */    
  static   public function Res($parT,$ADTclass='')
    {
        if($ADTclass!=''){$ADT = get_class_vars($ADTclass);}    
        $ADT=array_merge ($ADT,$parT);    
        return self::modReg($ADT);
        
    }}



/**
OB_Mo osztály példányosítására és a res függvény(alapesetben _tostring) meghívására való
 */
class OB_Res{
/**
figyelem $classnev névterrel értendő!!! (pl.:lib\base\T_ob)
 OB_Mo osztály példányosítására és a res függvény(alapesetben _tostring) meghívására való
 */
 public function Res($classnev,$parT=[]){
 	$ob=new $classnev($parT);
 	return  $ob->Res($parT);
 }	
}
/**
 a str() egy eval függvénnyel használható  class definícióval tér vissza 
 az ob() egy str()-el gnerált objektummal
 a res() pedig ennek az objektumnak az alap függvénének ($func='Res') visszatérési értékével;
 */
class Ob_TrtS {
/**
evallal futtatható osztály definicióval tér vissza (string)
a traiteket ponosvesszővel kell elválasztani, a végére nem kell! lehet tömb is.
Ha $os sztályt adunk meg az osztály definició annak a gyermeke lesz.
 */
static public function str($classnev,$trt,$os=''){
		$ext='';
		if($os!=''){$ext=' extends '.$os;}
		$res= 'class '.$classnev.$ext.'{ ';
		if(is_array($trt)){
// print_r($trt);
			foreach ($trt as $tr){$res.= ' use '.$tr.'; ';}
		}
		else{$res.= ' use '.$trt.'; public $ADT=[]; ';}
		$res.='}';
		return $res ;
	}	
/**
legenerálja az adott traiteket használó osztályt,(ha az $os  meg van adva annak gyermekeként) 
példányosítja és egy példánnyal tér vissza
a traiteket ponosvesszővel kell elválasztani, a végére nem kell! lehet tömb is.
 */
static public function ob($classnev,$trt,$os='',$ADT=[]){

    if(!class_exists($classnev, false))
    {
        eval(self::str($classnev,$trt,$os));      
    }

	$ob=new $classnev;
	$ob->ADT=$ADT;
	return $ob;
}
/**
legenerálja az adott traiteket használó osztályt,(ha az $os  meg van adva annak gyermekeként) 
példányosítja és a $func() függvény visszatérési értékével tér vissza
a traiteket ponosvesszővel kell elválasztani, a végére nem kell! lehet tömb is.
 */

static public function Res($classnev,$trt,$os='',$ADT=[],$func='Res'){
	$ob= self::ob($classnev,$trt,$os,$ADT);
	return $ob->$func() ;
}
static public function minRes($trt,$ADT=[],$func='Res',$os=''){
    $classnev='';$i=1;
    while ($classnev=='') {
      if(!class_exists('cl'.$i, false)){$classnev='cl'.$i;}   
        $i++;
    }
    $ob= self::ob($classnev,$trt,$os,$ADT);
    return $ob->$func() ;
}

}


/**
Ős osztály. A construktora az initMo($parT) segítségvel feltölti az osztály változókat
a frissit($parT)-el lehet aktualizálni. és egyben uj kimenetet kérni;
 a kimenetet a  __toString() állítja elő az OB::res() gyártófüggvény a res()-t hívja meg 
ami alapesetben a  __toString() -et adja vissza (ha string res-t akarunk elég csak azt felülírni)
 */
class OB_base 
{

	
/**
a $parT-vel feltölti a this változókat
 */
 public function __construct($parT=[])
    {
        $this->initMo($parT);

    }
     
 public function initMo($parT = [])
       {

	        foreach ($parT as $name => $value)
	        {	
	            if(isset( $this->$name)){ $this->$name=$value;}
	
	        }
    	}
    
}
class OB_base_ADT
{
    public $ADT=[];

    /**
     a $parT-vel feltölti a $ADT tömböt
     */
    public function __construct($parT=[])
    {
        $this->initMo($parT);

    }
     
    public function initMo($parT = [])
    {

        foreach ($parT as $name => $value)
        {
            $this->ADT['$name']=$value;

        }
    }

}



