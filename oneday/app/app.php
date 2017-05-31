<?php
defined( '_MOTTO' ) or die( 'Restricted access' );

class AppBase 
{
    public $ADT=[];
    

public function setADT($namespace_full){
    
      // ha van init függvény lefuttatja és beállítja az ADT változókat 
        if(method_exists($namespace_full,'initADT'))
        {eval($namespace_full.'::initADT();');}
       
        $this->ADT=App_S::getADT($namespace_full) ;      
 //print_r($this->ADT)  ;       
}
public function appinit($namespace,$parT=[]){
// echo $namespace; 
        $namespaceADT=App_S::getNamespace_full($namespace);
//echo '***'.$namespaceADT;   
//ADT beállítása     
        $this->setADT($namespaceADT);
//print_r($this->ADT)  ;
        $this->ADT=array_merge($this->ADT,$parT); 
        $this->ADT['namespace']=$namespace;
//print_r($parT)  ;
        $baseTRT=$this->ADT['TRTbaseCH'] ?? [];
        $TRT=$this->ADT['TRT'] ?? [];
        $this->ADT['TRT']=array_merge($TRT,App_S::changeTRT($baseTRT));
if(isset($this->ADT['evalSTR'])){eval($this->ADT['evalSTR']);}
//print_r($this->ADT['dataT']);
   //ha van olyan paraméter a ADT-ben amit ini fájlok véglegesítenek és valamaelyik app használná PL.:appID,taskID
        if(method_exists($namespaceADT,'setParamT'))
        {eval($namespaceADT.'::setParamT();');} 
        
    }   
        

    
    public function __construct($namespace,$parT=[]){
        
        $this->appinit($namespace,$parT);
        $this->App();
    }

    public function App()
    {
  
        $funcT=$this->ADT['funcT'] ?? [];
        $TRT=$this->ADT['TRT'] ?? [];
//print_r($TRT) ; echo'--------------';    
        if(empty($funcT)){$funcT=array_keys($TRT);}
//print_r($funcT) ;
        foreach ($funcT as $func)
        {
            $this->$func();
        }
    }
}
//echo '---------';
class App_S
{
    static public function changeTRT($baseTRT){
     $TRT=[]; 
     foreach($baseTRT as $key=>$nms){
         if(isset(CONF::$baseTRT[$key] ) )
         {$TRT[$key]= CONF::$baseTRT[$key];}
     }
      return $TRT; 
    }
    
    static public function getADT($namespace_full)
    {
    
    if(method_exists($namespace_full,'getADT'))
    {
        eval('$ADT[\'ADT\'] ='. $namespace_full.'::getADT();');
//echo '$ADT ='. $namespace_full.'::getADT();';
//print_r($ADT);
    }
    else
    {
        $ADT = get_class_vars ($namespace_full) ;
    //echo $namespace_full;
    //print_r($ADT)  ;
        
        if(isset($ADT['TRT'])) { $ADT['ADT']['TRT']=$ADT['TRT'];}
        if(isset($ADT['TSK'])) {  $ADT['ADT']['TSK']=$ADT['TSK'];}
    
        if(isset($ADT['RGX']))
        {
            foreach ($ADT['ELL'] as $task=>$mezoT) {
        
                foreach ($mezoT as $mezonev => $ellT) {
                    if(isset($ADT['RGX'][$mezonev]))
                    {$ADT['ELL'][$task][$mezonev]['regx']=$ADT['RGX'][$mezonev] ; }
                }
            }
        }
        if(isset($ADT['ELL']))
        {
            foreach ($ADT['ELL'] as $task=>$mezoT) {
        
                $ADT['ADT']['TSK'][$task]['ELL']=$mezoT;
            }
        }
    }  
    // print_r($ADT)  ;
          return $ADT['ADT'];
    }
    static public function getNamespace_full($namespace)
    {    
        $namespace= strtolower($namespace);
        $classnevT=explode('\\', $namespace);
        $classnev=ucfirst(array_pop($classnevT)) ;
        $namespaceCUT= implode('\\',$classnevT);
//echo '\app\\'.$namespaceCUT.'-----';
 //echo '\app\\'.$namespace.'\\'.$classnev.'_ADT';
        //$namespace ='admin\userek';
        if(class_exists('\app\\'.$namespace.'\\'.$classnev.'_ADT'))
        {$namespace_full ='\app\\'.$namespace.'\\'.$classnev.'_ADT' ;}
        elseif (class_exists('\app\\'.$namespace.'\ADT'))
        {$namespace_full ='\app\\'.$namespace.'\ADT' ;}
        elseif(class_exists('\app\\'.$namespaceCUT.'\\'.$classnev.'_ADT'))
        {$namespace_full ='\app\\'.$namespaceCUT.'\\'.$classnev.'_ADT' ;}
        elseif (class_exists('\app\\'.$namespaceCUT.'\ADT'))
        {$namespace_full ='\app\\'.$namespaceCUT.'\ADT' ;}
        else{$namespace_full =$namespace; \GOB::$logT['App_S']['getADT']='Nincs érvényes ADT a névtérben.';}
    
        return $namespace_full;
    }
    static public function get_TRT($namespace)
    {
      $namespace_full =self::getNamespace_full($namespace);
//echo    ' ggg '. $namespace_full; 
        $ADT = self::getADT($namespace_full) ;
        $TRT= $ADT['TRT'] ?? $ADT['ADT']['TRT'] ?? []; 
//print_r($TRT ) ;      
       return $TRT;
    }
    
    
    static public function resOB($namespace,$parT=[])
    {
         $TRT=self::get_TRT($namespace);
         $c=true; $classnev='app_'.str_replace('\\','_' , $namespace);$i=1;
         while ($c==true) 
         {
            if(class_exists($classnev)){$classnev.=$i;}else{$c=false; } 
            $i++;  
         }
        
       // $appnev='app'.round(microtime(true)*1000);
//echo \lib\base\Ob_TrtS::str( $appnev,$TRT,'AppBase');
        eval(\lib\base\Ob_TrtS::str( $classnev,$TRT,'AppBase'));
    
        return new $classnev($namespace,$parT);
    }
    static public function resADT($namespace,$parT=[])
    {
        $ob=self::resOB($namespace,$parT);
 // print_r($ob->ADT);
        return $ob->ADT;
    }
    static public function Res($namespace,$parT=[]) 
    {      
        return self::resADT($namespace,$parT)['view'];   
    } 
}




//$app=new App();
