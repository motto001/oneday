<?php
namespace app\login\trt\task;

defined('_MOTTO') or die('Restricted access');
$baselang='hu';
\GOB::$LT['database_err']='';
\GOB::$LT['reg_kesz']='';
\GOB::$LT['reg_kesz_email_aktival']='';
\GOB::$LT['reg_kesz_admin_aktival']='';
\GOB::$LT['passwd_saved']='';
class Save_S{
  static   public function SaveFromSPT($ADT,$insert=true,$err='database_err')
    {
        $task=$ADT['task'];
        $ADT['saveRes']=true;
        
            if(isset($ADT['SPT']['password']))
            {$ADT['SPT']['password']=md5($ADT['SPT']['password']);}
            if(isset($ADT['TSK'][$task]['noSave']))
            {
              foreach($ADT['SPT'] as $key=>$value)
              {
                   if(!in_array($key,$ADT['TSK'][$task]['noSave']))
                   {      
                    $saveT[$key]=$value; 
                   }  
              }
            }else{$saveT=$ADT['SPT'];}
            
            if($insert){
             $beszurtid=\lib\db\DBA::beszur_tombbol($ADT['tablanev'],$saveT);
             $ADT['beszurtid']=$beszurtid;
            }else{
               $res= \lib\db\DBA::frissit_tombbol($ADT['tablanev'],$ADT['idT'][0],$saveT,$test=false);
                
            }
            $hiba=\GOB::$logT['hiba']['pdo'][0] ?? '';
            if($hiba!='')
            {
                $ADT['saveRes']=false;
                \GOB::$messageT['err'][$err]='' ;
                //$ADT['LT']=\lib\base\TOMB::langTextToT('err',$hiba,$ADT['LT']);               
            }
            
          
 return $ADT ;
    }
    
}
trait Save{
use \trt\ell\Ell;
public function Save($hibaTask,$info)
    {   
        $task=$this->ADT['task'];
        $this->ADT['TSK'][$task]['next']=$hibaTask;
        

        if ($this->Ell()) {

            $this->ADT=\app\login\trt\task\Save_S::SaveFromSPT($this->ADT) ;
            
            if ($this->ADT['saveRes']) {
                 
               // $this->ADT['LT'] =\lib\base\TOMB::langTextToT('info',$info,$this->ADT['LT']);
                //\GOB::$messageT['info'][]= $info;
                $this->ADT['TSK'][$task]['next']='alap';
            }
       
             
        }
    }

}

trait Save_Reg{ 
use \trt\ell\Ell;
use \app\login\trt\Email_confirm_send;

public function Save_Reg()
{ 

    if ($this->Ell()) 
   { 
//echo 'fdsaaaaaagggggggggggggggggg';

        if(\CONF::$autopub=='igen'){$pub='0';}else{$pub='1';}
        
        $sql="INSERT INTO userek (username,email,password,pub) VALUES ('".$this->ADT['SPT']['username']."','".$this->ADT['SPT']['email']."','".md5($this->ADT['SPT']['password'])."','".$pub."')";
        $res= \lib\db\DBA::beszur($sql);
        echo $sql;
       // print_r($res);
        if ($res['bool'])
        {
            $this->ADT['beszurtid']=$res['id'];
            
            if(\CONF::$autopub=='igen'){GOB::$messageT['info'][]='reg_kesz';}
            if(\CONF::$autopub=='email')
            {
                $this->Email_confirm_send() ;  \GOB::$messageT['info'][]='reg_kesz_email_aktival'; 
            }
            if(\CONF::$autopub=='nem'){ \GOB::$messageT['info'][]='reg_kesz_admin_aktival';}
            
          //  if($this->ADT['emailConfirm']){$this->Email() ;} 
            $this->ADT['LT'] =\lib\base\TOMB::langTextToT('info',$info,$this->ADT['LT']);
        }
        else{\GOB::$messageT['err'][]='database_err';}
    }
    else {$this->ADT['TSK']['regment']['next']='regform';}
//print_r(\GOB::$messageT);
}
}
trait Save_passwd{
 
use \trt\ell\Ell;

public function Save_passwd($info='passwd_saved')
{       

    $task=$this->ADT['task'];
    $this->ADT['TSK'][$task]['next']='passwdform'; 
        //print_R
   if ($this->Ell()) 
   { 
 
         $sql= "UPDATE userek SET password='".md5($this->ADT['SPT']['password'])."' WHERE id='".$_SESSION['userid']."'";
         $res= \lib\db\DBA::parancs($sql)   ;
//echo $sql;
            if ($res['bool']) 
            {     
                 \GOB::$messageT['info'][]='passwd_saved';
                $this->ADT['TSK'][$task]['next']='alap';
            }
           else {}
  
             
     }
} }

