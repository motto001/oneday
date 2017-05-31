<?php
namespace app\login\trt\task;


defined('_MOTTO') or die('Restricted access');

trait Belep{
    
use \trt\ell\Ell;
    public function Belep()
    {
//echo 'ell-----------';
        $task=$this->ADT['task'];
        if ($_SESSION['userid'] != 0)
        {
             $this->ADT['TSK'][$task]['next'] = 'kilepform';
        } 
        else 
        {    
            if ($this->Ell()) 
            {
               $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];   
               header("Location: $url"); /* ujratölt */
                exit();
            }
            else {$this->ADT['TSK'][$task]['next'] = 'belepform'; }
        }
    }
}
