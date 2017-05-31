<?php
namespace lib\html\dom;   

  //pl.: mod\login;
defined( '_MOTTO' ) or die( 'Restricted access' );

class Dom_s{
 //html manipuláló****************************************

static   public function getChangeT($html,$elotag='dat')
{
    $html_minta='/(<.*'.$elotag.'-([^ ]+) *= *"([^"]*)"[^>]*>)([^<]*)/';
   
    $elemek=[];$resT=[];
    
    preg_match_all($html_minta, $html, $elemek);
    $i=0;
//echo $html;
    //print_r($elemek);
    foreach ($elemek[0] as $key=>$elem)
    {  
        $rsT=[];
        $rsT['full']=$elemek[0][$key] ?? ''; // <elem>
        $rsT['elem']=$elemek[1][$key] ?? ''; // <elem>
        $rsT['paramnev']=$elemek[2][$key] ?? ''; //dat-paramnev="paramval" 
        $rsT['paramval']=$elemek[3][$key] ?? '';//(dataT kulcsa)
        $rsT['inner']=$elemek[4][$key] ?? ''; //<elem>value<
        
        if($rsT['paramnev']=='inner')
        {$rsT['value']=$rsT['inner'] ?? '';
        }//<>value< vagy paramnev="value"
        else 
        {$rsT['value']=self::getParamval($rsT['elem'],$rsT['paramnev']);}
        
        $resT[]=$rsT;
        // !!!!!! tesztelés:  echo "elem:".$elemek[1][$key]." |paramnev:".$elemek[2][$key]." |paramertek:".$elemek[3][$key] ." |value:".$value." |full:".$elemek[0][$key]."\n";
    }
    return $resT;		
}

static public function ChangeData($html,$dataT) 
{
    $changeT=self::getChangeT($html,'dat');
//print_r($changeT);
    foreach ($changeT as  $elemT) 
    {
        if(isset($dataT[$elemT['paramval']])){
            if($elemT['paramnev']=='inner')
            {  //echo $elemT['elem'].$dataT[$elemT['paramval']];
                $ujmezo=$elemT['elem'].$dataT[$elemT['paramval']];
               
                //return preg_replace("/".$elem."([^`]*?)".$zarotag."/",$ujmezo, $view);
                 $html= str_replace($elemT['full'],$ujmezo, $html);
             
            }
            else 
            {
              $ujmezo=self::setParam($elemT['elem'],$elemT['paramnev'],$dataT[$elemT['paramval']]); 
               $html= str_replace($elemT['elem'],$ujmezo, $html);
            }
        }
    }
    return $html;
}

//elem manipuláló*********************************************************  
/**
true val tér vissza ha a $textben van $str. $str lehet regex is.
 */
static   public function haveSTR($text,$str) {
	$bool=true;$match=[];
	preg_match('/'.$str.'/', $text, $match);
	if(empty($match[0])){ $bool= false;}
	return $bool;
}


static   public function getParamBool($elem,$param) {
	$res=true;$match=[];
	preg_match('/[^-]'.$param.' *= *"([^"]*)"/', $elem, $match);
	if(empty($match[0])){ $res= false;}
	return $res;
}
    /** 
 tesztelve: vissatérési érték tömb!!!  res['res']=az elem $param paraméterének értéke 
 illetve ha van olyan paraméter a res['bool']=true ha nincs false.
  */  
 static   public function getParamVal($elem,$param) {
		$match=[];  
       preg_match('/[^-]'.$param.' *= *"([^"]*)"/', $elem, $match);
 		$res=$match[1] ?? '';
//print_r($match);
       return $res;
      
    }
 /**
tesztelve: a $elem string $param paraméterét kicseréli $data értékkre 
 forced=true esetén (alap) ha nincs ilyen paraméter csinál
  */ 
 static   public function setParam($elem,$param,$data='',$forced=true) {
  
  preg_match('/[^-]'.$param.' *= *"([^"]*)"/', $elem, $match);
// print_r($match) ;          
 //echo '---'.$match[0];          
     if (empty($match[0])) { 
               if ($forced)
               {
               //	preg_match("/>|\/>/", $elem, $outT);
               //	$veg=$outT[0];
                $ujvalue = ' '.$param .'="'. $data. '" >';
                $elem = preg_replace("/>|\/>/", $ujvalue, $elem);
               }
            } 
            else{
                $ujvalue =' '. $param .'="'. $data. '"';
                //$elem = str_replace( $match[2].'"'.$match[3].'"', $ujvalue, $elem); 
                $elem = preg_replace('/[^-]'.$param.' *= *"([^"]*)"/', $ujvalue, $elem);
              
            } 
      //      echo $elem;
        return $elem;
    }
/**
tesztelve: a setparam -ot használva a $dataT-ből tölti fel $param paramétert.
a $névparam paraméter értéke a $dataT kulcsa
 */    
static   public function setParamFromT($elem,$param='val',$nevparam='name',$dataT,$forced=true) {

        $mezonev =self::getParamVal($elem, $nevparam) ;

        if ($mezonev !='' && isset($dataT[$mezonev])) {
            
            $elem=self::setParam($elem, $param,$dataT[$mezonev],$forced);

        }
        return $elem;
    }
/**
html file-ból veszi ki a névvel ellátott megjegyzések  közé tett view html-t
 */
static   public function getViewFromHTML($html,$nev) {
         
        preg_match('/<!--'.$nev.'-->(.*?)<!--\/'.$nev.'--\>/s', $html, $elemek);
        return $elemek[1];
    }
}