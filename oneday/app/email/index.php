<?php
require_once('phpmailer/phpmailer.php');
require_once('phpmailer/smtp.php') ;

class CONF{
    //mail-------------------------------
    public static $mailfrom= 'motto001@gmail.com';
    public static $fromnev= 'Admin';
 //smtp-----------------------------
    
    public static $smtpHost= 'smtp.processnet.hu'; //null vagy '', ha nem használ smtp-t
    public static $smtpPort= 26;
    public static $smtpUser= 'webadmin2@helyiakciok.hu';
    public static $smtpPasswd= 'aaaaaa';
    public static $SMTPSecure = 'tls'; //vagy ssl */
   /* 
    //gmailsmtp-------------------------------
    public static $smtpHost= 'smtp.gmail.com';
     public static $smtpPort= 465;
     public static $smtpUser= 'motto001@gmail.com';
     public static $smtpPasswd= 'motto6814';
     public static $SMTPSecure = 'ssl';//// secure transfer enabled REQUIRED for Gmail
    */  
}


/**
$parT = ['funcT'=['SetFrom'=>'ottoka@gamail.com','fromnev'=>'ottó-tol'],
'cim'=>'cim@jj.hu','subject'=>'tárgy','subject'=>'tárgy']
 */
class Email
{
public $mail=null;    
public $ADT=[
   'CharSet'=>'utf-8',
   'IsHTML'=>true, 
   'Subject'=>'Admin levél',
//'SMTPDebug'=>1 ,// testeléshez: 1 = errors and messages, 2 = messages only  
//  'funcT'=>['IsHTML'=>true]
  
];


public function __construct($parT = []){
    
  //  $this->ADT['funcT']['SetFrom']=['SetFrom' => \CONF::$mailfrom,'fromnev' => \CONF::$fromnev];
    $this->ADT['smtpHost']= CONF::$smtpHost;
    $mail = new PHPMailer();
    $mail->IsHTML(true);
    if(!empty($this->ADT['smtpHost']))
    { 
     $mail->isSMTP();  
     $mail->SMTPAuth = true;
     $mail->Host= CONF::$smtpHost;
     $mail->From = CONF::$smtpUser;
     $mail->FromName = "admin";
   //  if(isset($this->ADT['SMTPDebug'])){$mail->SMTPDebug =$this->ADT['SMTPDebug'];}
     $mail->SMTPDebug =0;
     $mail->SMTPSecure=CONF::$SMTPSecure;
     $mail->Port=CONF::$smtpPort;
     $mail->Username = CONF::$smtpUser;
     $mail->Password = CONF::$smtpPasswd;  
    }
    else{$mail->isSendmail();}
    $setfrom=CONF::$mailfrom;
    $fromnev= CONF::$fromnev;
    $mail->SetFrom( $setfrom, $fromnev);
    $this->mail=$mail; 
    
    
    
}  
}

class Email_S
{
    static public function ResOb($parT=[]){
         
        $mailbase=new Email();
        return $mail->mail;
    }
    static public function Send($cim,$nev,$szoveg,$subject='',$feladocim='',$feladonev=''){
         
        $mailbase=new Email();
        $mail=$mailbase->mail;
 //    echo  'fffffffff'.$mail->Username;

        try {
          
            $mail->AddAddress($cim, $nev);
           
            $mail->Subject = $subject;
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
          //  $mail->AddAttachment('images/phpmailer.gif');
          //  $mail->MsgHTML(file_get_contents('contents.html'));
            $mail->MsgHTML($szoveg);
            $mail->Send();
           $res= "Message Sent OK\n";
        } catch (phpmailerException $e) {
            $res= $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            $res=  $e->getMessage(); //Boring error messages from anything else!
        }
                 
        return $res;
    }

}


$cim='menkuotto@gmail.com';
$nev='Ottó';
$szoveg='lllllllllllllll kkkkkkkkkkkkkkkkkkkkkkkk';
//echo email_S::Send($cim, $nev, $szoveg);
echo 'email';


