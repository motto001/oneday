<?php
namespace trt\task;
$baselang='hu';
\GOB::$LT['err_mailcim_empty']='Nincs megadva emailcím!';
\GOB::$LT['err_email_failed']='Eamail küldés nem sikerült!';
\GOB::$LT['err_email_body_empty']='Az üzenet mező üres!';
\GOB::$LT['no_subject']='Nincs tárgy.';

trait Mailkuld{ 

public function Mailkuld()
{  
   
    
    $task=$this->ADT['task'];

    $parT['cim']=$_SESSION['idT'] ?? [];
    unset($_SESSION['idT']);
    
    if(empty($parT['cim']))
    { 
        \GOB::$messageT['err'][]='err_mailcim_empty';
        //$this->ADT['TSK'][$task]['next']='email';
    }
    else 
    {   
    $parT['Subject']=$_POST['subject'] ?? 'no subject';
    $parT['Body']=$_POST['body'] ?? '';
    
        if($parT['Body']!='')
        {  
           $parT['SetFrom']= $_POST['setfrom'] ?? \CONF::$mailfrom;
           $parT['fromnev']= $_POST['fromnev'] ?? \CONF::$fromnev;
    
           $res=\mod\email\Email_S::Res($parT);
              if($resT['bool']=false)
              {  
                  \GOB::$messageT['err'][]='reg_email_send';
              }
            
        }
        else
        {
            \GOB::$messageT['err'][]='err_email_body_empty'; 
        }
    }
}}