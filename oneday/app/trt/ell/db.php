<?php
namespace trt\ell;
use lib;

defined( '_MOTTO' ) or die( 'Restricted access' );

trait DB_Marvan{

public  function Marvan($parT)
{   
    $mezonev=$parT[0] ?? '';
    if($mezonev==''){$mezonev =$this->mezonev;}
    $tablanev=$parT[1] ?? '';
    if($tablanev==''){$tablanev =$this->ADT['tablanev'] ;}
    $err=$parT[2] ?? '';
    if($err==''){$err =$this->ADT['already have'] ;}
	$res=true;
	$sql = "SELECT " . $mezonev . " FROM  " .$tablanev. " WHERE " . $mezonev . "='" . $this->val . "'";
	$marvan = lib\db\DB::assoc_sor($sql);
	if (isset($marvan[$mezonev])) 
	{   \GOB::$messageT['err'][$err]="Már van ilyen <<MEZO>>" ;
	    \GOB::$messageT['err']['#PAR_'.$err]=['MEZO'=>$mezonev] ;
	    $res= false; 
	}

	return $res;
}
}

/**
csak bejelentkezéshez használjuk! beállítja a $_SESSION['userid'];
 */
trait DB_ValidPasswd{
public  function ValidPasswd($err='Passwd_error'){
   
	
//	if($this->ADT['ellerr'])
	//{   
    $md5passwd=md5($this->val);
 // print_r($this->ADT['SPT'])   ;
    	if(isset($this->ADT['SPT']['username']) )
    	{      	
        	$sql="SELECT id, password FROM userek WHERE username='".$this->ADT['SPT']['username']."' AND pub='0'";
        	$dd=lib\db\DB::assoc_sor($sql);
        	//echo $sql;	 
    	}
    	else 
    	{
    	   //akkor kell ha már bejelentkezett de jelszó megerősítésre van szükség pl.: jelszócsere 
    	    $sql="SELECT id, password FROM userek WHERE id='".$_SESSION['userid'] ."' AND pub='0'";
    	    $dd=lib\db\DB::assoc_sor($sql);
    	}
	
    	$password=$dd['password'] ?? '';
//echo $password.'------'.$md5passwd  ;  
    	if($md5passwd == $password)
    	{
    	    $_SESSION['userid']=$dd['id'];//!!! fontos bejelentkezésnél máskor meg nem számít mert úgyis ennyi
    	    $res=true;
    	}    
    	else
    	{
    	    $res = false;
    	    \GOB::$messageT['err'][$err]="Hibás felhasználónév vagy jelszó!";
    	}  	    

//	}  	
	return $res;
}}

