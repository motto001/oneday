<?php
namespace lib\base;
defined( '_MOTTO' ) or die( 'Restricted access' );
class Testsemmiclass
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
    static public function testmodfunc($src)
    {
        $L_semmi_testsemmifun='Testmodclass_testappfun';
        ///$path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');
        //$path_parts['dirname'] /www/htdocs/inc
        $LTT_semmi_testsemmifun_szokoz = 'Testmodclass_testappfun_szokoz'   ;
        $path_parts = pathinfo($src);
        $ujsrc=$path_parts['dirname'].'/thumb/'.$path_parts['basename'];
        return  $ujsrc;
    }
}