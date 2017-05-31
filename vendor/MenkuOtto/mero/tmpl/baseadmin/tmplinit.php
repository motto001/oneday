<?php
namespace tmpl\baseadmin;

class Tmplinit{
  static public function Res() 
  {
    \GOB::$paramT['html']['bodyhead']['cssfile'][]=\lib\base\File::pathF('MOtto/tmpl/baseadmin/assets/body.css');
    \GOB::$paramT['html']['bodyhead']['docread'][]=\lib\base\File::getContent('MOtto/tmpl/baseadmin/assets/docread.js');   
   \GOB::$paramT['html']['head']['cssfile'][]=\lib\base\File::pathF('MOtto/tmpl/baseadmin/assets/bootstrap.min.css');
   // \GOB::$paramT['html']['head']['cssfile'][]=\lib\base\File::pathF('MOtto/vendor/bootstrap/bootstrap336maxcdn.css');
  //  \GOB::$paramT['html']['head']['jsfile'][]=\lib\base\File::pathF('MOtto/tmpl/baseadmin/assets/head.js');
    \GOB::$paramT['html']['head']['jsfile'][]=\lib\base\File::pathF('MOtto/vendor/jquery/jquery-1.9.1.min.js');
    \GOB::$paramT['html']['head']['jsfile'][]=\lib\base\File::pathF('MOtto/vendor/bootstrap/bootstrap.3.3.6.min.js');    
  }    
}
