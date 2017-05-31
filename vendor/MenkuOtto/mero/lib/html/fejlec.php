<?php
namespace lib\html;
use lib\base\OB_base_ADT;
/**
extends:OB_Mo paraméternek a GOB::headT,GOB::bodyT vagy a GOB::bodyendT  tombot kell átadni az 
ide beírandó js css og stb stringel térvissza ha nem adunk meg 
 */
class Fejlec {
//class Fejlec extends OB_base_ADT{
    /*public  $headStr ='<!--|head|-->';
    public  $bodyStr ='<!--|bodyhead|-->';
    public  $bodyendStr ='<!--|bodyend|-->'; */
	public  $tag =
	[
	'css'=>['<style>','</style>'],
	'js'=>['<script>','</script>'],
	'cssfile'=>['<link href="','" rel="stylesheet">'],
	'jsfile' =>['<script src="','"></script>']
	];
	
/**
 nincs visszatérési étéke feltölti a GOB::$html-t $parT-alapján 
 ha a $parT üres akkor a GOB::$paramT alapján . a parT nek a kulcsaival megegyező
 cserestringet cseréli ki a $parT értékéből generált stringre. engedélyezett cserestringek ['head','bodyhead','bodyfoot']
 Pl GOB::$headT['head'] tömbjéből képezett stringel, a GOB::$html  <!--|head|-->
stringjét cseréli ki
 */	
public function ChangeFull($parT=[])
{
    foreach($parT as $csereSTR=>$headT)
    {
        if(in_array($csereSTR, ['head','bodyhead','bodyfoot']))
        {\GOB::$html= str_replace('<!--|'.$csereSTR.'|-->',$this->StrFromArr($headT) ,\GOB::$html);}
	}	
}
public function StrFromArr($parT)
{
		$res='';
		foreach ($parT as $tag_tip=>$paramT)
		{
		    
    		   switch ($tag_tip) 
                {
    		        case 'og':
    		        $res.=$this->og($paramT);
    		            break;
    		        case 'docread':
    		        $res.=$this->docread($paramT);
    		            break;  
    		        case 'meta':
    		        $res.=$this->meta($paramT);  
    		            break;    
    		         case 'jsGOBstr':
    		         $res.=$this->jsGOBstr($paramT); 
    		            break;   
    		         case 'jsGOBnum':
    		         $res.=$this->jsGOBnum($paramT);
    		            break;
    		     
    		        default:
    		        $paramT2= array_unique($paramT);
    				// print_r($paramT);
    				foreach ($paramT2 as $param)
    				{
    					$res.=$this->tag[$tag_tip][0].$param.$this->tag[$tag_tip][1];
    				}
        	   }
		   
               		      
		}
		return $res;
}

	/**
globális js string változókat deklarál. A $paramT assocaiativ
	 */
 public function jsGOBstr($paramT){
		$res=' <script> ';
		foreach ($paramT as $nev=>$value){
				
			$res.=' var '.$nev.'="'.$value.'" ; ';
		}
		return $res.' </script> ';
	}
	/**
 globális js numerikus változókat deklarál. A $paramT assocaiativ
	 */	
 public function jsGOBnum($paramT){
		$res=' <script> ';
		foreach ($paramT as $nev=>$value){
	
			$res.=' var '.$nev.'='.$value.' ; ';
		}
		return $res.' </script> ';
	}
	
	/**
	a paramT első értéke a meta name (description,generator) második a content
	pl.:[title,Motto] tobb ugyanolyan tipus is lehet (image) ;
	 */
 public function meta($paramT){
		$res='';
		foreach ($paramT as $paramR){
			
			$res.='<meta name="'.$paramR[0].'" content="'.$paramR[1].'" />';
		}
		return $res;
	}
	
	/**
 a paramT első értéke az ogtipus (type,title,description,image) második az érték
 pl.:[title,Motto] tobb ugyanolyan tipus is lehet (image) ;
	 */
 public function og($paramT){
		$res='';
		foreach ($paramT as $paramR){
				
			$res.='<meta property="og:'.$paramR[0].'" content="'.$paramR[1].'" />';
		}
		return $res;

	}
 public function docread($paramT){
		$res="<script> $( document ).ready(function(){";

		foreach ($paramT as $param){

			$res.=$param;
		}
		$res.="});</script>";
		return $res;
	}
}





class Fejlec_s{
public static function  ChangeFull($parT=[])
{
    if(empty($parT)){ $parT=\GOB::$paramT['html'] ?? [];}
    $ob=new Fejlec();
    $ob->ChangeFull($parT);
}
public static function  StrFromArr($headT)
{
    $ob=new Fejlec();
  return   $ob->StrFromArr($headT);
}
    
}
//teszt------------------------

/*
 class GOB{
 public static $head=[];
 }
 GOB::$head['jsfile'][]='hh/jhj.js';
 GOB::$head['jsfile'][]='hh/jhj.js';
 GOB::$head['jsfile'][]='hh/jhjvbfcgbfg.js';
 GOB::$head['cssfile'][]='hh/jhjvbfcgbfg.cs';
 GOB::$head['js'][]='function(){fsdfgsdf;}';
 GOB::$head['js'][]='function ggg(ffff){}';
 GOB::$head['css'][]='.ff{width:32;height:32;}';
 GOB::$head['docread'][]='var h=$(\'#id\').val();';
 echo Aktival::res(GOB::$head);
 */