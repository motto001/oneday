<?php
namespace lib\ell;
defined( '_MOTTO' ) or die( 'Restricted access' );


class Ell_LT
{
    static public $baselang='hu';
	static public $LT=[
	      'hu'=>[
	            '#'=>'a <<MEZO>> mező ',
	            'ERR_SZAM'=>'# csak szám lehet!', //pozitív vagy negativ szám tizeds tört is lehet
	            'ERR_SZAM_POZ'=>'# csak pozitiv szám lehet!', //pozitív szám tizedes tört is lehet
	            'ERR_EGESZ'=>'# csak egész szám lehet!', //pozitív vagy negatív egész szám
	            'ERR_EGESZ_POZ'=>'# csak pozitív egész szám lehet!', //
	            //text----------------------
	            'ERR_ENG_SZO_KIS'=>'# csak angol ABC kisbetűit tartalmazhtaja valamint számokat.Szóköz sem lehet!',
	            'ERR_ENG_SZO'=>'# csak angol ABC kis és nagybetűit tartalmazhtaja valamint számokat.Szóköz sem lehet!',  // 1 ha csak angol kis és nagybetű és szám van benne szóköz sem lehet
	            'ERR_ENG_TOBB_SZO'=>'# csak angol ABC kis és nagybetűit tartalmazhtaja valamint számokat és szóközt!',  //csak angol kis és nagybetű szám és szóköz van
	            'ERR_ENG_TEXT'=>'csak angol ABC kis és nagybetűit tartalmazhtaja valamint számokat és szóközt és !?() karaktereket',//1 ha csak angol kis és nagybetű és szám szóköz és !?().:
	
	            'ERR_MIN'=>'#nek minimum <<MIN>> karakternek kell lennie!',
	            'ERR_MAX'=>'# maximum <<MAX>> karakternek lehet!',
	            'ERR_HU_SZO_KIS'=>'# csak a Magyar ABC kisbetűit tartalmazhtaja valamint számokat.Szóköz sem lehet!',
	            'ERR_HU_SZO'=>'# csak a Magyar ABC kis és nagybetűit tartalmazhtaja valamint számokat.Szóköz sem lehet!',  // eng_szo plusz ékezetesek
	            'ERR_HU_TOBB_SZO'=>'# csak a Magyar ABC ABC kis és nagybetűit tartalmazhtaja valamint számokat és szóközt!', //eng_tobb_szo plusz ékezetesek
	            'ERR_HU_TEXT'=>'csak a Magyar ABC ABC kis és nagybetűit tartalmazhtaja valamint számokat és szóközt és !?() karaktereket',//ures stringnél is hibát jelez!!!
	            'ERR_MAIL'=>'nem érvényes emailcím',//1 ha email
	            //tesztelve---------------
	            //tagado 1 (true) az értéke ha megfelel a mintának, hogy a hiba legyen tagadni kell(!preg_match();)
	            'ERR_MIN_MAX_UJ'=>'/^.{#nek minimum <<min>>,maximum <<max>> karaktert kell tartalmaznia! ',//magyar karaktereket is figylembe veszi
	            'ERR_MIN6_MAX20'=>'#nek minimum 6,maximum 20 karaktert kell tartalmaznia!',//jelszónál pl
	             
	             
	            //'MIN_MAX_UJ' =>'/^([a-záéíóöőúüűA-ZÁÉÍÓÖŐÚÜŰ0-9.,?!]){<<min>>,<<max>>}$/siu',
	            //kereso------------------------
	            'DIV'=>'#<div[^>]*>(.*?)</div>#', //le kell ellenőrizni
	            'DIV_CLASS'=>'/<div class=\"main\">([^`]*?)<\/div>/'     
	  ]  ]  ;
}
/**
az LT tömböt a construktor tölti fel ha a lang osztály működik felülírja
 */
class Ell{
    
public $val='';	
public $mezonev='';
public $ADT=[];	
public function __construct($ADT) 
{
    $this->ADT=array_merge( $this->ADT,$ADT);
}

public static function getSendedValue($valnev)
{
    switch (substr($valnev, 0,4)) {
        case 'GET_':
            $valnev=substr($valnev,4);
            $value=$_GET[$valnev] ??    '' ;
            break;
        case 'POS_':
            $valnev=substr($valnev,4);
            $value=$_POST[$valnev] ??  ''  ;
            break;
        case 'INV_':
            $valnev=substr($valnev,4);
            $value=$_POST[$valnev] ??  ''  ;
            $value=$_GET[$valnev] ??    $value ;
            break;
        default:
            $value=$_GET[$valnev] ??    '' ;
            $value=$_POST[$valnev] ??   $value ;
            break;
    }
    if(is_array($value)){$value =implode('|', $value);}  
  return $value;  
}
public  function regx($parT)
{
    return Regx_s::ellfromT($this->val, $parT,'err', $this->mezonev);
    
}
public  function Res()
{	
$this->ADT['SPT']=[];  
$task=$this->ADT['task'];
$ellT=$this->ADT['TSK'][$task]['ELL'] ?? [];
$res=true;
if(empty($ellT)){$this->ADT['SPT']=$_POST; }
else
{
foreach ($ellT as $valnev=>$param)
{
//echo $valnev.'-----------------------------</br>';
    $resF=true;    
    $this->val=self::getSendedValue($valnev);
    $this->mezonev=$valnev;

    	foreach ($param as $func=>$parT)
    	{
//echo 	$func.'(';
//print_r($parT);
    		if(!$this->$func($parT))
    		{ 
    		    $this->val='';
    		    $res=false;
    		    $this->ADT['ellerr']=false;
    		}
           		
    	}

	$this->ADT['SPT'][$valnev]=$this->val;

}}
return $res;
}}


class Ell_S{
    
    static public function Res($parT) 
    {   $res=[];
        $trt=$parT['Ell_TRT'] ??[];
        if(empty($trt))
        { $ob=new  Ell($parT);}
        else{
         eval(\lib\base\Ob_TrtS::str('Ellres', $trt,'\lib\ell\Ell')) ;
         //echo \lib\base\Ob_TrtS::str('Ellres', $trt,'\lib\ell\Ell');
          $ob=new  \Ellres($parT);
       }
       $res['bool']=$ob->Res();
       $res['ADT']=$ob->ADT;
       return $res;
        
    } 
}



