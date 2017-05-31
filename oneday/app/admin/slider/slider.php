<?php
namespace app\admin\slider;
defined( '_MOTTO' ) or die( 'Restricted access' );
//echo 'club';

class ADT{
static  public $ADT=[
        'jog'=>'admin',
        'tablanev'=>'slider',
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
'alap'=>
    [
    'SQL'=>'SELECT * FROM slider WHERE slid_id=\'nyito\' ORDER BY sorrend ASC',
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
                   'cim'=>['noorder'=>true],
                   'kep'=>['noorder'=>true],
                   'intro'=>['noorder'=>true],'link'=>['noorder'=>true]
                  ]
            ]
        ]  
    ],
'sorrend'=>['TRT'=>['DataLista'=>'trt\taskbase\Data',
             'View'=>'\trt\taskbase\View_byinit',
             'Sorrend'=>'\app\admin\slider\Sorrend'],
         'paramT'=> ['Iconsor'=>['iconsorT'=>['sorment','cancel']],
             'Content'=> [
          'iniviewF'=>'sorrend.html','view_iniclass'=>'app\admin\slider\view\SliderIni']],
        'SQL'=>'SELECT id,cim FROM slider WHERE slid_id=\'nyito\' and pub=\'0\' ORDER BY sorrend ASC'],
'sorment'=>['TRT'=>['Save_sorrend'=>'\app\admin\slider\Save_sorrend'],'next'=>'alap'],
    
    
'new'=>['TRT'=>['View'=>'\trt\taskbase\View_byinit','Media'=>'\trt\Media'],
        'paramT'=> ['Content'=> [//'viewF'=>'app\admin\club\view\club_form.html',
            'iniviewF'=>'slider_form.html','view_iniclass'=>'app\admin\slider\view\SliderIni']]],
'edit'=>['TRT'=>['Data'=>'trt\taskbase\Data'],'next'=>'new','SQL'=>'SELECT * FROM slider WHERE id=\'".$_POST[\'idT\'][0]."\''],    
'pub'=>['TRT'=>['Pub'=>'trt\task\Pub'],'next'=>'alap'],
'cancel'=>['next'=>'alap'],    
'unpub'=>['TRT'=>['unPub'=>'\trt\task\Pub'],'next'=>'alap'],
'del'=>['TRT'=>['Del'=>'\trt\task\Del'],'next'=>'alap'],
'szallaslista'=>['TRT'=>['DataLista'=>'trt\taskbase\Data','Lista'=>'\trt\taskbase\Lista','SrcID'=>'\trt\Change_SrcID'],
    'listaF'=>'app/admin/slider/view/item.html','SQL'=>'SELECT id,nev,substr(egyeb,1,100) as intro,kep1 FROM szallas' ],
'szallasdata'=>['TRT'=>['Szallasdata'=>'app\admin\trt\Szallasdata']],
'savenew'=>['next'=>'save'], //a Save postban érzékeli a savenew-t és a mentés után a new-ra irányít,nem a next-re
   
'save'=>['TRT'=>['Save'=>'\trt\taskbase\Save'],'next'=>'alap','hibatask'=>'edit',
        'mentmezoT'=>['slider'=>['kapcsolomezo'=>'userid', //csak többtáblánál kell
                                 'mezok'=>['slid_id','cim','intro','kep','link','pub']]]],    
       
];

} 
trait Save_Sorrend{
    public function  Save_Sorrend(){
        $sorrend=$_POST['sorrend'] ?? '';
        $sorrendT=explode(',',$sorrend); 
        
        $i=1;
        foreach ($sorrendT as $data)
        {
            $sql="update slider set sorrend='".$i."' where id='".$data."' and slid_id='nyito'";
            //echo $sql;
            \lib\db\DBA::parancs($sql);
            $i++;
        }


      //  $this->ADT['view']=str_replace('<!--sorrend-->', $res, $this->ADT['view']);
         
    }

}



trait Sorrend{
    public function  Sorrend(){
        $dataT=$this->ADT['dataT'] ?? [];
        $res='';
      //  $item_view='<li id="sorid" class="ui-sortable-handle" ><button  dat-inner="cim" class="btn btn-primary "></button> </li>';
      //  $item_view='<li id="sorid" dat-inner="cim"> </li>';
        $item_view='<li id="sorid" ><div  class="btn btn-primary " dat-inner="cim" > </div></li>';
        $i=1;
      
            foreach ($dataT as $dataS)
            {
                $item_view2=str_replace('id="sorid"','id="'.$dataS['id'].'"', $item_view);
                $res.=\lib\html\dom\Dom_s::ChangeData($item_view2, $dataS);
                $i++;
            }


        $this->ADT['view']=str_replace('<!--sorrend-->', $res, $this->ADT['view']);
   
    }

}
