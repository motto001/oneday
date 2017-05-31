<?php
namespace app\szallas;
defined( '_MOTTO' ) or die( 'Restricted access' );

class ADT{
static  public $ADT=[
    'jog'=>'user',
        'tablanev'=>'slider',
        'task'=>'alap',
        'view'=>'',
        'viewF'=>'base.html',
        'view_iniclass'=>'ViewInit', //ha van az aktuális tmpl-ben onnan ha nincs az app könyvtárbol tölti be
        'paramT'=>[],
        'evalSTR'=>''
       
    ];
public static $TRT=
    [
        'SetTask'=>'trt\Task_ADT_SetTask',
        'Task'=>'trt\Task',
        //'ChangeApp'=>'trt\Dom_ChangeApp',
       // 'ChangeData'=>'trt\Dom_ChangeData',
        'SrcID'=>'trt\Change_SrcID',
    ];
  
public static $TSK=
[

'alap'=>['SQL'=>'SELECT * FROM szallas WHERE id=\'".$_GET[\'id\']."\'','ChangeApp'=>'nem',
        'TRT'=>['Data'=>'\trt\taskbase\Data',
        'Modal'=>'\app\szallas\Modal']],
'map'=>['SQL'=>'SELECT cim FROM szallas WHERE id=\'".$_GET[\'id\']."\'','ChangeApp'=>'nem',
        'TRT'=>['Data'=>'\trt\taskbase\Data',
            'View'=>'\trt\taskbase\View','Map'=>'\app\szallas\Map',
            ],'viewF'=>'ROOT/tmpl/oneday/app/szallas/map.html'], 
'emailform'=>['TRT'=>['View'=>'\trt\taskbase\View'],
            'viewF'=>'ROOT/tmpl/oneday/app/szallas/emailform.html'],
'galeria'=>['ChangeApp'=>'nem',
        'TRT'=>[ 'Galeria'=>'\app\szallas\Galeria']]
    
]; 

}


trait Modal{
    public function  Modal(){
        $dataT=$this->ADT['dataT'] ?? '';
        $dataT['fullcim']=$dataT['orszag'].', '.$dataT['varos'].', '.$dataT['cim'];
        
        $html=file_get_contents(\PATH::$rootDir.'/tmpl/oneday/app/oneday/view/szallas_modal.html',true);
//print_r($dataT);
            $res=\lib\html\dom\Dom_s::ChangeData($html,$dataT);
            $iconlist= \app\checklist\Checklist_Iconlist_S::Res($dataT['pikt']);
            $res=str_replace('<!--iconlist-->', $iconlist, $res);
        $this->ADT['view']=$res;

    }

}
trait Map{
    public function  Map(){
        $cim=$this->ADT['dataT']['cim'] ?? 'Nincs cim megadva';

        $res=str_replace('<!--cim-->', $cim, $this->ADT['view']);
        $this->ADT['view']=$res;

    }

}


trait Galeria{
    public function  Galeria(){
       // $dataT=$this->ADT['dataT'] ?? [];
         $dataT=\lib\db\DB::assoc_tomb("SELECT * FROM szallasfotok WHERE szallasid='".$_GET['id']."'");
     // print_r($dataT);
        $html=file_get_contents(\PATH::$rootDir.'/tmpl/oneday/app/szallas/galeria.html',true);    
        $html=\lib\html\dom\Dom_s::ChangeData($html,$dataT);
        $item_view=' <div data-p="112.50" dat-style="visible" style="">
        <img data-u="image"  dat-src="foto" src="img/01.jpg" />
        </div>';
       
        $res='';
        'style="display: none;"';
        $i=1;
        if(!empty($dataT)){
            foreach ($dataT as $dataS)
            {
                $dataS['foto']=\PATH::$rootDir. $dataS['foto'];
                if($i==1){$dataS['visible']='display: visible;';}
                else
                {$dataS['visible']='display: none;';}
                $res.=\lib\html\dom\Dom_s::ChangeData($item_view, $dataS);
                $i++;
            }   
            
        }else{ $res.= "Nincsenek képek a galériában";}
       
        
        
        $html=str_replace('<!--imagelist-->', $res, $html);
        $this->ADT['view']=$html;

    }

}