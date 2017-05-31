<?php
define("DS", DIRECTORY_SEPARATOR); 

function betolt($namespacefull)
{
//echo '||'.$namespacefull.'||'; 
   // $className = ltrim($className, '\\');
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
   // $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $fileName =strtolower($fileName);//saját (kisbetűsítés) nem igazán kell
    if(substr($fileName, 0,5)=='MOtto')
    {
        $fileName=substr($fileName, 5);
        $fileName = ltrim($fileName, '\\');
        require_once  PATH::$MOttoDir.DS.$fileName;
    }
    else
    {
         if(is_file(PATH::$rootDir.DS.$fileName) )
         {   
             require_once  PATH::$rootDir.DS.$fileName; //echo PATH::$rootDir.DS.$fileName;
         }
         else if(is_file(PATH::$MOttoDir.DS.$fileName)) 
         {
             require_once PATH::$MOttoDir.DS.$fileName ;//echo PATH::$MOttoDir.DS.$fileName ;
         }
      //  else if(is_file($fileName)) { require_once  $fileName;}
    }
   
}

spl_autoload_register('betolt');
