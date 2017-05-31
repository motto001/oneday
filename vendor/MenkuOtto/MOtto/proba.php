<?php
function isAssoc( $arr)
{
    $keys = array_keys($arr);
    return array_keys($keys) !== $keys;
}

$arr=[['w'=>'q','g'=>'q'],['w'=>'q','g'=>'q'],['w'=>'q','g'=>'q']];

if(!isAssoc($arr)){echo 'true';}

//echo preg_replace("/(\/+)|(\\\\+)/", DIRECTORY_SEPARATOR, $text);
$t='Motto/app/tmpl';
echo substr($t, 6);
//echo '----'.substr($t, 5);
/*
class  a{
 public $ADT=['cl'=>'clclllc','link'=>'hhhhhhhhhhh'];   
 public function b()
 {
     $aT['key']='<a class="\'.$this->ADT[\'cl\'].\'" href="\'.$this->ADT[\'link\'].\'" data-remote="false"
                                   data-tg="tooltip" data-toggle="modal" data-target="#myModal"
                                   title="title" >\'.$this->ADT[\'cl\'].\'</br>\'.$this->ADT[\'link\'].\'</a>';
     
    eval('$a=\''.$aT['key'].'\';') ;
 
 echo $a;
 }
   
}
$text='last_name,//// first_////name\
bjorge,/ phi/lip
k//ardas/hian, kim\\\
me//rcury, fr///eddie // ////// ';
$a=new a();
$a->b();
*/