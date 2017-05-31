<?php
namespace app\media;

class ADT{
static  public $ADT=[
 'jog'=>'user',    
'feltolt_mezo'=>'fileToUpload',
'user_rootdir'=>'images/user',
'admin_rootdir'=>'images',
'dir'=>'',
'src_torol'=>'res/ico/16/torol.png',
'hidden_dirs'=> ['62','share','thumb'],
'view_filetipus'=> ['jpg','jpeg','gif','png'], //ha üres mindent enged
//---------------------------------
'ellerr'=>true,
'appIDuniq'=>false,    
'appDir'=>'app/media',
'task'=>'alap',
'tablanev'=>'media',
'appID'=>'med',
'view'=>'',
//'paramT'=>['icon'=>['size'=>'68']] ,  
'dataT'=>[],
'SPT'=>[],
'LT'=>[]]  ; 
public static $TRT=
[
    'AppIni'=>'app\media\trt\task\Alap_ini',
    'SetTask'=>'trt\Task_ADT_SetTask',
    'Task'=>'trt\Task'
    // 'ChangeData'=>'trt\Dom_ChangeData',
   // 'ChangeApp'=>'trt\Dom_ChangeApp'
];
static  public $TSK=[
    'alap'=>['TRT'=>['Alap'=>'\app\media\trt\task\Alap']],
    'upload'=>['TRT'=>['Upload'=>'\app\media\trt\task\Upload']],
    'del'=>['TRT'=>['Del'=>'\app\media\trt\task\Alap_Del']],
    'lista'=>['TRT'=>['Lista'=>'\app\media\trt\task\Alap_Lista']],
    'newdir'=>['TRT'=>['Newdir'=>'\app\media\trt\task\Alap_Newdir']],
    'dirchange'=>['TRT'=>['Dirchange'=>'\app\media\trt\task\Alap_Dirchange']]
];
}
