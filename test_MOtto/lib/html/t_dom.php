<?php
namespace test\lib\html;


class T_dom{
//use Dom_data_Find;
	static public function fejlec(){
	    $view=file_get_contents('test/view/testform.html',true);
	    $dataT['input1']='új input 1 value';
	    $dataT['div1']='div1 value';
	    $dataT['text2']='text1 value';
	    $dataT['age']='radio2';
	    $dataT['hiden-1']='hidden1';
	    $dataT['cbox']='checkbox1';
	    
	    $LT['div1']='div1 LT value';
	    $LT['text1']='text1 LT value';
	    $LT['age']='radio2';
		echo "\n T_html::fejlec: ";

	/*	if(OB::res('lib\html\Fejlec',['cpT'=>\GOB::$headT])==$res1){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_HTML']['fejlec']='1';
		}*/	
		
	}
	
}
class T_szotar{
	static public function haveSTR(){
		//$text='< asdfhswfh dat l = "jhg jh " id 2="" id name="" >< ltdat="" >';
		$text='< asdfhswfh dat l = "jhg jh "h     id =""   id name="" >< ltdat="" >';
       // $str='([^a-z A-Z 1-9 " ]*)id([ ]*)=([ ]*?)"([^`]*?)"';
		$str='([]*)id([ ]*)=([ ]*)"([^`]*?)"';
        //$str='([ ]*?)(id|dat)([ ]*?)=([ ]*?)"([^]*?)"';
       // $str='hsw';
		echo  \lib\html\dom\Dom_s::haveSTR($text,$str);
	}
    static public function toStr(){
       $view=file_get_contents('test/view/testform.html',true); 
       $oldT=['text2'=>[
           'hu'=>'fffff',
           'en'=>'',
           'de'=>'gggggggggg',
       ],'text1'=>[
           'hu'=>'text1 placeholder ujjjj',
           'en'=>'hhhhhhhh',
           'de'=>'',
       ]];
       $arr=\lib\html\dom\Dom_s_szotar::toArray($view,['hu','en','de'],$oldT);
       echo \lib\html\dom\Dom_s_szotar::toStr($arr);
    }
    static public function toArray(){
    	$view=file_get_contents('test/view/testform.html',true);
    	$oldT=['text2'=>[
    			'hu'=>'fffff',
    			'en'=>'',
    			'de'=>'gggggggggg',
    	],'text1'=>[
    			'hu'=>'text1 placeholder ujjjj',
    			'en'=>'hhhhhhhh',
    			'de'=>'',
    	]];
    	$arr=\lib\html\dom\Dom_s_szotar::toArray($view,['hu','en','de'],$oldT);
    	//echo \lib\html\dom\Dom_s_szotar::toStr($arr);
    	print_r($arr);
    }
     
    
    static public function getElemT_fromParamT(){
       $html=file_get_contents('test/view/testform.html',true); 
      print_r(\lib\html\dom\Dom_s::getElemT_fromParamT($html, ['lt','ghjlt','ltdat']));

    
    }static public function getParamVal(){
    	$elem='< asdfhswfh id="fghfd"  val="25" gg="gfdf">';
    	$g=\lib\html\dom\Dom_s::getParamVal($elem, 'gg');
    
    	echo $g;
    
    }
    
  
    static public function setParam(){
        $elem='< asdfhswfh id="fghfd"  val="25"/>';
        print_r( \lib\html\dom\Dom_s::setParam($elem, 'gg','juhj',true));
    
    }
    static public function setParamFromT(){
        $elem='< asdfhswfh id="fghfd"  val="25">';
        $dataT=['fghfd'=>'ujvalue'];
        print_r( \lib\html\dom\Dom_s::setParamFromT($elem, 'gg','id',$dataT,true));
    
    }
    static public function setParamFromDataT(){
        $elem='< asdfhswfh dat="fghfd"  >< ltdat="fghfd" >';
        $dataT=['fghfd'=>'ujvalue'];
        print_r( \lib\html\dom\Dom_s::setParamFromDataT($elem,$dataT));
    
    }
    static public function setParamFromLT(){
        $elem='< ltdat="fghfd">';
        $LT=['fghfd'=>'ujvalue','11'=>'11value'];
        print_r( \lib\html\dom\Dom_s::setParamFromLT($elem,$LT));
    
    }
    
    static public function getElemT(){
        $html=file_get_contents('test/view/testform.html',true); 
        print_r( \lib\html\dom\Dom_s::getElemT($html, 'lt|ltdat' ));
    
    }
    static public function getinner(){
    	$html=file_get_contents('test/view/testform.html',true);
    	
    	print_r( \lib\html\dom\Dom_s::getInner($html, '<div lt="">' ));
    
    }
    static public function getLTSelectedT(){
    	$html=file_get_contents('test/view/testform.html',true);
    	 
    	print_r( \lib\html\dom\Dom_s::getLTSelectedT($html ));
    
    }
    static public function getDataSelectedT(){
    	$html=file_get_contents('test/view/testform.html',true);
    
    	print_r( \lib\html\dom\Dom_s::getdataSelectedT($html ));
    
    }
    static public function changeLT(){
    	
    	$LT=['text1'=>'text1 ujvalue',
    	'input1'=>'input1 ujvalue',
    	'label'=>'label ujvalue',	
    	'input1'=>'input1 ujvalue',
    	'hhjh'=>'hhjh ujvalue','link'=>'linkfelirat',
    	'ltdat'=>'cerélt ltdat',
    	'submit'=>'submit ujvalue'		
    	];
    	$view=file_get_contents('test/view/testform.html',true);
    	echo \lib\html\dom\Dom_s::ChangeLT($view, $LT);
    
    } 
    static public function changeData(){
    	 
    	$LT=['text1'=>'text1 ujvalue',
    			'input1'=>'input1 ujvalue',
    			'label'=>'label ujvalue',
    			'input1'=>'input1 ujvalue',
    			'hhjh'=>'hhjh ujvalue','link'=>'linkhref',
    	         'notedat'=>'cerélt notedat',
    			'cbox'=>'checkbox1','age'=>'radio2|radio2' //lehet tömb is!
    	];
    	$view=file_get_contents('test/view/testform.html',true);
    	echo \lib\html\dom\Dom_s::ChangeData($view, $LT,'|');
    
    }
}	
echo "Test_Dom:------------- ";

//T_szotar::changeLT();
//T_szotar::changeData();
//T_szotar::toArray();
//T_szotar::getLTSelectedT();
//T_szotar::getDataSelectedT();
T_szotar::getInner();
//T_szotar::getElemT_fromParamT();
//T_szotar::haveSTR();
//T_szotar::tostr();
//T_szotar::getparamVal();
//T_szotar::getElemT();
//T_szotar::setParam();
//T_szotar::setParamFromT();
//T_szotar::setParamFromDataT();
//T_szotar::setParamFromLT();


//print_r(\lib\html\dom\Dom_s_find::find($view,'data="'));
//print_r(\lib\html\dom\Dom_s_find::find($view,'lt="'));
//print_r(\lib\html\dom\Dom_s_find::lt($view));
//print_r(\lib\html\dom\Dom_s_find::data($view));

/*
$str= json_encode($arr); $str=  str_replace('{','[', $str);
$str=  str_replace(':','=', $str);$str=  str_replace(',',','.PHP_EOL, $str);
echo str_replace('}',']', $str);
*/

//\lib\html\dom\Dom_s_szotar::toStr($arr);

//