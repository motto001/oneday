<?php
namespace app\mod;
defined( '_MOTTO' ) or die( 'Restricted access' );

//$loginTRT['SetLT']='\lib\lang\trt\\'.\CONF::$LangMode.'\\'.\CONF::$LangForras.'\Set_SetLT';
$TRT['SetLT']='\lib\lang\trt\single\tomb\Set_SetLT';
$TRT['GetTask']='\lib\task\trt\Task_PG_GetTask';
//$TRT['GetJog']='\lib\task\trt\Task_PG_GetTask';
$TRT['Task']='\lib\task\trt\Task_app';
$TRT['ChangeLT']='\lib\html\dom\trt\ Dom_HTML_ChangeLT';
$TRT['ChangeData']='\lib\html\dom\trt\Dom_ChangeData';
$TRT['ChangeMod']='\lib\html\dom\trt\Dom_ChangeModHTML';

class ADT{

    //fontos--------------------------
    public static $jog='noname';
    public static $html='simple.html';
    public static $task='alap';
    public static $idT=[];
    public static $view='';
    public static $dataT=[];
    /**
     ellenőrzott POST adatok (safePost). Ide kell írni (ellenőrzés után !)
     minden adatot, amit adatbázisba akarunk menteni
     */
    public static $SPT=[];
    /**
     ide kell a nyelvi elemeket beírni
     */
    public static $LT=[];
    public static $paramT=[];

}

class TSK{
    static public $alap=[
        // 'paramT'=>['Ikon_ClikkSor'=>['ikonsorT'=>['del','pub']]],
      //  'sql'=>'SELECT * FROM email',
        'trt'=>['app\mod\Alap'],
        'view'=>'admintabla.html'
    ];

}
trait Alap{
    
    public function Alap()
    {
        
    }
}

