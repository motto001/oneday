<?php
namespace trt\task;

defined('_MOTTO') or die('Restricted access');
// LT: Save_succes,database_err
class Save_S{
  static   public function SaveFromSPT($ADT,$err='database_err')
    {
        $id=$ADT['idT'][0] ?? 0;
        $task=$ADT['task'];
        $ADT['saveRes']=true;
        $mentmezoT=$ADT['mentmezoT'] ?? [];
        $mentmezoT=$ADT['TSK'][$task]['mentmezoT'] ?? $mentmezoT;
        if(!empty($mentmezoT))
        {
          foreach( $mentmezoT as $mezo)
          {
               $value= $ADT['SPT'][$mezo] ?? '';  
                $saveT[$mezo]=$value; 
          }
        }else{$saveT=$ADT['SPT'];}
        
        if($id==0)
        {
 //print_r($saveT);
         $beszurtid=\lib\db\DBA::beszur_tombbol($ADT['tablanev'],$saveT);
            if($beszurtid==0)
            {
                $ADT['saveRes']=false;
                $ADT['LT']=\lib\base\TOMB::langTextToT('err',$err,$ADT['LT']); 
                //print_r($err);
            }
           else{$ADT['id']=$beszurtid;}    
        }
        else 
        {   
            if(!\lib\db\DBA::frissit_tombbol($ADT['tablanev'],$id,$saveT))
            {
                $ADT['saveRes']=false;
                $ADT['LT']=\lib\base\TOMB::langTextToT('err',$err,$ADT['LT']);
            }
            
        }    
 return $ADT ;
    }    
    
}
trait Save_base{
use \trt\ell\Ell;
public function Save_base($hibaTask,$info)
    {   
        $task=$this->ADT['task'];
        $this->ADT['TSK'][$task]['next']=$hibaTask;
        

        if ($this->Ell()) {
    
            $this->ADT=\app\admin\trt\task\Save_S::SaveFromSPT($this->ADT) ;
             
            if ($this->ADT['saveRes']) {
                 
                $this->ADT['LT'] =\lib\base\TOMB::langTextToT('info',$info,$this->ADT['LT']);
                $this->ADT['TSK'][$task]['next']='alap';
            }
             
        }
    }

}

trait Save{ 
use \task\Save_base;

public function Save()
{
    $this->Save_base('edit','Save_succes');
//print_r( $this->ADT['SPT']);
}

}
