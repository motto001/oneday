<?php
namespace trt\task;
defined( '_MOTTO' ) or die( 'Restricted access' );
trait View
{
use \trt\Dom_ChangeApp;
    public function View()
    {// echo '-------------';
        $task=$this->ADT['task'];
        $viewF=$this->ADT['viewF']  ?? '';
        $viewF=$this->ADT['TSK'][$task]['viewF'] ?? $viewF;
        $iniclass=$this->ADT['view_iniclass'] ?? '';
        $iniclass=$this->ADT['TSK'][$task]['view_iniclass'] ?? $iniclass;
        
        if($viewF!='')
        { 
            if($iniclass!='')
            {
//echo  'viewF:'.$viewF;
               $view=self::contentFromInit($iniclass, $viewF) ;
            }
            else
            {
                if(isset($this->ADT['viewdir'])){$viewF=$this->ADT['viewDir'].DS.$viewF;}
                $view=\lib\base\File::getContent($viewF);               
            }      
        } 
        $this->ChangeApp();
        $this->ADT['view']=$view;
    }
 /**
ha az iniclass létezik behívja vele a $viewF-t. 
Ha nem előbb a tmpl-ben majd az app-ban keresi az iniclasst. 
  */   
 static public function contentFromInit($iniclass,$viewF)
    { 
//echo '$view=tmpl\\'.\GOB::$tmpl.'\\'.$iniclass.'::Res("'.$viewF.'");';
        if(class_exists($iniclass))
        {  
            eval('$view='.$iniclass.'::Res("'.$viewF.'");');  
        }
        elseif(class_exists('tmpl\\'.\GOB::$tmpl.'\\'.$iniclass))
        {
           
            eval('$view=tmpl\\'.\GOB::$tmpl.'\\'.$iniclass.'::Res("'.$viewF.'");');
        }
  // echo '$view=tmpl\\'.\GOB::$tmpl.'\\'.$iniclass.'::Res("'.$viewF.'");';
        return $view;
    }

    

}

	