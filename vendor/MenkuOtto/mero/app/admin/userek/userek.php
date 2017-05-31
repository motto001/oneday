<?php
namespace app\admin\userek;
defined( '_MOTTO' ) or die( 'Restricted access' );
//echo 'userek';

class userek_ADT{
static  public $ADT=[
        'tablanev'=>'userek',
        'task'=>'alap',
        'limit'=>5, //hány tétel legyen egy oldalon a listában vagy táblázatban
        'view'=>'admin user',
        'viewF'=>'admin.html',
        'view_iniclass'=>'ViewInit', //ha van az aktuális tmpl-ben onnan ha nincs az app könyvtárbol tölti be
        'paramT'=>[
           
        ],
        
  
    ];
public static $TRT=
    [
        'SetTask'=>'trt\Task_ADT_SetTask',
        'Task'=>'trt\Task',
        'ChangeApp'=>'trt\Dom_ChangeApp',
       
    ];
    
 public static $TSK=
[
'alap'=>
    [
    'next'=>'alapview',
    'sql'=>'SELECT * FROM userek',
    'TRT'=>[ 'Alap'=>'\app\admin\trt\Alap']
    ],
'alapview'=>
    [
   'TRT'=>['View'=>'\trt\task\View','ChangeApp'=>'trt\Dom_ChangeApp'],
   'viewF'=>'admin.html',
       'paramT'=>
        [
          'Iconsor'=>['iconsorT'=>['pub','unpub','email']],
          'Content'=>
            [
              'namespace'=>'Tabla',
              'dataszerkT'=>
                  [
                   'chk'=>['nocim'=>true,'func'=>'checkbox_mezo'],
                   'pub'=>['nocim'=>true,'func'=>'pub_mezo'],
                   'username'=>[],
                   'email'=>[] 
                  ]
            ]
        ]  
    ],   
'pub'=>['TRT'=>['Pub'=>'trt\task\Pub'],'next'=>'alap'],
'unpub'=>['TRT'=>['unPub'=>'\trt\task\Pub'],'next'=>'alap'],
'del'=>['TRT'=>['Del'=>'\trt\task\Del'],'next'=>'alap'],
'email'=>['TRT'=>['View'=>'\trt\task\View','ChangeApp'=>'trt\Dom_ChangeApp'],
    'paramT'=>
        [
            'Iconsor'=>['iconsorT'=>['email']],
            'Content'=>
            [
               'viewF'=>'app/email/email_form.html',
               //'view_iniclass'=>'ViewInit'
            ]
        ],
    
    'evalSTR'=>'$_SESSION[\'idT\']=$_POST[\'idT\']; $this->ADT[\'dataT\'][\'fromnev\']=\CONF::$fromnev;
        $this->ADT[\'dataT\'][\'setfrom\']=\CONF::$mailfrom;'
        ],
'mailkuld'=>['TRT'=>['Mailkuld'=>'\trt\task\Mailkuld'],'next'=>'alap'],
];

} 


