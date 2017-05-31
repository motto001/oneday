<?php 
use lib\itemview\ItemView;
use lib\itemview\ItemView_lista;
use lib\base\OB;
$html='<item><!--#d1--></><><!--#d2--></itemveg>';
$dataT[]=['d1'=>'dd','d2'=>'cc'];
$dataT[]=['d1'=>'22dd','d2'=>'22cc'];
$parT=['html'=>$html,'dataT'=>$dataT];
//$lista=new ItemView_lista($parT);
//echo $lista->res($parT);
echo OB::res('lib\itemview\ItemView_lista',$parT);

//$fileT=ItemView::filelista('res/ico/16');

//ItemView::fileT_kiir($fileT);

?>