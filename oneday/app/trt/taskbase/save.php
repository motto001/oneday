<?php
namespace trt\taskbase;

defined('_MOTTO') or die('Restricted access');

\GOB::$LT['Save_err']='';
\GOB::$LT['Save_succes']='';
class Save_S{
    static   public function userSPTplusz($SPT)
    {
        if(isset($_POST['jelszo'])){$SPT['password']=md5($_POST['jelszo']);}
        
        $usrnev=$_POST['username'] ?? '';
        if( $usrnev=='' ){$SPT['username']=$SPT['email'] ?? '';}
        return $SPT;
    }

  static   public function SaveFromSPT($SPT,$mentmezoT)
    {
        $id=$_POST['idT'][0] ?? 0;
        $id=$_POST['id'] ?? $id;
        $baseidnev=$mentmezoT['baseid'] ?? 'id'; //ha valamilyen okból az azonosító nem id a táblában
        $idnev=$mentmezoT['kapcsolomezo'] ?? 'id';  //az idegen kulcs (kapcsoló)
        $res=true; $beszurtid=0;
        $i=1;
       
        foreach ($mentmezoT as $tabla=>$mezoT)
        { 
           if($i>1){$idnev=$mezoT['id'] ?? $idnev;}
           else{$idnev=$baseidnev;}
           
             foreach( $mezoT['mezok'] as $mezo)
              {
                   $value= $SPT[$mezo] ?? ''; 
                  if(is_array($value)){$saveT[$mezo]=implode('|', $value);} //nem kell! lib/ell/ell.php 
                   else{$saveT[$mezo]=$value;} 
              }
              
               if($id==0)
                {
                   if($beszurtid>0){$saveT[$idnev]=$beszurtid;}
                $beszurtid=\lib\db\DBA::beszur_tombbol($tabla,$saveT);   
              //echo  $beszurtid=\lib\db\DBA::beszur_tombbol($tabla,$saveT,true);
                    if($beszurtid==0)
                    {
                        $res=false; 
                    }  
                }
                else 
                {  //echo \lib\db\DBA::frissit_tombbol($tabla,$id,$saveT,$idnev,true);
                    
                    if(!\lib\db\DBA::frissit_tombbol($tabla,$id,$saveT,$idnev))
                    {
                        $res=false;
                    }
                    
                } 
        $i++;
        }
         
        
        
 return $res ;
    }    
    
}
trait Save{
use \trt\ell\Ell;
public function SaveUser()
{
 $this->ADT['userSPTplusz']=true;
 $this->Save();
}


public function Save()
    {   
       $task=$this->ADT['task'];       
        if ($this->Ell()) {
          //user táblához kell csak hogy email is lehessen usernév és kódolatlan jelszómező is legyen  
          $userSPTplusz= $this->ADT['userSPTplusz'] ?? false;
          
          if($userSPTplusz){$this->ADT['SPT']=\trt\taskbase\Save_S::userSPTplusz($this->ADT['SPT']);}  
          $this->ADT['saveRes']=\trt\taskbase\Save_S::SaveFromSPT($this->ADT['SPT'],$this->ADT['TSK'][$task]['mentmezoT']) ;
              
            if ($this->ADT['saveRes']) {
                     
               \GOB::$messageT['info'][]='Save_succes';
               if($_POST['task']=='savenew'){$this->ADT['TSK'][$task]['next']='new';}
              
            }
            else 
            {
                \GOB::$messageT['err'][]='Save_err';
                 $this->ADT['TSK'][$task]['next']=$this->ADT['TSK'][$task]['hibatask'];
            }
             
        }
    }

}


