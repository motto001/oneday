<?php
namespace lib\base;
defined( '_MOTTO' ) or die( 'Restricted access' );
class Testadminclass
{
    /*	static public function baselink($link='',$full=false)
     {	$urlhost='';$urlpath='';
   		if($link==''){$link=$_SERVER['REQUEST_URI']; }

   		}*/
    /**
     * a kép neve elé teszi a /thumb-ot (thumb elérési útját állítja elő
     * @param $src
     * @return string
     */
    static public function testadminfunc($src)
    {\GOB::$LT['Test_err_testappfun']= 'Testadminclass testappfun';
        $LT_Test_adminclass_testappfun='Testadminclass_testappfun';
        ///$path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');
        //$path_parts['dirname'] /www/htdocs/inc
        \GOB::$LT['Test_err_testappfun_szokoz'] = 'Testadminclass testappfun_szokoz'   ;
        $path_parts = pathinfo($src);
        $ujsrc=$path_parts['dirname'].'/thumb/'.$path_parts['basename'];
        return  $ujsrc;\GOB::$LT['Üres Test_err_testappfun'];
    }
}