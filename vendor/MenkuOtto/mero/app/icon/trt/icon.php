<?php
namespace app\icon\trt;

Trait Icon
{


    public function Icon()
    { 
      //$this->ADT['iconDir']=\PATH::$MOttoDir.DS.$this->ADT['iconDir'];
     // $this->ADT['iconDir']=\lib\base\File::pathD($this->ADT['iconDir']);
      $simpletype= \CONF::$simpleIconType ?? $this->ADT['simpleType']; 
      
      eval('$this->ADT[\'iconview\'] =\''.$this->ADT['simpleTypeT'][$simpletype].'\';');
       $this->ADT['label'] =\GOB::$LT[$this->ADT['task']] ?? $this->ADT['task'];
       eval('$this->ADT[\'label\'] =\''.$this->ADT['labelTypeT'][$this->ADT['labelType']].'\';');
       
       if($this->ADT['clickType']=='none')
       {
           $this->ADT['view']=$this->ADT['iconview'];
       }
        else 
        {
          eval('$this->ADT[\'view\'] =\''.$this->ADT['clickTypeT'][$this->ADT['clickType']].'\';');
        }
// echo $this->ADT['clickType'];
    }

}


Trait Icon_Sor
{ 
use \app\icon\trt\Icon;
  
    public function Icon_Sor()
    {
       $res='<div style="float:right;margin:20px;">';
        foreach ( $this->ADT['iconsorT'] as $key=>$task) {
            if(is_array($task))
            {
                $this->ADT['task'] = $key;
                $type=$task['type'] ?? 'task'; 
                $paramT=$this->ADT['typeT'][$type] ?? [];
                $paramT=array_merge($paramT,$task);
                $this->ADT=array_merge($this->ADT,$paramT);
            }
            else
            {
             $this->ADT['task'] = $task;
             $this->ADT=array_merge($this->ADT,$this->ADT['typeT']['task']);
            }
            $this->Icon();
            $res.=$this->ADT['view'];
        }
        $res.='</div><div style="clear:both;"></div>';
        $this->ADT['view']=$res;

    }
}





