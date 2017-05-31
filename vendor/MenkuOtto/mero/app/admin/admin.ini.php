<?php
namespace app;

defined( '_MOTTO' ) or die( 'Restricted access' );

\GOB::$tmpl='admin'; 
$iniF=$_GET['iniF'] ?? 'userek';

if(is_file('app/admin/'.$iniF.'/'.$iniF.'.ini.php'))
{include 'app/admin/'.$iniF.'/'.$iniF.'.ini.php';}
else
{
 include 'app/admin/'.$iniF.'.ini.php';  
// echo 'app/admin/'.$iniF.'.ini.php'; 
 /*   
   
//minimál megoldás-------------------------
    class ADT
    {
        public static $view='Admin alap';
        public static $html='admin.html';
    }
*/
}
 
?>