<?php
namespace lib\base;
defined( '_MOTTO' ) or die( 'Restricted access' );
class LINK
{  
/**
alapesetben az index.php-val(vagy ha más a filenév akkor azzal)
ha nincs üres stringgel térr vissza
ha a full=true a teljes domain+filenév (infolpaok.hu/index.php) 
a perjelet kérdőjelet eltávolítja; Ha paraméternek http:// nélküli limket adunk a teljes kérdőjel előtti linkel tér vissza
 */
/*	static public function baselink($link='',$full=false)
    {	$urlhost='';$urlpath='';
   		if($link==''){$link=$_SERVER['REQUEST_URI']; }
		$urlT=parse_url($link);
		//echo $urlT['path'];
		if(isset($urlT['host'])){$urlhost=$urlT['host'];}
		if(isset($urlT['path'])){$urlpath=$urlT['path'];}
		if($full){return $urlhost.$urlpath; }
		else{
			if(substr($urlpath,0,1)=='/'){return substr($urlpath, 1);}
			else {return $urlpath;}
			}
	
	}*/
    /**
     * a kép neve elé teszi a /thumb-ot (thumb elérési útját állítja elő
     * @param $src
     * @return string
     */
	static public function thumb_src($src)
	{ 
///$path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');
        //$path_parts['dirname'] /www/htdocs/inc
        //$path_parts['basename'] lib.inc.php
        //$path_parts['extension'] php
        //$path_parts['filename'] lib.inc
        $path_parts = pathinfo($src);
        $ujsrc=$path_parts['dirname'].'/thumb/'.$path_parts['basename'];
        return  $ujsrc;
    }
    
   /**
	LINK::GETtorolT(['gg2','gg'])
	a torolT -ben megadott get értékeket törli a linkből
    ha nem marad get érték, hozzátesz egy x=x-et hogy ne keljen a ?jellel foglalkozni
    */
    static public function GETtorolT($torolT,$link='')
    {
    	$getstr='';
    	if($link==''){$link=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];}
    	
    	$linkT=explode('?',$link);
    	$baselink='http://'.$linkT[0];
    	$par=$linkT[1] ?? '';
    	$parT=explode('&',$par);
    	foreach ($parT as $torol){
    		
    		$torT=	explode('=', $torol);
    		if(!empty($torT[0]) && !empty($torT[1]) && !in_array($torT[0], $torolT)){
    		$getstr.=$torol.'&';
    		}		  		 			
    	}
    	//if($getstr==''){$getstr='x=x&';}
    	//echo 'getstr'.$getstr;
    	return substr($baselink.'?'.$getstr, 0, -1); 	
    }
    /**
 	LINK::GETcsereT(['gg2'=>'cserelt','gg'=>'cserelt2']);
     */
   
    static public function GETcsereT($csereT,$link='')
    {
    	$torolT=[];	$cserestr='';
    	foreach ($csereT as $key=>$val)
    	{
    		$torolT[]=$key;
    		$cserestr.=$key.'='.$val.'&';
    	}
    	$csere=substr($cserestr, 0, -1);
    	//echo $csere;
    	$base=self::GETtorolT($torolT,$link);
    	return $base.'&'.$csere;
    }
    
/**
régi, paramétere string csak egyet tud cserélni nincs tesztelve
 */    
    static public function GETcsere($csere,$link='')
    {
        if($link==''){$link=$_SERVER['REQUEST_URI'];}
        // echo $link;
        $linktomb=explode('&',parse_url($link, PHP_URL_QUERY));
        // print_r($linktomb);
        if(empty($linktomb[0]))
        {
            return parse_url($link, PHP_URL_PATH).'?'.$csere;
        }
        else
        {
            $csereT=explode('=',$csere);
            $get_resz='';
            foreach($linktomb as $tag)
            {
                $altag = explode('=', $tag);
                if (($altag[0] != $csereT[0])&& isset($altag[1]))
                {
                    $get_resz = $get_resz . $altag[0].'='.$altag[1].'&';
                }
            }
            //$get_resz =substr($get_resz, 0, -1);
            $get_resz = $get_resz.$csere;
            return parse_url($link, PHP_URL_PATH).'?'.$get_resz;
        }
    }

}


