<?php
namespace trt\task;
defined( '_MOTTO' ) or die( 'Restricted access' );

trait Del{

    public function Del()
    {
        \lib\db\DBA::tobb_del($this->ADT['tablanev'], $_POST['idT']);

    }

}
