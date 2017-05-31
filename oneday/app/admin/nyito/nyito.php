<?php
namespace app\admin\nyito;
defined( '_MOTTO' ) or die( 'Restricted access' );
//echo 'club';
//print_r($_POST);
//echo mysqli_real_escape_string($_POST["szoveg"]);
class ADT{
static  public $ADT=[
        'jog'=>'admin',
        'tablanev'=>'cikk',
        'task'=>'alap',
        'limit'=>50, //hány tétel legyen egy oldalon a listában vagy táblázatban
        'view'=>'admin user',
        'viewF'=>'admin.html',
        'view_iniclass'=>'ViewInit', //ha van az aktuális tmpl-ben onnan ha nincs az app könyvtárbol tölti be
        'paramT'=>[],
        'evalSTR'=>'$this->ADT[\'dataT\'][\'id\']=$_POST[\'idT\'][0] ?? 0;'
       
  
    ];
public static $TRT=
    [
        'SetTask'=>'trt\Task_ADT_SetTask',
        'Task'=>'trt\Task',
        'ChangeApp'=>'trt\Dom_ChangeApp',
        'ChangeData'=>'trt\Dom_ChangeData',
        'SrcID'=>'\trt\Change_SrcID'
    ];
    
public static $TSK=
[
/*'alap'=>
    [
    'SQL'=>'SELECT * FROM cikk WHERE kat=\'nyito\' ORDER BY sorrend ASC',
    'TRT'=>['DataLista'=>'\trt\taskbase\Data','View'=>'\trt\taskbase\View_byinit'],
       'paramT'=>
        [
          'Iconsor'=>['iconsorT'=>['new','edit','pub','unpub','sorrend','del'=>['type'=>'task_del']]],
          'Content'=>
            [
              'namespace'=>'Tabla',
              'dataszerkT'=>
                  [
                   'chk'=>['nocim'=>true,'func'=>'checkbox_mezo'],
                   'pub'=>['nocim'=>true,'func'=>'pub_mezo'],
                   'cim'=>[],
                   'intro'=>[],'szoveg'=>[]
                  ]
            ]
        ]  
    ],*/

'alap'=>['next'=>'edit'],
    
    
'new'=>['TRT'=>['View'=>'\trt\taskbase\View_byinit','Media'=>'\trt\Media'],
        'paramT'=> ['Content'=> [//'viewF'=>'app\admin\club\view\club_form.html',
            'iniviewF'=>'nyito_form.html','view_iniclass'=>'app\admin\nyito\view\NyitoIni']]],
'edit'=>['TRT'=>['Data'=>'trt\taskbase\Data'],'next'=>'new','SQL'=>'SELECT * FROM cikk2 WHERE id=\'1\''],    
/*'pub'=>['TRT'=>['Pub'=>'trt\task\Pub'],'next'=>'alap'],
'cancel'=>['next'=>'alap'],    
'unpub'=>['TRT'=>['unPub'=>'\trt\task\Pub'],'next'=>'alap'],
'del'=>['TRT'=>['Del'=>'\trt\task\Del'],'next'=>'alap'],
'szallaslista'=>['TRT'=>['DataLista'=>'trt\taskbase\Data','Lista'=>'\trt\taskbase\Lista','SrcID'=>'\trt\Change_SrcID'],
    'listaF'=>'app/admin/slider/view/item.html','SQL'=>'SELECT id,nev,substr(egyeb,1,100) as intro,kep1 FROM szallas' ],
'szallasdata'=>['TRT'=>['Szallasdata'=>'app\admin\trt\Szallasdata']],
'savenew'=>['next'=>'save'], //a Save postban érzékeli a savenew-t és a mentés után a new-ra irányít,nem a next-re
 */  
'save'=>['TRT'=>['Save'=>'\trt\taskbase\Save'],'next'=>'alap','hibatask'=>'edit',
        'mentmezoT'=>['cikk2'=>['kapcsolomezo'=>'userid', //csak többtáblánál kell
                                 'mezok'=>['szoveg']]]],    
       
];

} 


