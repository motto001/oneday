<?php
namespace app\email;
use vendor\phpmailer\ver6\PHPMailer;
//use PHPMailer;
//use vendor\phpmailer\ver204;

$mailerPath=\lib\base\File::path(\CONF::$phpmailer.'/PHPMailer.php'); 
$smtpPath=\lib\base\File::path(\CONF::$phpmailer.'/SMTP.php');
require_once($mailerPath);
require_once($smtpPath) ;
class LT
{
    public  static $ucces=[['hu'=>'Elküldve!'],
                               ['en'=>'Send succesfull!']];
    public  static $mail_err=[['hu'=>'Levél küldés nem sikerült!'],
                                ['en'=>'Send error!']];


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
    $this->ADT['smtpHost']= \CONF::$smtpHost;

   // $mail->Subject = "Test";
   // $mail->Body = "hello";
   // $mail->AddAddress("email@gmail.com");
    
    $this->ADT=array_merge ($this->ADT,$parT);
    $mailerPath=\lib\base\File::path(\CONF::$phpmailer);
    $nevter=str_replace('/','\\' ,$mailerPath );
    $class=$nevter.'\PHPMailer';
    $mail = new $class();
    //if($this->ADT['funcT']['IsHTML']){}
     $mail->IsHTML(true);
    if(!empty($this->ADT['smtpHost']))
    { 
     $mail->isSMTP();  
     $mail->SMTPAuth = true;
     $mail->Host= \CONF::$smtpHost;
     if(isset($this->ADT['SMTPDebug'])){$mail->SMTPDebug =$this->ADT['SMTPDebug'];}
     
     $mail->SMTPSecure=\CONF::$SMTPSecure;
     $mail->Port=\CONF::$smtpPort;
     $mail->Username = \CONF::$smtpUser;
     $mail->Password = \CONF::$smtpPasswd;  
    }
    else{$mail->isSendmail();}
    $setfrom=$this->ADT['SetFrom'] ?? \CONF::$mailfrom;
    $fromnev=$this->ADT['fromnev'] ?? \CONF::$fromnev;
    $mail->SetFrom( $setfrom, $fromnev);
    
    
  /*  foreach ($this->ADT as $name => $value)
    {
        if($name!='funcT'){ $mail->$name=$value;}   
    }/*/
    $this->mail=$mail; 
    
    
    
}
//mezok: userid,setfrom,fromnev,cim,cimzett,subject,body,res
//ADT: smtpHost,setFrom,fromnev,cim,cimzett,Subject,Body
public function toDB()
{     
$DBT['setFrom']=$this->ADT['SetFrom'] ?? 'nincs';
$DBT['fromnev']=$this->ADT['fromnev'] ?? 'nincs';
$DBT['body']=$this->ADT['Body'] ?? 'nincs';
$DBT['subject']=$this->ADT['Subject'] ?? 'nincs';
$DBT['cim']=$this->ADT['cim'] ?? 'nincs';
$DBT['cimzett']=$this->ADT['cimzett'] ?? 'nincs';
$DBT['res']=$this->ADT['res'] ?? 'nincs';
$DBT['smtphost']=$this->ADT['smtpHost'] ?? 'nincs';
    
    $sql="INSERT INTO email (userid,setfrom,fromnev,cim,cimzett,subject,body,res,smtphost) VALUES
    ('".$_SESSION['userid']."','".$DBT['setFrom']."','".$DBT['fromnev']."','".$DBT['cim']."',
    '".$DBT['cimzett']."','".$DBT['subject']."','".$DBT['body']."','".$DBT['res']."','".$DBT['smtphost']."')";
    //echo $sql;
    return  \lib\db\DBA::beszur($sql);
}

public function getMailFromID($userid)
{
    $sql="SELECT username,email FROM userek WHERE id='".$userid."' ";
    $dbT=\lib\db\DB::assoc_sor($sql);

    $this->ADT['cim']=$dbT['email'];
    $this->ADT['cimzett']=$dbT['username'];

    return $dbT;


}

public function sendFromID($userid)
{
    $this->getMailFromID($userid);
    return $this->send();
 
  
}
public function Res()
{ 
   
    
    if(is_array($this->ADT['cim']))
    { 
        $idT=$this->ADT['cim'];
        $this->ADT['cim']='lista'; 
        $dbres=$this->toDB();
        if(isset($idT[1]))
        {
            foreach ( $idT as $id)
            {
                $res=$this->sendFromID($id); 
                $sql= "INSERT INTO eposted (touserid,emailid,cim,res) VALUES ('".$id."','".$dbres['id']."','".$this->ADT['cim']."','".$res['res']."')";
                $resT= \lib\db\DBA::beszur($sql);
            }
        }
       else 
       {
           
           $this->getMailFromID($idT[0]);
           $this->send();
           
       }
       
    }
    else
    {
      $res=$this->send();  
       $dbres=$this->toDB();
    }    
   
   
  
    
    
}

public function send()
{
$res['bool']=true;
$res['res']='succes';
$res['err']='ok';
$cimzett=$this->ADT['cimzett'] ?? '';
$this->mail->addAddress($this->ADT['cim'], $cimzett);            // Címzett
$this->mail->Subject =$this->ADT['Subject'] ; 
$cimzett=$this->ADT['cimzett'] ?? 'felhasználó';
$this->ADT['Body']=str_replace('$cimzett', $cimzett, $this->ADT['Body']);
$this->mail->Body    = $this->ADT['Body'];  

// A levél törzse
if(\CONF::$email){
    
    if(!$this->mail->send()) 
    { 
    $res['res']='err';$res['bool']=false;$res['err']=$this->mail->ErrorInfo; 
     \GOB::$logT['mailhiba'][]='cim:'.$this->ADT['cim'].', subject:'.$this->ADT['Subject'].', error:'.$this->mail->ErrorInfo;
    }
}else{$res['res']='nomail';}
$this->ADT['res']=$res['res'];
return $res;
}
   
}


class Email_S
{
    static public function Res($parT=[]){
         
        $mail=new Email($parT);
        return $mail->Res();

    }

}


//$parT['cim']='menkuotto@gmail.com';$parT['Subject']='hhhhhhhhh';$parT['Body']='uzb uiz buizui';
//echo \mod\email\Email_S::Res($parT)['err'];


