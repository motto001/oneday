<?php
namespace app\icon;
//use app\icon\ADT;

defined( '_MOTTO' ) or die( 'Restricted access' );
class Iconsor_ADT
{ 
//public static $ADT=[]; 

public static function getADT(){
\app\icon\Icon_ADT::initADT(); 
$ADT=\app\icon\Icon_ADT::$ADT;
 $ADT['iconsorT']=[];
 //$ADT['iconsorT']=['new','edit','pub','unpub','del'=>['type'=>'task_del']];
 $ADT['TRT']=['Icon_Sor'=>'app\icon\trt\Icon_Sor'];//print_r($ADT);
// $ADT['iconDir']=\lib\base\File::pathD($ADT['iconDir']);
// $ADT['size']='28';$ADT['labelType']='simple';
 return $ADT; 
}
}   

class Ikonsor_S
{ 
public  static function simple($iconsorT,$paramT=[]){
             $paramT['iconsorT']=$iconsorT;
            return \App_s::Res('icon\iconsor',$paramT);
    }
public  static function Res($paramT=[]){
            return \App_s::Res('icon\iconsor',$paramT);
    }
}