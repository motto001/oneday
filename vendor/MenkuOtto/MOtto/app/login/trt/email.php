<?php
namespace app\login\trt;
$baselang='hu';
\GOB::$LT['reg_email_send']='Regisztrációs email elküldve!';
\GOB::$LT['err_reg_email_nosucces']='Regisztrációs email elküldése nem sikerült!';
\GOB::$LT['email_reg']='Regisztrációs email.';

trait Email_confirm_send
{ 
public function Email_confirm_send()
{
    $baselang='hu';
  
    if(\CONF::$autopub=='email' && $this->ADT['ellerr'])
    {
       $body=\lib\base\File::getContent('tmpl/'.\GOB::$tmpl.'/login/email/'.\GOB::$lang.'_confirm.html');
       if($body==''){$body=\lib\base\File::getContent('app/login/view/email/'.\GOB::$lang.'_confirm.html');}
       if($body==''){$body=\lib\base\File::getContent('tmpl/'.\GOB::$tmpl.'/login/email/'.$baselang.'_confirm.html');}
       if($body==''){$body=\lib\base\File::getContent('app/login/view/email/'.$baselang.'_confirm.html');}
       
        $code=\lib\str\STR::randomSTR(8);
       
        $sql="INSERT INTO tmp (userid,varname,value) VALUES ('".$this->ADT['beszurtid']."','regcode','".$code."')";   
        $res= \lib\db\DBA::parancs($sql) ; 
        
        $changeT=['username'=>$this->ADT['SPT']['username'],'link'=>$_SERVER['HTTP_HOST'].'/index.php?app=base&fg=confirm&id='.$this->ADT['beszurtid'].'&code='.$code];
      
        $parT['cim']=$this->ADT['SPT']['email'];
        $parT['Subject']=\GOB::$LT['Email_reg'] ?? 'Email_reg';
        
        $parT['Body']=\lib\str\STR::Change(file_get_contents($htFile,true),$changeT);
        $res=\mod\email\Email_S::Res($parT);
        
        if($res['bool'])
        { \GOB::$messageT['info'][]='reg_email_send';  }
        else
        { \GOB::$messageT['err'][]='err_reg_email_nosucces';}
    }
} 
}