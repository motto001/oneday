<?php
namespace app\admin;
defined( '_MOTTO' ) or die( 'Restricted access' );

class ADT{
 static  public $ADT=[
'task'=>'alap',    
'view'=>'probaview',
'viewF'=>'base.html', 
'view_iniclass'=>'ViewInit', //ha van az aktuális tmpl-ben onnan ha nincs az app könyvtárbol tölti be    
'content_iniclass'=>'ViewInit',
 'TSK'=>[
'alap'=>['TRT'=>['Alap'=>'app\omni\trt\Alap']],
'nyito'=>['TRT'=>['View'=>'trt\task\View','Content'=>'trt\mod\Content'],'contentF'=>'nyito.html']
//'kilepform'=>['TRT'=>['View'=>'trt\task\View','Change_taskname'=>'app\login\trt\Change_taskname'],'view_file'=>'kilep_form.html'],
//'kilep'=>['TRT'=>['Kilep'=>'app\login\trt\task\Kilep'],'next'=>'alap'],
//'regment'=>['TRT'=>['Save_Reg'=>'app\login\trt\task\Save_Reg'],'mentmezoT'=>['fajtaid','nev','kep','intro','text'],
 //                   'next'=>'alap']
 ]
 ]; 
public static $TRT=
[
    //'SetTask'=>'trt\Task_ADT_SetTask',
    'Task'=>'trt\Task',
    'ChangeApp'=>'trt\Dom_ChangeApp'
];
}


ADT::$paramT['Ikon_ClikkSor']['getID']='task';
ADT::$paramT['Ikon_ClikkSor']['ikonsorT']=[];
//ADT::$paramT['Ikon_ClikkSor']['glyph']=true;
ADT::$paramT['Tabla']['dataszerkT']=['id'=>['nocim'=>true,'func'=>'eyeLink','funcEvalparam'=>'index.php?app=admin&iniF=mod&mod=tab_email&emailid=\'.$rekord["id"].\'&key=mailid'],'cim'=>['func'=>'listaLink','funcEvalparam'=>'index.php?app=admin&iniF=mod&mod=tab_emailcim&emailid=\'.$rekord["id"].\''],'subject'=>[],'res'=>[],'datum'=>[]];
ADT::$paramT['Pagin']['limit']='10';
\GOB::$tmpl='admin';
ADT::$LT['lapcim']='Elküldött levelek';

