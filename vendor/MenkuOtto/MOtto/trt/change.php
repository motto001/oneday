<?php
namespace trt;

defined( '_MOTTO' ) or die( 'Restricted access' );
trait Change_SrcID{public function SrcID() {
 $this->ADT['view']= str_replace('src="ROOT/', 'src="'.\PATH::$rootDir.'/',$this->ADT['view'] )  ;
 $this->ADT['view']= str_replace('src="MOtto/', 'src="'.\PATH::$MOttoDir.'/',$this->ADT['view'] )  ; 
 $this->ADT['view']= str_replace('href="ROOT/', 'src="'.\PATH::$rootDir.'/',$this->ADT['view'] )  ;
 $this->ADT['view']= str_replace('href="MOtto/', 'src="'.\PATH::$MOttoDir.'/',$this->ADT['view'] )  ;
 
 $id=$this->ADT['id'] ?? '0';
  $getid= $_GET['id'] ?? '0';
 $this->ADT['view']= str_replace('<!--id-->', $id,$this->ADT['view'] )  ;
 $this->ADT['view']= str_replace('<!--getid-->', $getid,$this->ADT['view'] )  ;
} 
}
