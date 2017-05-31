<?php
namespace lib\base;

class T_base{

	static public function getGlob(){

		

		$_GET['task']='gettask';
		$_POST['task']='posttask';
		$_SESSION['task']='sesstask';
		
		
		echo 'gps [sess,post,get],task,alap: ';
		
		if(Base::getGlob('task','alap')=='gettask'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_base']['gps']='1';
		}
		if(Base::getGlob('nincs','alap')=='alap'){echo 'OK,';}
		else{echo '!!!,';
		\GOBT::$resT['T_base']['gps']='2';
		}
		if(Base::getGlob('task','alap',['POST'])=='posttask'){echo 'OK,';}else{
			echo '!!!,';
			\GOBT::$resT['T_base']['gps']='3';
		}
		if(Base::getGlob('task','alap',['POST','SESSION'])=='sesstask'){echo 'OK,';}else
		{echo '!!!,';
		\GOBT::$resT['T_base']['gps']='3';
		}
		unset($_SESSION['task']);
		if(Base::getGlob('task','alap',['POST','SESSION'])=='posttask'){echo 'OK,';}else
		{echo '!!!,';
		\GOBT::$resT['T_base']['gps']='3';
		}
		unset($_POST['task']);
		if(Base::getGlob('gg','',['POST','SESSION'])==''){echo 'OK,';}else
		{echo '!!!,';
		\GOBT::$resT['T_base']['gps']='3';
		}
		
		echo "\n";
	}

}	
	

echo "T_base:------------- \n";
T_base::getGlob();
