<?php
namespace app\login\trt\task;


defined('_MOTTO') or die('Restricted access');

trait Belep_oneday{

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
		{   $username=trim(\lib\ell\Get_S::Text('username',2,50));
		$jelszo=md5(trim(\lib\ell\Get_S::Text('password',2,50)));
		$sql="SELECT id,username,password FROM userek WHERE username='".$username."' or email='".$username."'";
		$userT=\lib\db\DB::assoc_sor($sql);
		//echo 'kkooo: '.$userT['password'].'---------'.$jelszo;
		$pass=$userT['password'] ?? '';
		if ($pass==$jelszo)
		{
			$_SESSION['userid'] =$userT['id'];
			$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			header("Location: $url"); /* ujratölt */
			exit();
		}
		else {$this->ADT['TSK'][$task]['next'] = 'belepform'; }
		}
	}
}
