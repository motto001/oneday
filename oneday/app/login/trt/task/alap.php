<?php
namespace app\login\trt\task;
defined( '_MOTTO' ) or die( 'Restricted access' );

trait Alap{ public function alap()
{  
    $task=$this->ADT['task'];
	if( $_SESSION['userid']==0){$this->ADT['TSK'][$task]['next']='belepform';}
	else{$this->ADT['TSK'][$task]['next']='kilepform';}

}}