<?php
session_start();
define("_MOTTO", "igen");

include PATH::$MOttoDir.DS.'gob.php';
include PATH::$rootDir.DS.'conf.php';
if(CONF::$offline && !GOB::get_userjog('admin'))
{die(CONF::$offline_message);}

class MOtto{
 public function setTMPL(){
    $app= GOB::$app =$_GET['app'] ?? CONF::$baseApp;
//template nev-------------------------    
   if(substr($app, 0,5)=='admin')
    {
        $tmpl =$_GET['admintmpl'] ?? CONF::$adminTmpl;
    } 
    else{$tmpl=$_GET['tmpl'] ?? CONF::$baseTmpl;
        if(isset($_GET['chtmpl'])){$_SESSION['chtmpl']=$_GET['chtmpl'];};
        if(isset($_SESSION['chtmpl'])){$tmpl=$_SESSION['chtmpl'];}
    }
    
//template dir--------------------------------------    
     if(substr($tmpl, 0,5)=='MOtto')
     { 
        $tmplDir='tmpl'.DS.substr($tmpl,6);
        GOB::$tmplDir=PATH::$MOttoDir.DS.$tmplDir; 
     }
     elseif(substr($tmpl, 0,4)=='root')
     {
        $tmplDir='tmpl'.DS.substr($tmpl,5);
        GOB::$tmplDir=PATH::$rootDir.DS.$tmplDir;
     }
     else{    
         $tmplDir='tmpl'.DS.$tmpl;
         GOB::$tmplDir=\lib\base\File::pathD($tmplDir); 
//echo GOB::$tmplDir.'---'.$tmplDir.'--';
     }    
         GOB::$tmpl=$tmpl;
         GOB::$tmplNamespace=str_replace('/', '\\', $tmplDir);      
     
  if(class_exists(GOB::$tmplNamespace.'\\Tmplinit'))
  {$tmplinitfunc=GOB::$tmplNamespace.'\\Tmplinit::Res';$tmplinitfunc();}
 // echo GOB::$tmplNamespace.'---'.$tmplDir;
 }   
    
 public function img_out($imagesrc){
//$imagesrc= \PATH::$rootDir.'/'.$imagesrc;
     $imglang=$_GET['imglang'] ?? 'false';
     if($imglang=='auto'){$imglang=\GOB::$lang;}
     
    $imagesrc= \lib\base\File::pathF($imagesrc);
    
//echo '*********'.$imagesrc;  
     if (file_exists($imagesrc)) 
     {//this can also be a png or jpg  
         //Set the content-type header as appropriate
      //   $imageInfo = getimagesize($fileOut);
          if($imglang!='false')
          { 
             $path_parts = pathinfo($imagesrc);

             $imagesrc2=$path_parts['dirname'].$path_parts['filename'].'_'.$imglang.'.'.$path_parts['extension'];
  
             if(file_exists($imagesrc2)){$imagesrc=$imagesrc2;} 
          }

      $imageInfo = getimagesize($imagesrc);
         switch ($imageInfo[2]) {
             case IMAGETYPE_JPEG:
                 header("Content-Type: image/jpeg");
                 break;
             case IMAGETYPE_GIF:
                 header("Content-Type: image/gif");
                 break;
             case IMAGETYPE_PNG:
                 header("Content-Type: image/png");
                 break;
             default:
                 break;
         }   
         // Set the content-length header
         header('Content-Length: ' . filesize($imagesrc));    
         // Write the image bytes to the client
         readfile($imagesrc);
     }     
 }   

 public function file_out($file) 
 {
     $file=\PATH::$rootDir.'/'.$file;
     $allowedT=['js','css'];
     $ext=pathinfo ( $file,PATHINFO_EXTENSION);
     if(in_array($ext, $allowedT))
     {   
        // $contents= file_get_contents(PATH::$rootDir.'/'.$file,true);  
         $handle = fopen($file, "r");
         $contents = fread($handle, filesize($file));
         fclose($handle);
         
        Header('Content-Type: text/css'); 
        Header('Content-Length: '.strlen($contents)); 
        //Header('Content-disposition: inline; filename=newdoc.rtf'); 
        echo $contents;  
        // include \PATH::$rootDir.'/'.$file;
     }
   
 }

 static public function resApp($app) 
 {
    
      
     if(substr($app, 0,1)=='*')
     {  
         $namespace=substr($app, 1);
         $classnevT=explode('\\', $namespace);
         $classnev=ucfirst(array_pop($classnevT)) ;
         eval('$html= \app\\'.$namespace.'\\'.$classnev.'_S::Res();');
        // \GOB::$app=$classnev;
     }
     else
     {
         $html= App_S::Res( $app);
       //  $classnevT=explode('\\', $namespace);
       //  $classnev=ucfirst(array_pop($classnevT));
        // \GOB::$app=$classnev;
// echo 'htmlk:'.$html  ;      
     }
     return $html;
 }
 
public function azonosit() {
      if(isset($_POST['ltask']) && $_POST['ltask']=='kilep'){ $_SESSION['userid'] = 0;}
     $azon= new \lib\jog\Azonosit();
     GOB::$userT=$azon::set_userdata($_SESSION['userid']);
     GOB::set_userjog();
 }
 public function __construct(){
    if(isset($_GET['imgout'])) {
        $this->img_out($_GET['imgout']);
    }
    elseif (isset($_GET['fileout']))
    {
        $this->file_out($_GET['fileout']);
    }
    else 
    {
     //GOB::$db-be létrehozza az adatbázis objektumot
     lib\db\Connect::connect();
     
     //azonosítás-------------
     $this->azonosit();

     //applikáció becsatolás-----------------------------
     $app=$_POST['app'] ?? CONF::$baseApp;
     $app=$_GET['app'] ?? $app;
     $app=str_replace('|', '\\', $app);
     
     $this->setTMPL();
     
     GOB::$html=self::resApp($app);
     
     //érvényes parT kulcsok:['head','bodyhead','bodyfoot'] 
     lib\html\Fejlec_s::ChangeFull();
     echo GOB::$html;
   /* $sql="select * from szallasfotok_old";
    $fotoT= lib\db\DB::assoc_tomb($sql);
    foreach($fotoT as $fotoS){
        $foto='/images/nagykepek/'.$fotoS['id'].'.jpg';

       echo $sql="INSERT INTO szallasfotok (szallasid,foto) VALUES ('".$fotoS['szallasid']."','".$foto."')";
        
        \lib\db\DBA::parancs($sql);
    }*/
    }
 }   
       
}


