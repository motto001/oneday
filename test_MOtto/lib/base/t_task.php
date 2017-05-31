<?php
namespace test\lib\base\task;
//use lib\base\Task;
//use lib\base\Ob_Trt;
class TSK{
//static public $alap=['trt'=>'mod\login\trt\task\alap_trt'];	
static public $alap=['trt'=>'\test\lib\base\task\alap_trt'];	
static public $proba1=['trt'=>'\test\lib\base\task\view_trt','view'=>'test/res/proba1.html','next'=>'proba3'];
static public $proba2=['trt'=>'\test\lib\base\task\view_trt2','view'=>'test/res/proba2.html'];
static public $proba3=['trt'=>'','view'=>'mod/login/view/szerk_passwd.html'];

}
class ADT {
//fontos--------------------------	
public static $task='alap';
/**
a task trait-nek ha nins a tasknak megfelelő funkciója ilyennel kell rendelkezni (felülírható)
 */
public static $resfunc='res';
public static $next='';
public static $view='';
public static $dataT='';
//--------------------------------
public static $modnev='log';//applikációknál nme kell		

}

trait alap_trt{ public function alap()
{	
$this->ADT['next']='proba1';
//echo 'next'.$this->ADT['next'];

}}
trait alap_trt2{ public function alap()
{	
$task=$this->ADT['task'];
$this->ADT['view']=$this->ADT['TSK'][$task]['view'];
	$this->ADT['next']='proba2';
	//echo 'next'.$this->ADT['next'];
}}

trait view_trt{ public function res()
{	
//echo $ADT::$task;	
$task=$this->ADT['task'];
	if(is_file($this->ADT['TSK'][$task]['view']))
	{
		$this->ADT['view']= file_get_contents($this->ADT['TSK'][$task]['view'] ,true);
	}
	else{$this->ADT['view']=$this->ADT['TSK'][$task]['view'];}
	$this->ADT['next']='proba2';
	//echo 'viewtrt'.$this->ADT['next'];

}}
trait view_trt2{ public function res()
{
	$task=$this->ADT['task'];
		$this->ADT['view'].= 'trt2';
		if(isset($this->ADT['TSK'][$task]['next2'])){$this->ADT['next']=$this->ADT['TSK'][$task]['next2'];}
		
	
}}
trait view_trt3{ public function res()
{

	$this->ADT['view']= 'proba3';
	

}}
trait view_trt4{ public function res()
{

	$this->ADT['view'].= 'trt4';
	

}}

echo "\n t_Task:------------- \n";

//$ADT=Task::res(ADT::class,TSK::class);

class test_task{
use \lib\task\trt\Task;
public  $ADT=[];

public function __construct($parT = []){
	$this->ADT = get_class_vars('\test\lib\base\task\ADT');
	$this->ADT['TSK']=get_class_vars('\test\lib\base\task\TSK');
	//$this->setADT($parT);
}
	
}
$ob=new test_task();
$ob->task();
//
//print_r($ob->ADT);
if($ob->ADT['view']=='proba1trt2'){
	echo " ok,";	
}else{echo '!!!,';
		\GOBT::$resT['T_task']['task']='1';
		}
//echo 	$ob->ADT::$view	;
	
TSK::$alap=['trt'=>'\test\lib\base\task\alap_trt2','next'=>'proba3','view'=>'alap'];
TSK::$proba1=['trt'=>'\test\lib\base\task\view_trt','view'=>'pr1'];
TSK::$proba2=['trt'=>'\test\lib\base\task\view_trt2','next2'=>'proba3'];
TSK::$proba3=['trt'=>'\test\lib\base\task\view_trt4'];
	
ADT::$task='alap';
ADT::$modnev='log2';
$ob2=new test_task();
$ob2->task();
echo $ob2->ADT['view'];
if($ob2->ADT['view']=='alaptrt2trt4'){
	echo "  ok,";
}else{echo ' !!!,';
\GOBT::$resT['T_task']['task']='2';
}


