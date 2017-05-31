<?php
namespace mod\pagin;
class Pagin
{
 public $ADT=[
 'appID'=>'Pagin',
 'taskID'=>'',//általában  a táblanév amihez tartozik
 'recordSum'=>500,
 'limit'=>3, //ennyi rekord jelenik meg egy oldalon
 'pages'=>1, // recordSum/limit  felfelé kerekítve a construktor állítja be
 'aktiv'=>1,
// 'tabnev'=>'Tab', 
 'before'=>6,
 'after'=>6

 ] ;
 public function __construct($parT=[])
 {
    // print_r($parT);
        $this->ADT=array_merge ($this->ADT,$parT);
        $this->ADT['aktiv']=$_GET[$this->ADT['getID'].'_pag'] ?? 1;

        $this->ADT['pages']=ceil($this->ADT['recordSum']/$this->ADT['limit'])+1;
 }
 
 public function Res()
 { $html='';
     if($this->ADT['recordSum']>$this->ADT['limit'])
     {
         $html='<nav aria-label="cimke"><ul class="pagination pagination-sm">
         <li class="page-item"><a class="page-link" href="#" aria-label="Previous">
         <span aria-hidden="true">&laquo;</span>
         <span class="sr-only">Previous</span></a></li>';
          $i=1;  
          while ($i<$this->ADT['pages'])
          {
              if($i==$this->ADT['aktiv'])
              {$aktiv='active';}else{$aktiv='';}
              
              $limitEnd=$i*$this->ADT['limit'];
              $limitStart= $limitEnd-$this->ADT['limit'];
              $linkT=[$this->ADT['getID'].'_pag'=>$i,$this->ADT['getID'].'_start'=>$limitStart];
              $link=\lib\base\LINK::GETcsereT($linkT);
              
              $html.=' <li class="page-item '.$aktiv.'"><a class="page-link" href="'.$link.'">'.$i.'</a></li>';
              $i++;
          }  
          
         $html.='<li class="page-item"> <a class="page-link" href="#" aria-label="Next">
         <span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>
         </a> </li> </ul></nav>'; 
          
     }
    return $html;
 }
}
 class Pagin_S
 {
   public static function Res($parT=[]){
       
      $ob=new Pagin($parT); 
      return $ob->Res(); 
   }   
     
 }
 
