<?php
defined( '_MOTTO' ) or die( 'Restricted access' );

/**
alap trt tomb ha az applikáció taskjában vagy alap osztályában olyan szereplő trait itt megvan 
akor innen tölti be. használja: app\trt\task\TASK
 */
trait Base_Joghiba{use trt\task\Joghiba;}

class CONF
{
    public static $baseTRT=[
        'AppIni'=>'trt\Empty_AppIni',
        'SetTask'=>'trt\Task_ADT_SetTask',
        'Task'=>'trt\Task',
        'ChangeData'=>'trt\Dom_ChangeData',
        'ChangeApp'=>'trt\Dom_ChangeApp'
    ];
    public static $simpleIconType='image'; //image,glyph (iconok mit használnak)
    /**
ha MOtto/ val kezdődik az elérési út akko a PATH::$MOttoDir teszi az elérési út elé 
ha nem akkora PATH::$rootDir-t
     */
    public static $jquery= 'MOtto/vendor/jqery/jquery-1.9.1.min.js';
    public static $phpmailer='MOtto/vendor/phpmailer/ver6'; //csak könyvtárnév kell!! ebbő lesz a névtér is
    public static $bootstrapJS='MOtto/vendor/bootstrap/bootstrap.3.3.6.min.js';
    public static $bootstrapCSS='MOtto/vendor/bootstrap/bootstrap336maxcdn.css';
    public static $captcha= true;
    public static $offline= false;
    public static $offline_message = 'Weblapunk fejlesztés alatt.';
    public static $upload_dir='user/share';
    public static $adminok=array(1,2);
    public static $sql_log='full';//lehet 'no','parancs': a lekérdezéseket nem
    //lang----------------------------------- 
    public static $accepted_langT=array('hu','en');
    public static $LangMode='single';
    public static $LangForras='tomb'; //db   	
 /*   public static $host = 'localhost';
    public static $felhasznalonev = 'root';
    public static $jelszo = '*******';
*/
	public static $felhasznalonev = '';
	public static $jelszo = '*******';
    public static $host = 'localhost';
	
	
    public static $adatbazis  = 'pnet371_menku_oneday';
	
    //mail-------------------------------
    public static $mailfrom= 'admin.oneday@helyiakciok.hu';
    public static $fromnev= 'Admin';
    /**
ha false nem küld levelet csak beirja a testemail táblába 
     */
    public static $email=true;  
/**
igen: pub automatikusan, email: mailos konfirmációkor, nem: admin által állítódik nullára
 */
    public static $autopub='email';
    //smtp-----------------------------
    
    public static $smtpHost= 'smtp.processnet.hu'; //null vagy '', ha nem használ smtp-t
    public static $smtpPort= 26;
    public static $smtpUser= 'admin.oneday@helyiakciok.hu';
    public static $smtpPasswd= '*******';
    public static $SMTPSecure = 'tls'; //vagy ssl */
 //gmailsmtp-------------------------------
 /* public static $smtpHost= 'smtp.gmail.com'; 
    public static $smtpPort= 465;
    public static $smtpUser= '';
    public static $smtpPasswd= '';
    public static $SMTPSecure = 'ssl';//// secure transfer enabled REQUIRED for Gmail
 */  
    //base--------------------
    public static $baseApp='oneday'; //*Omni ha a saját(Omni_S::Res()) függvényét akarjuk meghívni

    public static $baseLang='hu';
    public static $baseTmpl='oneday'; // a tmpl/ elé teszi ésa a File::pathD()-ot használja,de megadhato MOtto vagy root előtaggal fix elérés is
    public static $adminTmpl='baseadmin'; 
    public static $title='Oneday';
/**
ha nincs $user_SQL ez alapján csinál. Csak az userek tábla mezői használhatók!
 */
    public static $user_mezok='id,name,username,email';
/**
ha értéket adunk neki az alapján kérezi le az user dataT-t nem az $user_mezok alapján
(evalt használ, $userid használható) 
 */
    public static$userDataT_sql='';

}


