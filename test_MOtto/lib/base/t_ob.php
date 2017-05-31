<?php
namespace lib\base;
use lib;

trait Ob1{ public  function Ob1(){
   return 'ob1'; 
}}

trait Ob2{ public  function Ob2(){
   return  'ob2';
}}
trait Ob3{ public  function Ob3(){

    return $this->ob1().$this->ob2(). $this->ADT['ok'];
}}

echo "\n t_ob:------------- \n";
$adt=['ok'=>'okval'];
$trtT=['lib\base\ob1','neves'=>'lib\base\ob2','lib\base\ob3'];
$res=lib\base\Ob_TrtS::minRes( $trtT,$adt,'ob3');
//echo 'hjafkf='.$res;
if($res=='ob1ob2okval'){	echo " ok,";	
}else{echo '!!!,';
		\GOBT::$resT['T_ob']['minres']='1';
		}


/*
class T_ob extends OB_Mo{
	public $gg='gg';
	public $gT=['gg'];
	public $gTA=['gg'=>'hh'];
	private $pr='gg';
public function getpr(){
	return $this->pr;
}	
public function __toString(){
	return  'tostring';
}
	
}
class T_ob_2 extends OB_Mo{
	public $gg='gg';
	private $pr='gg';
public function __toString(){
	return  $this->gg;
}
	
}

class T_OBb{

	static public function test(){
$parT=['gg'=>'gguj','pr'=>'pruj','nincs'=>'nincs'];
$testob=new T_ob($parT);

		echo 'T_OB::test';

		if($testob->gg=='gguj'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_OB']['test']='1';
		}
		if($testob->getpr()=='gg'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_OB']['test']='2';
		}
	
		if(OB::res('lib\base\T_ob',$parT)=='tostring'){echo 'OK,';}else{
			echo '!!!,';
			\GOBT::$resT['T_OB']['test']='3';
		}
		if(OB::res('lib\base\T_ob_2',$parT)=='gguj'){echo 'OK,';}else
		{echo '!!!,';
		\GOBT::$resT['T_OB']['test']='4';
		}
		
		echo "\n";
	}
	static public function testTomb(){
		$parT=['gT'=>[],'gg'=>'2gg','gTr'=>[],'gTA'=>['gg'=>'bb']];
		$testob=new T_ob($parT);
	
		echo 'T_OB::testTomb';
	
		if($testob->gg=='2gg'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_OB']['testTomb']='1';
		}
		if(is_array($testob->gT) && empty($testob->gT)){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_OB']['testTomb']='2';
		}
	
		if($testob->gTA['gg']=='bb'){echo 'OK,';}else{
			echo '!!!,';
			\GOBT::$resT['T_OB']['testTomb']='3';
		}
		
		$parT=['add_gT'=>['adott'],'gTr'=>[],'add_gTA'=>['gg2'=>'bb']];
		$testob2=new T_ob($parT);
		if($testob2->gT[1]=='adott' && $testob2->gT[0]=='gg'){echo 'OK,';}else{
			echo '!!!,';
			\GOBT::$resT['T_OB']['testTomb']='4';
		}
		
		if($testob2->gTA['gg']=='hh'){echo 'OK,';}else{
			echo '!!!,';
			\GOBT::$resT['T_OB']['testTomb']='5';
		}
		if( $testob2->gTA['gg2']=='bb'){echo 'OK,';}else{
			echo '!!!,';
			\GOBT::$resT['T_OB']['testTomb']='6';
		}
		$parT2=['add_gTA'=>['gg2'=>'cc'],'add_gTA'=>['gg3'=>'dd']];
		$testob2->initMo($parT2);
		if($testob2->gTA['gg']=='hh' && $testob2->gTA['gg2']=='cc' && $testob2->gTA['gg3']=='dd'){echo 'OK,';}else{
			echo '!!!,';
			\GOBT::$resT['T_OB']['testTomb']='5';
		}
		echo "\n";
	}

}

class 
echo "Testob:------------- \n";

T_OBb::test();
T_OBb::testTomb();*/