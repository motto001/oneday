<?php
namespace trt;

defined( '_MOTTO' ) or die( 'Restricted access' );
trait Task_ADT_SetTask {
    public function SetTask(){
        $tasknev=$this->ADT['taskID'] ?? 'task';
        $task=$_GET[$tasknev] ?? 'alap';
		$task=$_POST[$tasknev] ?? $task;
		$this->ADT['task']=$task;
	//	$jog=$this->ADT['jog'] ?? 'admin';
//echo $this->ADT['task'];
		if(isset($this->ADT['jog']))
		{	
		    
            if(!\GOB::get_userjog($this->ADT['jog']))
            {
               $this->ADT['task']='joghiba';
               if(!isset($this->ADT['TSK']['joghiba']))
               {$this->ADT['TSK']['joghiba']['TRT']=['Joghiba'=>'\Base_Joghiba'];}
            }
		}
echo 'hhhhhhhh'.$task;

}}
trait Task {
/**
 set the globals (ADT,SESSION,GOB Stb..) from ADT['TSK'][$task]['evalString']
 add Joghiba to $trt
 */
    public function task_init()
    {
        $task=$this->ADT['task'];
        
        //változók beállítása: ADT, Session.. Pl.: 'evalString'=>'$_session["userid"]=1;'
        if(isset($this->ADT['TSK'][$task]['evalString']))
        { eval($this->ADT['TSK'][$task]['evalString']); }
        if(isset($this->ADT['TSK'][$task]['jog']))
        {
            
           if(!\GOB::get_userjog($this->ADT['TSK'][$task]['jog']))
            {
                $this->ADT['task']='joghiba';
                if(!isset($this->ADT['TSK']['joghiba']))
                {$this->ADT['TSK']['joghiba']['TRT']['Joghiba']=['\Base_Joghiba'];}
            }
        }
 //echo  'task:'.  $this->ADT['task']  ; 
     
       
    }
    public function task_futtat()
    {
        $task=$this->ADT['task'];
  //változók beállítása: ADT, Session.. Pl.: 'evalString'=>'$_session["userid"]=1;'
        if(isset($this->ADT['TSK'][$task]['evalString']))
        { eval($this->ADT['TSK'][$task]['evalString']); }
        
        $TRT=$this->ADT['TSK'][$task]['TRT'] ?? [];
 //print_r($this->ADT['TSK'][$task]['TRT']);
        $classnev=$this->ADT['appID'] ?? 'app';
        $classnev.=$task;
       // if(!class_exists($classnev, false)){}
        eval(\lib\base\Ob_TrtS::str($classnev,$TRT)); 
//echo \lib\base\Ob_TrtS::str($classnev,$trt);
        eval('$'.$classnev.'=new '.$classnev.'();');
        	
        $$classnev->ADT=$this->ADT;  
        
       //fügvnyek futtatása
        $funcT=$this->ADT['TSK'][$task]['funcT'] ?? [];
//print_r($_POST) ;        
//echo 'task:'. $task   ;   
//print_r($$classnev->ADT);

        if(empty($funcT)){$funcT=array_keys($TRT);}
        
        foreach ($funcT as $func)
        {
//echo 'func:'. $func   ;
            $$classnev->$func();
            if(!method_exists($$classnev,$func)){\GOB::$hibaT['Task'][]='hiányzik a '.$func.'() funkció ';}
        }
        	
        $this->ADT= $$classnev->ADT;
    }

/**
 ha még nincs,legenerál ehy ADT::$ppNev.$task nevű osztáyt 
 (ha nincs ADT::$appnev akkor  app.$task) ami használja a TSK::$task['trt'] traitet.
 ugyanilyen névvel példányosítja,
 ha van $TSK::${$task}['resfunc'] nevű függvénye futtatja azt
 ha van ADT::$task() nevű függvénye futtatja azt
 ha nincs akor az ADT::resfunc()-t
 ha egyik sincs leáll és hibát ír a GOB::logT'Task'][]-ba
 a függvények visszatérési értékének az új ADT-nek kell lenni.
 ezzel hívja meg újra saját magát de a task a  TSK::$next lesz
  ha ez nincs akkor nem hívja meg magát.
     */
    public function Task()
    {
        
        while ($this->ADT['task']!='')
        {
 //echo  'task:'.  $this->ADT['task']  ; 
 
         // $this->task_init();
           $this->task_futtat();
           $this->ADT['task']=$this->ADT['TSK'][$this->ADT['task']]['next'] ?? '';
//print_r(\GOB::$hibaT);    
        }

    }

}
