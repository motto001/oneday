<?php
error_reporting(E_ALL);
ini_set("display_errors","1");
//header('Access-Control-Allow-Origin: *'); 
//header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
//header('Access-Control-Allow-Credentials: true');
class PATH
{
 public static $rootDir= 'oneday'; 	
 //public static $rootDir= 'omnihund';   
 public static $MOttoDir= 'vendor'.DIRECTORY_SEPARATOR.'MenkuOtto'.DIRECTORY_SEPARATOR.'MOtto';    
}
//include_once('vendor/MenkuOtto/MOtto/autoload.php'):
include_once 'vendor'.DIRECTORY_SEPARATOR.'MenkuOtto'.DIRECTORY_SEPARATOR.'MOtto'.DIRECTORY_SEPARATOR.'autoload.php';
include_once 'vendor'.DIRECTORY_SEPARATOR.'MenkuOtto'.DIRECTORY_SEPARATOR.'MOtto'.DIRECTORY_SEPARATOR.'motto.php';
$Motto=new Motto();
