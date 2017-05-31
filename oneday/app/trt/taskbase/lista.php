<?php
namespace trt\taskbase;
defined( '_MOTTO' ) or die( 'Restricted access' );
trait Lista
{
   static public function listaz($html,$dataT)
    {
       $res='';
    //   print_r($dataT);
       foreach($dataT as $dataS){
           $dataS['onclick']="beszur_item('".$dataS['id']."');";
           $res.=\lib\html\dom\Dom_s::ChangeData($html, $dataS);
       }
       return $res;
   }
       
    
    public function Lista()
    {// echo '-------------';
        $task=$this->ADT['task'];

        $viewF=$this->ADT['listaF']  ?? '';
        $viewF=$this->ADT['TSK'][$task]['listaF'] ?? $viewF;;
        $viewdir=$this->ADT['view_dir'] ?? '';
        $viewdir=$this->ADT['TSK'][$task]['view_dir'] ?? $viewdir;

        if($viewF!='')
        {
            if(isset($this->ADT['viewdir'])){$viewF=$this->ADT['viewDir'].DS.$viewF;}
            $html=\lib\base\File::getContent($viewF);

        }

        $this->ADT['view']=self::listaz($html, $this->ADT['dataT']);

        
    }
    public function Lista_byini()
    {// echo '-------------';
      $task=$this->ADT['task'];
       // echo $task;
        $viewF=$this->ADT['listaF']  ?? '';
        $viewF=$this->ADT['TSK'][$task]['listaF'] ?? $viewF;
        $iniclass=$this->ADT['view_iniclass'] ?? '';
        $iniclass=$this->ADT['TSK'][$task]['view_iniclass'] ?? $iniclass;
        
        if($viewF!='' && $iniclass!='')
        { 
           $html=self::contentFromInit($iniclass, $viewF) ;       
        } 
    
    $this->ADT['view']=self::listaz($html, $this->ADT['dataT']);
  
    
    }

}

