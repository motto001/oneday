<?php
namespace trt;

defined( '_MOTTO' ) or die( 'Restricted access' );

trait Set_ID{
    public function Set_ID() {
        $id=$_POST['idT'][0] ?? 0;
        $id=$_POST['id'] ?? $id;
        $id=$_GET['id'] ?? $id;
 ///echo '--------'.$id;
        $this->ADT['id']=$id;
        $this->ADT['dataT']['id']=$id;
        
    }

}