<?php
namespace app\pagin;
class Pagin_ADT
{
 public static $ADT=[
 'appID'=>'Pagin',
 'taskID'=>'',//ha több pagin  is van ez a get előtag (pl.: tab1_)
 'pages'=>1, // recordSum/limit  paraméterben kell megadni
 'aktiv'=>1,
  'TRT'=>['Pagin_Res'=>'app\pagin\Pagin_Res'] ,  
// 'tabnev'=>'Tab', 
 'before'=>6,
 'after'=>6 ] ;
 
public static function initADT(){
    
    self::$ADT['aktiv']=$_GET[self::$ADT['taskID'].'page'] ?? 1;
    if(self::$ADT['aktiv']<1){self::$ADT['aktiv']=1;}
    if(self::$ADT['aktiv']<1){self::$ADT['aktiv']=1;}
}
}

trait Pagin_Res 
{
 public function Pagin_Res()
 { $html='';$start=1; $end=$this->ADT['pages']; $aktiv=$this->ADT['aktiv'];
 
 if(($aktiv-$this->ADT['before'])>1){$start=$aktiv-$this->ADT['before'];}
 if(($aktiv+$this->ADT['after'])<$end){$end=$aktiv+$this->ADT['after'];}
 //if($end>$this->ADT['pages']){$end=$this->ADT['pages'];}
 //echo $this->ADT['pages'];
     if($this->ADT['pages']>1)
     { $i=1;
     
        $html='<nav aria-label="cimke"><ul class="pagination pagination-sm">';
        
        if($start>1)
        {
            $linkT=[$this->ADT['taskID'].'page'=>$i-1];
            $link=\lib\base\LINK::GETcsereT($linkT);
            $html.='
         <li class="page-item"><a class="page-link" href="'.$link.'" aria-label="Previous">
         <span aria-hidden="true">&laquo;</span>
         <span class="sr-only">Previous</span></a></li>';       
        }
                
          while ($i<=$end)
          {
              if($i==$this->ADT['aktiv'])
              {$aktiv='active';}else{$aktiv='';}

              $linkT=[$this->ADT['taskID'].'page'=>$i];
              $link=\lib\base\LINK::GETcsereT($linkT);
              
              $html.=' <li class="page-item '.$aktiv.'"><a class="page-link" href="'.$link.'">'.$i.'</a></li>';
              $i++;
          }  
          
          if($end<$this->ADT['pages'])
          {
              $linkT=[$this->ADT['taskID'].'page'=>$i+1];
              $link=\lib\base\LINK::GETcsereT($linkT);
         $html.='<li class="page-item"> <a class="page-link" href="'.$link.'" aria-label="Next">
         <span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>
         </a> </li> </ul></nav>';      
         }
         $html.='</ul></nav>';
     } 
 $this->ADT['view'] =$html;
 }
}
 class Pagin_S
 {
     public static function simple($page,$parT=[]){
          
         $parT['page']=$page;
         return \App_s::Res('icon',$parT);
     } 
     
     
   public static function Res($parT=[]){
    return \App_s::Res('icon',$parT);
   }   
     
 }
 
