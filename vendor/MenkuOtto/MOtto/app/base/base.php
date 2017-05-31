<?php
namespace app\base;

defined( '_MOTTO' ) or die( 'Restricted access' );

class ADT {
public static $ADT=
[
'jog'=>'noname',
'ellerr'=>true,  // !!! kell az ellnőrzés függő traiteknek (PL.emailküldés) ellenőrző függvény false-ra állítja ha hibát talál
'task'=>'alap', //induló task
'appIDuniq'=>false,
'appID'=>'log',
'view'=>'',
'dataT'=>[],
'SPT'=>[],
'LT'=>[],   
'TRT'=>['View'=>'trt\task\View','Content'=>'trt\mod\Content'] 
//'TSK'=>['alap'=>['TRT'=>['View'=>'trt\task\View','viewF'=>'base.html','Content'=>'trt\mod\Content']]],    
];   


public static function getADT(){
 $content=$_GET['content'] ?? '';
 if(isset($_GET['content'])){self::$ADT['ADT']['content']=$_GET['content'];  }
 if(isset($_GET['contentF'])){self::$ADT['ADT']['contentF']=$_GET['content'];  }
 return self::$ADT['ADT'];   
}

} 

