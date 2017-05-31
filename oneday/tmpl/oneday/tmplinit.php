<?php
namespace tmpl\oneday;

class Tmplinit{
  static public function Res() 
  {    
  //  \GOB::$paramT['html']['bodyhead']['cssfile'][]=\lib\base\File::pathF('ROOT/tmpl/oneday/app/oneday/slider.css');
  //  \GOB::$paramT['html']['head']['jsfile'][]=\lib\base\File::pathF('ROOT/tmpl/oneday/app/oneday/jssor.slider-21.1.6.min.js');   
  //  \GOB::$paramT['html']['bodyhead']['js'][]=\lib\base\File::getContent('ROOT/tmpl/oneday/app/oneday/slider.js');
     if(isset(\GOB::$userT['id']) && \GOB::$userT['id']!=0){
     \GOB::$paramT['html']['head']['js'][]="var userid='".\GOB::$userT['id']."'; var nev='".\GOB::$userT['name']."'; var email='".\GOB::$userT['email']."' ";
        
     }
      
   // \GOB::$paramT['html']['head']['cssfile'][]=\lib\base\File::pathF('MOtto/vendor/bootstrap/bootstrap336maxcdn.css');
  //  \GOB::$paramT['html']['head']['jsfile'][]=\lib\base\File::pathF('MOtto/tmpl/baseadmin/assets/head.js');
  //  \GOB::$paramT['html']['head']['jsfile'][]=\lib\base\File::pathF('MOtto/vendor/jquery/jquery-1.9.1.min.js');
  //  \GOB::$paramT['html']['head']['jsfile'][]=\lib\base\File::pathF('MOtto/vendor/bootstrap/bootstrap.3.3.6.min.js');
  }
}
