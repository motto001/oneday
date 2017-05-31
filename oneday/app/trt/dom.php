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
// echo  $task;   
//echo '--------------------------'.$this->ADT['task'] ; 
        preg_match_all ("/<!--:([^`]*?)-->/",$this->ADT['view'] , $matches);
        $mezotomb=$matches[1];
//  
//  print_r($matches[1]);
        if(is_array($mezotomb))
        {//echo '--'.$task;   print_r($mezotomb)  ;
            foreach($mezotomb as $mezo)
            { 
               // echo '***'.$mezo;
               $mezoT=explode('|', $mezo);
              
               $paramId=$mezoT[0] ;
               $namespace=$mezoT[1] ?? '*';
               $taskid=$mezoT[2] ?? '';
               
                 
                       $viewF=$this->ADT['paramT'][$paramId]['viewF']  ?? '';
                       $viewF=$this->ADT['TSK'][$task]['paramT'][$paramId]['viewF']  ?? $viewF; 
                       $iniviewF=$this->ADT['paramT'][$paramId]['iniviewF']  ?? '';
                       $iniviewF=$this->ADT['TSK'][$task]['paramT'][$paramId]['iniviewF']  ?? $iniviewF;
                       
                       
                       if($viewF!=''){
                          $viewdir=$this->ADT['viewDir'] ?? '';
                          $viewdir=$this->ADT['TSK'][$task]['paramT'][$paramId]['viewDir'] ?? $viewdir;
                             if(isset($this->ADT['viewDir']))
                             {$viewF=$this->ADT['viewDir'].DS.$viewF;}
                             $view=\lib\base\File::getContent($viewF) ;
                           
                       }
                       if($iniviewF!=''){
                           $iniclass=$this->ADT['view_iniclass'] ?? '';
                           $iniclass=$this->ADT['TSK'][$task]['paramT'][$paramId]['view_iniclass'] ?? $iniclass;
                           if($iniclass!='')
                           {
                               $view=\trt\taskbase\View_byinit::contentFromInit($iniclass, $iniviewF) ;
                           }
                       
                       }
                       
               $namespace=$this->ADT['paramT'][$paramId]['namespace'] ?? $namespace ;
               $namespace=$this->ADT['TSK'][$task]['paramT'][$paramId]['namespace'] ?? $namespace ;    
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
                 
              
              $this->ADT['view']= str_replace('<!--:'.$mezo.'-->',$view , $this->ADT['view']);
            }  
              
            }
        }
      
    }



