<?php
class Base_ADT {
    
    public static $ADT=[
      //  alap értékek álltalában lehetnek a taskban is 
        'view'=>'',
       // 'TRTtmplCH'=>['IconSor'=>'\app\ikon\trt\IconSor'] ,//nem kell tmplINI()-kell csinálbiellenőrzi hogy a tmpl\GOB::$tmpl\namespace  létezik-e,ha igen azt tölti be
        'TRTbaseCH'=>[] ,//ellenőrzi hogy a \CONF::baseTRT['key'] létezik-e,ha igen azt tölti be
        'taskID'=>'task',// vezérlő get vagy post paraméterek előtagja ha nincs az app id-et használja
        'appID'=>'med',//ezt kell használni  getID helyett
        'appIDuniq'=>false,
        'paramT'=>['iconsor'=>['size'=>'32']], //lehet a taskban is
        'ellerr'=>true,
        'appDir'=>'app/media',
        'task'=>'alap',
        'tablanev'=>'media',
        'view_iniclass'=>'login\ViewInit', //a viewF betöltését segíti ha nincs a view megkísérli  közvetlenül betölteni  a viewF-t
        'content'=>'Tabla', //aplikáció névtere (app nem kell) Az App_s::res() ezt tölti be a 
        'contentF'=>'nyito.html' ,//ha A TRT-ben betöltjük trt\mod\Content-et akkor ez lesz a content
          //trt\task\view::contentFromInit()-el tölti be vagy ha érvényes filenév akkor simán  
        'dataT'=>[],
        'SPT'=>[],
        
        //tabla--------------------------------
        'rendez_sor'=>true,
        'fejlec'=>true,
        'dataT'=>[],
        'dataszerkT'=>[],
        
        //media-------------------------------------
        'feltolt_mezo'=>'fileToUpload',
        'user_rootdir'=>'res/images/user',
        'admin_rootdir'=>'res/images',
        'dir'=>'',
        'src_torol'=>'res/ico/16/torol.png',
        'hidden_dirs'=> ['62','share','thumb'],
        'view_filetipus'=> ['jpg','jpeg','gif','png'], //ha üres mindent enged
        
        //icon---------------------------
        'iconview'=>'',
        'label'=>'',
        'iconDir'=>'res'.DS.'ico'.DS.'32'.DS, //kell a végére: / 
        'simpleType'=>'image', //lehet:image,glyph
        'labelType'=>'no',
        'clickType'=>'simple',
        'simpleClass'=>'moiconimage',
        'simpleTypeT'=>['glyph'=>' ',' image'=>''],     
        'labelTypeT'=>['no'=>'','simple'=>''],       //lehet
        //tömbök---------------------------------------
        'clickTypeClass'=>'btn btn-primary',
        'clickTypeT'=>[],
        'iconsorT'=>['new'=>'','edit'=>'','info'=>''],
        'iconDir'=>'res'.DS.'ico'.DS.'32'.DS, //kell a végére: /
        'iconT'=>[
            'eye'=>['image'=>'eye.png','glyph'=>'eye-open'],    
            'email'=>['image'=>'email.png','glyph'=>'envelope']]

        
    ];
    /**
 ha nincs saját getADT() az app ini getADT-je bemásolja az ADT['TRT']-be
     */
    public static $TRT=[
        'Content'=>'trt\mod\Content',
        'View'=>'trt\task\View',
        'AppIni'=>'trt\Empty_AppIni',
        'SetTask'=>'trt\Task_ADT_SetTask',
        'Task'=>'trt\Task',
        'ChangeData'=>'trt\Dom_ChangeData',
        'ChangeApp'=>'trt\Dom_ChangeApp'
    ];
/**
 ha nincs saját getADT() az app ini getADT-je bemásolja az ADT['TSK-ba']-be
 */    
    public static $TSK=[];
    /**
 ha nincs saját getADT() az app ini getADT-je bemásolja az ADT['ELL']-be
 */
    public static $ELL=[];
    public static $RGX=[];
    public static function initADT() {
        self::$ADT['userid']=$_SESSION['userid']; ;
    }
    public static function getADT() {
        return self::$ADT;
    }
   /**
/ha van olyan paraméter a ADT-ben amit ini fájlok véglegesítenek és valamelyik app használná PL.:appID,taskID
    */
    public static function setParamT() {}
}