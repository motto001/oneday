<?php
namespace trt;

defined('_MOTTO') or die('Restricted access');

trait Dom_ChangeLT
{
    public function ChangeLT()
    {
    
    }
}

/**
dat,ltdat paraméterben megadot parmétert cserél pl.: dat-value="adatmezzőnev" 
 */
trait Dom_ChangeData
{

    public function ChangeData()
    {   
        $dataT = $this->ADT['dataT'] ?? [];
        $dataT = $this->ADT['TSK'][$this->ADT['task']]['dataT'] ?? $dataT;
        $this->ADT['view'] = \lib\html\dom\Dom_s::ChangeData($this->ADT['view'], $dataT );

    }
}
/**
 * ADT kompatibilis.<!--:modnev|obNev|getID'-->
 */
trait Dom_ChangeApp
{
 public function ChangeApp()
   {   
        $matches=[];$parT=[];
        $task=$this->ADT['task'] ?? 'alap';
//echo '--------------------------'.$this->ADT['task'] ; 
        preg_match_all ("/<!--:([^`]*?)-->/",$this->ADT['view'] , $matches);
        $mezotomb=$matches[1];
//  
//  print_r($matches[1]);
        if(is_array($mezotomb))
        {
            foreach($mezotomb as $mezo)
            {  
               $mezoT=explode('|', $mezo);
              
               $paramId=$mezoT[0] ;
               $namespace=$mezoT[1] ?? '*';
               $taskid=$mezoT[2] ?? '';
               
                    
                       $namespace=$this->ADT['paramT'][$paramId]['namespace'] ?? $namespace ;
                       $namespace=$this->ADT['TSK'][$task]['paramT'][$paramId]['namespace'] ?? $namespace ;
 //echo 'bbb'.$namespace;         
                       $viewF=$this->ADT['paramT'][$paramId]['viewF']  ?? '';
                       $viewF=$this->ADT['TSK'][$task]['paramT'][$paramId]['viewF']  ?? $viewF; 
                       
                       if($viewF!=''){
                          $iniclass=$this->ADT['view_iniclass'] ?? '';
                          $iniclass=$this->ADT['TSK'][$task]['paramT'][$paramId]['view_iniclass'] ?? $iniclass;
                           if($iniclass!='')
                           {
                               //eval('$view='.$this->ADT['iniclass'].'::Res(\''.$viewF.'\');') ;
                               $view=\trt\task\View::contentFromInit($iniclass, $viewF) ;
                           }
                           else
                           {
                               $view=\lib\base\File::getContent($viewF) ;
                           }
                       }
                    
               if($namespace!='*')
               {       
              // $parT=\lib\tomb\Param::getFromADT($this->ADT,$paramId ,$task,$taskid);
               $parT=$this->ADT['paramT'][$paramId] ?? [];
               $taskparT=$this->ADT['TSK'][$task]['paramT'][$paramId] ?? $parT;
               $parT=array_merge($parT,$taskparT);
//print_r($parT);            
               $parT['appId']=$paramId;
               $parT['taskId']=$taskid;
 //print_r($this->ADT);
//echo '****'.$namespace;
               $view=\App_s::Res($namespace,$parT);
               }     
                 
              
              $this->ADT['view']= str_replace('<!--:'.$mezo.'-->',$view , $this->ADT['view']);}  
              
            }
        }
      
    }



