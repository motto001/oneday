<?php
define("DS", DIRECTORY_SEPARATOR); 

function betolt($namespacefull)
{
//echo '||'.$namespacefull.'||'; 
   // $className = ltrim($className, '\\');
   $betoltve=false;
    $fileName  = '';
    $namespace = '';
    $className =ltrim($namespacefull);
   // $classT=explode('\\', $namespacefull);
   // $className=array_pop($classT);
   // $namespace = implode('\\',$classT );
  if ($lastNsPos = strrpos($namespacefull, '\\')) 
    {
        $namespace = substr($namespacefull, 0, $lastNsPos);
        $className = substr($namespacefull, $lastNsPos + 1);
    }
    $classF= explode('_',$className)[0];//strstr($className, '_', true);
//echo 'classF:'.$classF.'---';
    $fileName  = str_replace('\\', DS, $namespace) . DS.$classF.'.php';
	
	
    $fileName = ltrim($fileName, '\\');
	$fileName = ltrim($fileName, '/');
	$filepath=$fileName;
   // $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
   $fileName =strtolower($fileName);//saját (kisbetűsítés) linux ext2.ext3 kellhet
   
    if(substr($fileName, 0,5)=='MOtto')
    {
        $fileName=substr($fileName, 5);
        $fileName = ltrim($fileName, '\\');
        $filepath=  PATH::$MOttoDir.DS.$fileName;
		$betoltve=true;
    }
    else
    {
		//$fileName =lcfirst($fileName); //elég a strtolower helyett 
         if(is_file(PATH::$rootDir.DS.$fileName) )
         {   
             $filepath= PATH::$rootDir.DS.$fileName; //echo PATH::$rootDir.DS.$fileName;
			 $betoltve=true;
			 
         }
         else if(is_file(PATH::$MOttoDir.DS.$fileName)) 
         {
              $filepath= PATH::$MOttoDir.DS.$fileName ;//echo PATH::$MOttoDir.DS.$fileName ;
			 $betoltve=true;
			 
         }
		 
      //  else if(is_file($fileName)) { require_once  $fileName;}
    }
	
if(!$betoltve){
 //echo $namespacefull.'||'. $filepath.'----------';}
 }
	if(is_file($filepath)){require_once  $filepath ;} //is file!!! kell mert különben elnyomja a hibaüzenetet;

   

}
spl_autoload_register('betolt');

