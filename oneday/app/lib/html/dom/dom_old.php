<?php
namespace lib\html\dom;   

  //pl.: mod\login;
defined( '_MOTTO' ) or die( 'Restricted access' );

class Dom_s{
 //html manipuláló****************************************
 /**
A getElemT első elemével tér vissza (string)
  */   
static   public function getElem($html,$param,$value) {
    
        return self::getElemT($html,$param,$value)[0];
    }  
 /**
A $htm stringből egy tömbbe gyűjti $param parméter $value értékével rendelkező elemeket
$param stringben több paraméter is megadhatunk|-vel elvállasztva pl.: 'lt|ltdat'
ha nem adunk meg $valuet az osszes $param -al rendelkező elemet kigyűjti
ha üreset adunk meg csak az üreseket. tesztelve 
  */   
 static   public function getElemT($html,$param,$value='([^<]*?)') {

        preg_match_all('/\<([^>]*?)([<" ])(' . $param . ') *= *"'.$value.'"([^<]*?)\>/', $html, $elemek);
        return $elemek[0];
    }
static   public function getViewFromHTML($html,$nev) {
         
       preg_match('/<!--'.$nev.'-->(.*?)<!--\/'.$nev.'--\>/s', $html, $elemek);
        return $elemek[1];
    }
static   public function getLTSelectedT($html){
  $elemT=  self::getElemT($html,'lt|ltdat');$res=[];
  foreach ($elemT as $elem) {
  	$value=self::getParamVal($elem,'placeholder');
    $nev=self::getParamVal($elem,'lt|ltdat');
    if(self::getParamVal($elem,'type')=='text'){$type='placeholder';}
    else if(in_array(self::getParamVal($elem,'type'),['button','submit']))
    {$type='button'; $value=self::getParamVal($elem,'value');   }
   	else if(self::haveSTR($elem,'<textarea')){$type='placeholder';}
   	else if(self::haveSTR($elem,'<!--')){
   		$type='notes';
   		$value=self::getInner($html,$elem,$zarotag='<!');
   	}
    else{$type='inner';
    $value=self::getInner($html,$elem);
    } 
   $res[]=['type'=>$type,'val'=>$value,'elem'=>$elem,'nev'=>$nev];
  }
  return $res;
}

static   public function getDataSelectedT($html){
	$elemT=  self::getElemT($html,'dat|ltdat');$res=[];
	foreach ($elemT as $elem) {
		$value=self::getParamVal($elem,'value');
		$nev=self::getParamVal($elem,'dat|ltdat');
		if(self::haveSTR($elem,'<input')){$type='input';
		
			if(in_array(self::getParamVal($elem,'type'),['radio','checkbox']) )
			{$type='checked';}
		
		}
		else if(self::haveSTR($elem,'<!--')){
			$type='notes';
			$value='';
		}
		else if(self::getParamBool($elem,'href')){
			$type='href';
			$value=self::getParamVal($elem,'href');
		}
		else if(self::getParamVal($elem,'type')=='submit'){
		    $type='submit';
		    $value='';$nev='task';
		}
		else{$type='inner';
		$value=self::getInner($html,$elem);
		}
		$res[]=['type'=>$type,'val'=>$value,'elem'=>$elem,'nev'=>$nev];
	
	}
	//print_r($res);
	return $res;		
}
/**
 //A $zarotagot '<' ki lehet cserélni (pl.:<!--valami-->) ha komplet dom-ot akarunk lecserélni
 */
static   public function changeInner($view,$elem,$data,$zarotag='<'){
	$ujmezo=$elem.$data;
    $inner=self::getInner($view,$elem,$zarotag);
	$csere=$elem.$inner;
	//return preg_replace("/".$elem."([^`]*?)".$zarotag."/",$ujmezo, $view);
	return str_replace($elem,$ujmezo, $view);
}
/**
nem használt csak egy sort vált ki
 */
static   public function ChangeElem($view,$elem,$ujelem){
	return $view= str_replace($elem,$ujelem, $view); 
}

/**
 A $view html string lt vagy ltdat parméterrel rendelkező elemeit kiceséli a $LT alapján.
 az elem lt vagy ltdat éréke a $LT kulcsa
 az elemeket a getLTSelectedT()-el válogtaja ki
 az input tipusú elemek placeholder értékét változtatja meg,(inputmezo,textarea..)
 az inner tipusú elemek innerhtmljét cseréli ki.(<span>, <div> <a>.. )
a button tipusú elemek valaue paraméterét cseréli ki
 */
static   public function ChangeLT($view,$LT=[]){
$elemT=self::getLTSelectedT($view);
foreach ($elemT as $elem) 
{

	if(isset($LT[$elem['nev']]))
	{
		switch ($elem['type']) {
		    case 'notes':
		        $view=self::changeInner($view,$elem['elem'],$LT[$elem['nev']],'<!');
		        break;
		    case 'button':
		    	$view=self::changeInner($view,$elem['elem'],$LT[$elem['nev']]);
		     	//$ujelem=self::setParam($elem['elem'], 'value',$LT[$elem['nev']]);
		    	//$view= str_replace($elem['elem'],$ujelem, $view);
		        break;
		    case 'placeholder':
		    	
		    	$ujelem=self::setParam($elem['elem'], 'placeholder',$LT[$elem['nev']]);
		 		$view=str_replace($elem['elem'],$ujelem, $view);      
		        break;
		    case 'inner':
		    	$view=self::changeInner($view,$elem['elem'],$LT[$elem['nev']]);
		        break;
		}
	}
}
return  $view;
	
}
/**
A $view html string dat vagy ltdat parméterrel rendelkező elemeit kiceséli a $dataT alapján.
 az elem dat vagy ltdat éréke a $dataT kulcsa
 az elemeket a getDataSelectedT()-el válogtaja ki
 az input tipusú elemek value értékét változtatja meg,(inputmezo,)
 a chcked tipusúak checked paraméterét változtaja checkedre (radio, checkbox)
 	Ezek értékét a dataT-.ben mglehet adni stringként  |-vel tagolt stringként vagy tömbként
 	ha a $dataTchar='' nem használ tömböt a checked elemnél.
 az inner tipusú elemek innerhtmljét cseréli ki.(textarea,<span>, <div> <a>.. )
 */
static   public function ChangeData($view,$dataT,$dataTchar='|'){
	$elemT=self::getDataSelectedT($view);
	foreach ($elemT as $elem)
	{
		
		if(isset($dataT[$elem['nev']]))
		{
			$data=$dataT[$elem['nev']];
		switch ($elem['type']) {
			    case 'submit':
			        
			        $ujelem=self::setParam($elem['elem'], 'name',$data);
			        $view= str_replace($elem['elem'],$ujelem, $view);
			      break;
			        	 
				case 'notes':
	
					$view= str_replace('<!-- dat="'.$elem['nev'].'" -->',$data, $view);
					break;
				case 'input':
				    $ujelem=self::setParam($elem['elem'], 'value',$data);
				   // print_r($data);
				  // echo $ujelem;
				    $view= str_replace($elem['elem'],$ujelem, $view);	   
				    break;
				case 'inner':
					
					$view=self::changeInner($view,$elem['elem'],$data);
					break;
				case 'href':
					
				$ujelem=self::setParam($elem['elem'], 'href',$data);
				$view= str_replace($elem['elem'],$ujelem, $view);
				break;	
				case 'checked':
					
				if($dataTchar!=''){
			
					if(!is_array($data)){$data=explode($dataTchar,$data);}
					if(in_array($elem['val'], $data))
					{$ujelem=self::setParam($elem['elem'], 'checked','checked');
					$view=str_replace($elem['elem'],$ujelem, $view);}
						
				}
				else{
					if($elem['val']==$data)
					{$ujelem=self::setParam($elem['elem'], 'checked','checked');
					$view=str_replace($elem['elem'],$ujelem, $view);}
				}
				break;
			}

		}
	}
	return  $view;

}

static   public function ChangeDataPar($view,$dataT)
{
    $elemT=  self::getElemT($view,'dat|ltdat');
    foreach ($elemT as $elem) 
    {
       // echo $elem.'---------';
       //$oldelem=$elem;
       $dat=self::getParamVal($elem,'dat');
       //
      // $datT= explode(',',$dat);
       //foreach ($datT as $dt) 
      // {
           $dtT=explode('|',$dat);
           $param=$dtT[0];

           $key=$dtT[1] ?? ' ';
           
           $value=$dataT[$key] ?? '';
 // echo $param.'--' .$key.'---'.$value.'||||';
           //A zárótagot '<' ki lehet cserélni (pl.:<!--valami-->) ha komplet dom-ot akarunk lecserélni
           if($param=='inner')
           {
               $view= self::changeInner($view,$elem,$value,'<');
           }
           else 
           {
//echo'$param:'.$param.', $value:'.$value;
            $ujelem=self::setParam($elem,$param,$value,true) ;  
           // $ujelem='ujelem';
            $view=str_replace($elem,$ujelem, $view);
           }
       //}
       
    }
  //  echo 'oooooooooo';
 return $view;   
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
static   public function getInner($html,$elem,$zarotag='<') {
	$match=[];
	$val =self::getParamVal($elem, 'dat');
	//preg_match('/'.$elem.'([^`]*?)'.$zarotag.'/', $html, $match);
	preg_match('/dat="'.$val.'"([^`]*?)>([^`]*?)'.$zarotag.'/', $html, $match);
	//if(empty($match[0])){ $bool= false;}
	//echo $match[0];
	//print_r($match);
	return $match[1] ?? '';
}

static   public function getParamBool($elem,$param) {
	$res=true;$match=[];
	preg_match('/([<" ])('.$param.') *= *"([^`]*?)"/', $elem, $match);
	if(empty($match[0])){ $res= false;}
	return $res;
}
    /** 
 tesztelve: vissatérési érték tömb!!!  res['res']=az elem $param paraméterének értéke 
 illetve ha van olyan paraméter a res['bool']=true ha nincs false.
  */  
 static   public function getParamVal($elem,$param) {
		$match=[];
       preg_match('/([<" ])('.$param.') *= *"([^`]*?)"/', $elem, $match);
 		$res=$match[3] ?? '';
 		//print_r($match);
       return $res;
      
    }
 /**
tesztelve: a $elem string $param paraméterét kicseréli $data értékkre 
 forced=true esetén (alap) ha nincs ilyen paraméter csinál
  */ 
 static   public function setParam($elem,$param,$data='',$forced=true) {
  
            preg_match('/([<" ])('.$param .' *= *)"([^`]*?)"/', $elem, $match);
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
                $ujvalue = $param .'="'. $data. '"';
                //$elem = str_replace( $match[2].'"'.$match[3].'"', $ujvalue, $elem); 
                $elem = preg_replace('/'.$param.'="([?]*)"/', $ujvalue, $elem);
              //  $elem = preg_replace('/'. $param .'="([^`]*?)"/', $ujvalue, $elem);
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
 tesztelve: a setParamFromT -öt használva a $dataT-ből tölti fel val paramétert.
 a  $dataT kulcsát a dat (ha van) vagy ltdat parméterből veszi
 */
static public function setParamFromDataT($elem,$dataT,$forced=true){
        $elem= self::setParamFromT($elem, 'val','ltdat',$dataT,$forced);
        return  self::setParamFromT($elem,'val','dat',$dataT,$forced);
    }
    
/**
 tesztelve: a setParamFromT -öt használva a $LT-ből tölti fel placeholder paramétert.
 a  $dataT kulcsát az lt (ha van) vagy ltdat parméterből veszi
 */    
static public function setParamFromLT($elem,$LT,$forced=true){
        $elem= self::setParamFromT($elem, 'placeholder','ltdat',$LT,$forced);
        return self::setParamFromT($elem,'placeholder','lt', $LT,$forced);
    }
    
}
 class Dom_s_szotar{

    static public function toStr($langT)
    {
       $text=PHP_EOL.'$langT=[';
   
    foreach ($langT as $key=>$valT ){
      
      $text.=PHP_EOL."'".$key."'=>[";  
       // if(strlen("Hello")>50){$text.=PHP_EOL;}
       foreach ($valT as $lang=>$value) {
        $text.=PHP_EOL."'".$lang."'=>'".$value."',"; 
       }
     $text.=PHP_EOL."],";
    }
    $text=substr($text, 0, -1) ;
    $text.=']';
    return  $text;
    }
    static public function toArray($view,$langT=['hu','en','de'],$oldT=[])
    {
      $ltelemT= \lib\html\dom\Dom_s::getLTSelectedT($view);
      $resT=[];
      foreach ($ltelemT as $elemT) {    
      	$nev=$elemT['nev'];
      	$value=$elemT['val'];
              foreach ($langT as $lang){
                  $ertek='';
                  if(isset($oldT[$nev][$lang])){$ertek=$oldT[$nev][$lang];}
                  if($lang==$langT[0] && !empty($value)){$ertek=$value;} 
                    $resT[$nev][$lang]=$ertek;   
              }

      }
        return $resT; 
    }    
}

