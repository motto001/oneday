<?php
namespace trt\task;
defined( '_MOTTO' ) or die( 'Restricted access' );

trait Pub{

    public function Pub()
    {
        \lib\db\DBA::tobb_pub($this->ADT['tablanev'], $_POST['idT']);

    }
    public function unPub()
    {
        \lib\db\DBA::tobb_unpub($this->ADT['tablanev'], $_POST['idT']);
    
    }
}

