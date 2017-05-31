<?php
namespace tmpl\baseadmin;

class Tmplinit{
  static public function Res() 
  {

      \GOB::$paramT['html']['bodyhead']['cssfile'][]=\lib\base\File::pathF('MOtto/tmpl/baseadmin/assets/body.css');
     // \GOB::$paramT['html']['head']['docread'][]=\lib\base\File::getContent('MOtto/tmpl/baseadmin/assets/docread.js');
      \GOB::$paramT['html']['head']['cssfile'][]=\lib\base\File::pathF('MOtto/vendor/bootstrap/bootstrap337/css/bootstrap.min.css');
      // \GOB::$paramT['html']['head']['cssfile'][]=\lib\base\File::pathF('MOtto/vendor/bootstrap/bootstrap336maxcdn.css');
      //  \GOB::$paramT['html']['head']['jsfile'][]=\lib\base\File::pathF('MOtto/tmpl/baseadmin/assets/head.js');
      \GOB::$paramT['html']['head']['jsfile'][]=\lib\base\File::pathF('MOtto/vendor/jquery/jquery-1.9.1.min.js');
      \GOB::$paramT['html']['head']['jsfile'][]=\lib\base\File::pathF('MOtto/vendor/bootstrap/bootstrap337/js/bootstrap.min.js');
 	  \GOB::$paramT['html']['head']['docread'][]=\lib\base\File::getContent('MOtto/tmpl/baseadmin/assets/docread.js');
 	  // \GOB::$paramT['html']['head']['js'][]='var $_POST = '.json_encode($_POST);
$pst="";
if(isset($_POST['limit'])){$pst=" var limit = '".$_POST['limit']."';";}else{$pst="var limit;";}
if(isset($_POST['kijelol'])){  $pst.=" var kijelol = '".$_POST['kijelol']."';";}{$pst.="var kijelol;";}
if(isset($_POST['szures'])){$pst.=" var szures = '".$_POST['szures']."';";}{$pst.="var szures;";}
$betolt=" function modal_betolt(link,loadID='modalbase') 
    {	$('#'+loadID).load(link);	}";
\GOB::$paramT['html']['head']['js'][]=$pst.$betolt;
  
  }  
      }    

