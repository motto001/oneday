<?php
namespace app\login\trt\task;
defined( '_MOTTO' ) or die( 'Restricted access' );

trait Kilep{ public function kilep()
{	
echo 'kilep';
    $_SESSION['userid']=0;
	 $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];   
	 
     header("Location: $url"); /* ujratölt */
		exit();
}}