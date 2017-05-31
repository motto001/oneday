<?php
namespace lib\tomb;
defined( '_MOTTO' ) or die( 'Restricted access' );
class Param{
    static public function getFromADT($ADT,$paramId='',$task='',$taskid='')
    {
       /*
        $parT=$ADT['paramT'][$namespace] ?? [];
        $taskparT=$ADT['TSK'][$task]['paramT'][$namespace] ?? [];
        $parT=array_merge($parT,$taskparT);*/
        
        $parT=$ADT['paramT'][$paramId] ?? [];
        $taskparT=$ADT['TSK'][$task]['paramT'][$paramId] ?? [];
        
print_r($ADT); echo '---------';
        $parT=array_merge($parT,$taskparT);
        /*
        //egyedi paraméterek-------------------------------------
         if($appid!=''){$parT['appID']=$appid;}
         
        $appIDparT=$ADT['paramT']['appID'] ?? [];
        $parT=array_merge($parT ,$appIDparT);
         
        $task_appIDparT=$ADT['TSK'][$task]['paramT']['appID'] ?? [];
        $parT=array_merge($parT ,$task_appIDparT);
          
        if($taskid!=''){$parT['taskID']=$taskid;}*/
        return $parT;
    }
}