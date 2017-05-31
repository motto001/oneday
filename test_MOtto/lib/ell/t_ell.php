<?php
namespace test\lib\ell;

use lib\ell\Ell;
use lib\ell\Ell_login;

class ADT{

	//fontos--------------------------
	public static $task='regment';
	public static $SPT=[];
	public static $LT=[];
	public static $modnev='log';//applikációknál nme kell
}
class Regx{
	static public $username=[['/^.{<<MIN>>,<<MAX>>}$/u','long_err',['MEZO'=>'username','MIN'=>'4','MAX'=>'20']],
			['HU_TOBB_SZO','spec_char_err']	];
	static public $email=	[['/^.{<<MIN>>,<<MAX>>}$/u','long_err',['MEZO'=>'email','MIN'=>'6','MAX'=>'50']],
			['MAIL','email_err']];
	static public $passwd=	[['/^.{<<MIN>>,<<MAX>>}$/u','long_err',['MEZO'=>'password','MIN'=>'6','MAX'=>'20']]];
}
class TASK{

	static public $regment=
	[
			'trt'=>'',
			'next'=>'regkesz',
			'ell'=>
			[
					'username'=>[],
					'email'=>[],
					'passwd'=>['match'=>'$_POST["passwd2"],"two_passwd_nomatch"'],
			]
	];


}
TASK::$regment['ell']['username']['regx']=Regx::$username;
TASK::$regment['ell']['email']['regx']=Regx::$email;
TASK::$regment['ell']['passwd']['regx']=Regx::$passwd;
class T_ell{

static public function ell(){

$_POST['username']='motto';
$_POST['email']='motto@gmailcom';
$_POST['passwd']='11111';
$_POST['passwd2']='111111';

ADT::$LT=['username'=>'usernév',
		'long_err'	=>'A(z) <<MEZO>> mezonerk min <<MIN>>, max <<MAX>> karakternek kell lenni!',
		'already_have'=>'ilyen mező már van!',
		'email_err'=>'Nem szabványos email!'];
$ell=new Ell_login(); 
$ADT=$ell->res(ADT::class,TASK::class);
		print_r($ADT::$SPT);
		print_r(\GOB::$hiba);
		
/*
		foreach($hibaT as $par){

			\GOB::$hiba['login']=[];
			Ell::regex($par, '/^.{3,5}$/u',$hibauz,'login');
			if(!isset(\GOB::$hiba['login'][0])){\GOB::$hiba['login'][0]='ok';}
			if(\GOB::$hiba['login'][0]==$hibauz){echo 'OK,';}else{echo '!!!,';
			\GOBT::$resT['T_ell']['strminmax']='hibaág';
			}
				
		}
	*/

		echo "\n";
	}

}
echo "T_ell:------------- \n";
T_ell::ell();


