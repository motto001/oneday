<?php
namespace lib\base;
defined( '_MOTTO' ) or die( 'Restricted access' );
class Testmodclass
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
        $LT_Testmodclass_testmodfun='Testmodclass_testmodfun';
        ///$path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');
        //$path_parts['dirname'] /www/htdocs/inc
        $LT_Testmodclass_testmodfun_szokoz = 'Testmodclass_testmodfun_szokoz'   ;
        $path_parts = pathinfo($src);
        $ujsrc=$path_parts['dirname'].'/thumb/'.$path_parts['basename'];
        return  $ujsrc;
    }
}