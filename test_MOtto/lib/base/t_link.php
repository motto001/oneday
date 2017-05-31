<?php
namespace lib\base;

class T_LINK{

	static public function baselink(){
	
		echo "\n T_link::baselink: ";
		
		$_SERVER['REQUEST_URI']='http://infolapok.hu/index.php?gg=vv&gg2=vv2';
		//echo LINK::baselink();
		if(LINK::baselink()=='index.php'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_link']['baselink']='1';
		}	
		
		$_SERVER['REQUEST_URI']='index.php?gg=vv&gg2=vv2';
		if(LINK::baselink()=='index.php'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_link']['baselink']='2';
		}
		
		$_SERVER['REQUEST_URI']='';
		if(LINK::baselink()==''){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_link']['baselink']='3';
		}
		if(LINK::baselink('infolapok.hu/cc.php?gg=vv')=='infolapok.hu/cc.php'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_link']['baselink']='4';
		}
		//echo LINK::baselink('cc.php?gg=vv',false);
	}
	static public function GETtorolT(){
	
		echo "\n T_link::GETtorolT: ";
		
		$_SERVER['REQUEST_URI']='';
		//	echo LINK::GETtorolT(['gg2','gg']);
		if(LINK::GETtorolT(['gg2','gg'],'?gg=vv&gg2=vv2&gg=vv&hh=vv')=='?hh=vv'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_link']['GETtorolT']='1';
		}
		
		$_SERVER['REQUEST_URI']='';
		//	echo LINK::GETtorolT(['gg2','gg']);
		if(LINK::GETtorolT(['gg2','gg'],'index.php?gg=vv&gg2=vv2&gg=vv&hh=vv')=='index.php?hh=vv'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_link']['GETtorolT']='2';
		}
		$_SERVER['REQUEST_URI']='index.php?gg=vv&gg2=vv2&gg=vv&hh=vv';
//	echo LINK::GETtorolT(['gg2','gg']);
		if(LINK::GETtorolT(['gg2','gg'])=='index.php?hh=vv'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_link']['GETtorolT']='3';
		}
	//echo 'sss'.LINK::GETtorolT(['gg2','gg']);
		$_SERVER['REQUEST_URI']='index.php?gg=vv&gg2=vv2&gg=vv&';
		//echo LINK::baselink();
		if(LINK::GETtorolT(['gg2','gg'])=='index.php?x=x'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_link']['GETtorolT']='4';
		}
		$_SERVER['REQUEST_URI']='index.php?';
		//echo LINK::baselink();
		if(LINK::GETtorolT(['gg2','gg'])=='index.php?x=x'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_link']['GETtorolT']='5';
		}

	}
	static public function GETcsereT(){
	
		echo "\n T_link::GETcserelT: ";
	
		$_SERVER['REQUEST_URI']='?gg=vv&gg2=vv2&gg=vv&hh=vv';

		if(LINK::GETcsereT(['gg2'=>'cserelt','gg'=>'cserelt2'])=='?hh=vv&gg2=cserelt&gg=cserelt2'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_link']['GETcsereT']='1';
		}
	}
	
	
	
}


echo "TestLINK:------------- ";
T_LINK::baselink();
T_LINK::GETtorolT();
T_LINK::GETcsereT();
//T_OBb::testTomb();