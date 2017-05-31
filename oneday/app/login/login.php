<?php
namespace app\login;
defined( '_MOTTO' ) or die( 'Restricted access' );
//class ADT extends \Base_ADT{
class ADT {
public static $ADT=
[
'jog'=>'noname',
'captcha'=>false, //CONF-ban is meg lehet adni
'ellerr'=>true,  // !!! kell az ellnőrzés függő traiteknek (PL.emailküldés) ellenőrző függvény false-ra állítja ha hibát talál
//'appDir'=>'app/login', // ?
'view_iniclass'=>'app\login\ViewInit', 
'view'=>'',    
'task'=>'alap', //induló task

    'appID'=>'log',
    'taskID'=>'log',
'tablanev'=>'userek',
'appNev'=>'Login',
'dataT'=>[],
'SPT'=>[],
'LT'=>[],  
'Ell_TRT'=>['Marvan'=>'\trt\ell\DB_Marvan', 'Match'=>'\trt\ell\Ell_Match','DB_ValidPasswd'=>'\trt\ell\DB_ValidPasswd']
 ];   
public static $TRT=
[
    'AppIni'=>'trt\Empty_AppIni',
        'SetTask'=>'trt\Task_ADT_SetTask',
        'Task'=>'trt\Task',
       // 'ChangeData'=>'trt\Dom_ChangeData',
       // 'ChangeApp'=>'trt\Dom_ChangeApp'  
];    
public static $TSK=
[
'alap'=>['TRT'=>['Alap'=>'app\login\trt\task\Alap']],
'belepform'=>['TRT'=>['View'=>'trt\taskbase\View_byinit',
                      'Change_taskname'=>'app\login\trt\Change_taskname'],'viewF'=>'belep_form.html'],
 'kilep'=>['TRT'=>['Kilep'=>'app\login\trt\task\Kilep'],'next'=>'alap'],
 'belep'=>['TRT'=>['Belep'=>'app\login\trt\task\Belep_oneday'],'next'=>'alap'],   
'kilepform'=>['TRT'=>['View'=>'trt\taskbase\View_byinit','Change_taskname'=>'app\login\trt\Change_taskname'],'viewF'=>'kilep_form.html'],

  /*'passwdform'=>['TRT'=>['View'=>'trt\taskbase\View_byinit','Change_taskname'=>'app\login\trt\Change_taskname'],'viewF'=>'szerk_passwd.html'],
'regform'=>['TRT'=>['View'=>'trt\taskbase\View_byinit','Captcha'=>'app\login\trt\Captcha','Change_taskname'=>'app\login\trt\Change_taskname'],'viewF'=>'regisztral_form.html'],
'passwdchange'=>['TRT'=>['Save_passwd'=>'app\login\trt\task\Save_passwd'], 'next'=>'alap',],

'jelszomail'=>['TRT'=>['Alap'=>'app\login\trt\task\Alap']],
'mailconfirm'=>['TRT'=>['Alap'=>'app\login\trt\task\Alap']], 
'regment'=>['TRT'=>['Save_Reg'=>'app\login\trt\task\Save_Reg','CodeEll'=>'app\login\trt\Captcha_CodeEll'],'mentmezoT'=>['fajtaid','nev','kep','intro','text'],
                    'next'=>'alap']*/
];
public static $ELL=
[
'passwdchange'=>[
        'password'=>['regx'=>[],'Match'=>'[$_POST["password2"],"two_passwd_nomatch"]'],
        'oldpass'=>['regx'=>[],'ValidPasswd'=>'passwd_nomatch']], 
   
'belep'=>[
        'username'=>['regx'=>[]],
        'password'=>['regx'=>[],'ValidPasswd'=>'passwd_nomatch']], 
       
'regment'=>[
         'username'=>['regx'=>[],'Marvan'=>["username","userek","username_have"]],
        // 'email'=>['regx'=>[],'Marvan'=>["email","userek","email_have"]],
         'email'=>['regx'=>[]],
         'password'=>['regx'=>[], 'Match'=>'[$_POST["password2"],"two_passwd_nomatch"]']] 
    
    ];

public static $RGX=[
    
'username'=>['HU_TOBB_SZO',['/^.{<<MIN>>,<<MAX>>}$/u','',['MIN'=>'4','MAX'=>'20']]],

'email'=>	[['/^.{<<MIN>>,<<MAX>>}$/u','long_err',['MEZO'=>'email','MIN'=>'6','MAX'=>'50']],
        ['MAIL','email_err']],
'passwd'=>	[['/^.{<<MIN>>,<<MAX>>}$/u','long_err',['MEZO'=>'password','MIN'=>'6','MAX'=>'20']]],
    
];
 

}   
 

