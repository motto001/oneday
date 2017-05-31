<?php
namespace trt\mod;
defined( '_MOTTO' ) or die( 'Restricted access' );

trait Content {
    function Content() {
        $task=$this->ADT['task'];
        $viewF=$this->ADT['contentF']  ?? '';
        $viewF=$this->ADT['TSK'][$task]['contentF'] ?? $viewF;
        
        $app=$this->ADT['content'] ?? '' ;
        $app=$this->ADT['TSK'][$task]['content'] ?? $app;

       if($viewF!=''){ 
//
           if(isset($this->ADT['content_iniclass']))
           {
//echo '--------'. $this->ADT['content_iniclass'];            
               $view=self::contentFromInit($this->ADT['content_iniclass'],$viewF);}
           else{$view=\lib\base\File::getContent($viewF) ;}
           
       }
       if($app!=''){$view=\App_s::Res($app);}//a paramT- GOB-ból és az ADT-ből veszi (itt kell megadni)
    
      $this->ADT['view']= str_replace('<!--|content|-->', $view, $this->ADT['view']);
    }
    
}