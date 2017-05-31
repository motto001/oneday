<?php

namespace lib\ell;
defined( '_MOTTO' ) or die( 'Restricted access' );

/**
Amit lehet átalakít ellenőriz a hibát és figyelmeztetéseket logolja
ha nincs hiba vagy javítható és a $beir=true beírja GOB::safeT -be
nem javíttható hibánál a GOB::hibaT['ell']-t false ra állítja 
visszatérési érték az ellenőrzott-átalakítot adat vagy '' ;
 */
class Get_S{
    
public static $hibaTbeir=true;

/**
ha van a $valnévnek előtagja (GET_ ,POS_ ,INV_) akkor aszerint kéri le ha nincs akkor a $par szerint. 
Ha az is üres akkor az alapértelmezés: a POST felülírja a GET-et.
 */    
static public function Data($valnev,$par='',$beir=true)
{
    $tagT=['GET_','POS_','INV_'];
    $tag=substr($valnev, 0,4) ;
   if(in_array($tag, $tagT)){
       $par=substr($valnev, 0,3) ;;
       $valnev=substr($valnev,4);
   }   
    return self::DataPar($valnev,$par);
} 

/**
nem veszi figyelembe az előtagot a $par szerint kéri az adatot.
Ha nincs akkor az alapértelmezés: a POST felülírja a GET-et.
 */    
static public function DataPar($valnev,$par='')
{
    $tagT=['GET_','POS_','INV_'];
    $tag=substr($valnev, 0,4) ;
    if(in_array($tag, $tagT)){
        $valnev=substr($valnev,4);
    }
    switch ($par) {
        case 'GET':
            $value=$_GET[$valnev] ??    '' ;
            break;
        case 'POS':
            $value=$_POST[$valnev] ??  ''  ;
            break;
        case 'INV':
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
static public function Text($valnev,$min=0,$max=2000,$getData='data',$datapar='')
{        $res=true;
        if($getData=='data'){$data=\lib\ell\Get_S::Data($valnev,$datapar);}
        else{$data=\lib\ell\Get_S::DataPar($valnev,$datapar);}
      //  $value= $data; '= &#039;  "= &quot; htmlspecialchars($data, ENT_QUOTES); nem jó!!! mert a < -t is kicseréli
         $value= str_ireplace('\'','&#039;', $data);
         $value= str_ireplace('"','&quot;', $value);
        if($data!=$value){
            //  echo 'val:'.$value;
            \GOB::$logT['alert']['ell'][]=[$_SESSION['userid'],'change_comma',$valnev];
            \GOB::$messageT['alert']['ell'][$valnev][]=['change_comma'];
        }    
        
        $old_value=$value;
        $value= strip_tags($value);
     // echo 'val:'.$value;
     // echo 'old: '.$old_value.'val:'.$value;
        if($old_value!=$value){
            
            \GOB::$logT['alert']['ell'][]=[$_SESSION['userid'],'change_not_allowed_tag',$valnev];
            \GOB::$messageT['alert']['ell'][$valnev][]=['change_not_allowed_tag'];
        
        }

        $lenght=strlen($value);
        if($lenght<$min)
        {
            \GOB::$logT['err']['ell'][]=[$_SESSION['userid'],'ERR_MIN',$valnev];
            \GOB::$messageT['err']['ell'][$valnev][]=['ERR_MIN',['MIN'=>$min]];
           if(self::$hibaTbeir){ \GOB::$hibaT['ell']=false;}
           $res=false;
        }
        if($lenght>$max)
        {
            \GOB::$logT['alert']['ell'][]=[$_SESSION['userid'],'cut_text',$valnev];
            \GOB::$messageT['alert']['ell'][$valnev][]=['cut_text',['Max'=>$max]];
            //if(self::$hibaTbeir){ GOB::$hibaT['ell']=false;}
            $value=substr($value, 0,$max);
          
        }
      if($res){\GOB::$safeT[$valnev]=$value;}   
        return $value;
    }
    




   
static public function regex_cserel($regtext,$parT=[])
    {
    
        foreach ($parT as $nev=>$val){
            $regtext= str_replace('<<'.$nev.'>>', $val, $regtext);
        }
        return $regtext;
    }    
 
    }




