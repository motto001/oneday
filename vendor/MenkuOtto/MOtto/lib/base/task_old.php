<?php
namespace lib\base;
//defined( '_MOTTO' ) or die( 'Restricted access' );


class Task {
	public function __construct($ADT,$TSK,$parT=[]){
		foreach ($parT as $name => $value)
		{if(isset($ADT::$$name)){$ADT::$$name=$value;}}
		//echo $ADT::$var1;
	}
	
public function func($ADT,$TSK,$modnev)
	{
		$func='';
		$task=$ADT::$task;
		if(isset($ADT::$resfunc) && method_exists($modnev,$ADT::$resfunc)){$func=$ADT::$resfunc;}
		if(method_exists($modnev,$task)){$func=$task;}
		if(isset($TSK::${$task}['resfunc']) && method_exists($modnev,$TSK::${$task}['resfunc'])){$func=$TSK::${$task}['resfunc'];}
		if($func==''){\GOB::$hiba['Task'][]='nincs a task trait-nek mghívható funkciója';}
		return $func;
	}
public function next($ADT,$TSK)
	{	$task=$ADT::$task;
	if(isset($TSK::${$task}['next']) ){	$task=$TSK::${$task}['next'];
	}else{$task='';}

	if(isset($ADT::$next)){
		$task=$ADT::$next;
	}
	return $task;
	}
public function modnev($ADT)
	{
		$task=$ADT::$task;
		if(isset($ADT::$modnev) && $ADT::$modnev!=''){$modnev=$ADT::$modnev.$task;}
		else{$modnev='app';}//ha applikációban futtatjuk nem tud több példány létezni
		return $modnev;
	}
	/**
	 ha még nincs,legenerál ehy ADT::$modnev. nevű osztáyt (ha nincs ADT::$modnev vagy ADT::$modnev=''
	 az osztály neve app lesz) ami használja a TSK::$task['trt'] traitet.
	 ugyanilyen névvel példányosítja,
	 ha van $TSK::${$task}['resfunc'] nevű függvénye futtatja azt
	 ha van ADT::$task() nevű függvénye futtatja azt
	 ha nincs akor az ADT::resfunc()-t
	 ha egyik sincs leáll és hibát ír a GOB::hiba['Task'][]-ba
	 a függvények visszatérési értékének az új ADT-nek kell lenni.
	 ezzel hívja meg újra saját magát de a task az  ADT::$next lesz
	 ha nincs akkor TSK::$next ha ez sincs akkor nem hívja meg magát.
	 */
public function res($ADT,$TSK)
	{
		$task=$ADT::$task;
		while ($task!='') {
				
			$trt=$TSK::${$task}['TRT'];
			$modnev=$this->modnev($ADT);
				
			if(!class_exists($modnev, false)){eval(Ob_Trt::str($modnev,$trt));}

			eval('$'.$modnev.'=new '.$modnev.'();');
			$func=$this->func($ADT, $TSK, $modnev);
			if($func=='')
			{$task='';}
			else{
				eval('$ADT=$'.$modnev.'->'.$func.'($ADT,$TSK);');
				$task=$this->next($ADT, $TSK);
			}
			$ADT::$task=$task;
			$ADT::$next='';
		}
		return $ADT;
	}


}

class  ADT{
	 public $var1='aa';
	static public $var2='bb';
}



/* test------- statikus tagot hiába klónozunk
$arr = get_class_vars('lib\base\ADT');
print_r($arr);
$adt1=new ADT();
$adt=clone $adt1;
$parT=['var1'=>'111'];
$ob=new Task($adt,'',$parT);
echo ADT::$var1;
//print_r(ADT::class);
*/
class Task_S {
	
	static public function res($ADT,$TSK,$parT=[]){
	
		$ob=new Task($ADT,$TSK,$parT);
		return $ob->result($ADT,$TSK);
	}
}


