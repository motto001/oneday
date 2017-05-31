<?php
namespace lib\ell;
defined( '_MOTTO' ) or die( 'Restricted access' );


/**
$parT=[];mesagetype='err'; Az üzeneteket a message tömb melyik subtömbjébetegye
par='' lehet tömb is a regex kifejezés vagy kifejezéstömb(paraméterek, hibaüzenet)
value='' az ellenőrizendő szöveg
mezonev='' ha beviteli mezőt ellenőriz annak a neve
 */
class Regx
{   
public $parT=[];
public function __construct($parT)
{
    $this->parT['messagetype']='err';
    $this->parT=array_merge( $this->parT,$parT);

}   
public function regex_cserel($regtext,$parT=[])
 {

    foreach ($parT as $nev=>$val){
        $regtext= str_replace('<<'.$nev.'>>', $val, $regtext);
    }
    return $regtext;
}

public function Res(){
    $res=true;$changeT=[];
    $par=$this->parT['par'];
    if(is_array($par))
    {
        $reg= $par[0];     
        $changeT =$par[2] ?? []; 
    }
    else{
        $reg= $par;
    }

    $regx=\lib\ell\RegexT::$regexT[$reg] ?? $reg;
    $regx=$this->regex_cserel($regx,$changeT);
     
    if (!preg_match($regx,$this->parT['value']))
    {
        $res= false;
        $err=$par[1] ?? $reg;
        $err='ERR_'.$err;
        //$err=\GOB::$LT[$reg] ?? $err;
        
        if(isset($this->parT['mezonev'])){ $changeT['MEZO']=$this->parT['mezonev'];}
        
        \GOB::$messageT[$this->parT['messagetype']][$reg]=$err;
       
        if(!empty($changeT))
        {\GOB::$messageT[$this->parT['messagetype']]['#PAR_'.$reg]=$changeT;}
    }

    return $res;
}
}

class Regx_s
{
   
    static public function res($parT) 
    {
    $ob=new Regx($parT);
    return $ob->Res();
    }
    
    static public function ell($text,$par,$messagetype='err',$mezonev='') 
    {
      $parT['par']=$par;
      $parT['value']=$text;
      $parT['messagetype']=$messagetype;
      $parT['mezonev']=$mezonev;
      $ob=new Regx($parT);
      return $ob->Res();
    }
    static public function ellfromT($text,$parT,$messagetype='err',$mezonev='')
    {
        $res=true;
        foreach ($parT as $par)
        {
          if(!self::ell($text,$par,$messagetype)) {$res=false;}
        }
    return $res;
    }
    
    
}
