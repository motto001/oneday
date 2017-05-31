<?php
namespace trt\ell;

defined( '_MOTTO' ) or die( 'Restricted access' );
trait Ell_Match{
	public  function Match($par)
	{	
	 $res=true;
	 eval('$parT='.$par.';');
	// print_r($parT);
	 $err=$parT[0] ?? 'no_match';
	 
	if($this->val!=$parT[0])
	{
	    \GOB::$messageT['err'][$err]="A két <<MEZO>> mező nem egyezik";
	    \GOB::$messageT['err']['#PAR_'.$err]=['MEZO'=>$this->mezonev] ;
	    $res = false; 
	}
	return $res;
	}}
/**
az LT tömböt már előtte fel kell tölteni! onnan veszi a hiba üzenetet
 */
trait Ell{	
public  function Ell()
{	
//    echo 'ell-----------';
$res=\lib\ell\Ell_S::Res($this->ADT);
$this->ADT=$res['ADT'];
return $res['bool'];
}}
