<?php
namespace lib\base;
//echo File::vanfile_plusz('base.php');

class File{
 static    public    function getFileFromClass($namespacefull)
 {
     $fileName  = '';
     $namespace = '';
     $classT=explode('\\', $namespacefull);
     $className=array_pop($classT);
     $namespace = implode('\\',$classT );
     $classF= explode('_',$className)[0];
     $fileName  = str_replace('\\', DS, $namespace) . DS.$classF.'.php';
     return  \lib\base\File::pathF($fileName);
  ;
     
 }
 static    public    function getDirFromClass($namespacefull)
 {
     $fileName  = '';
     $namespace = '';
     $classT=explode('\\', $namespacefull);
     $className=array_pop($classT);
     $namespace = implode('\\',$classT );
     $fileName  = str_replace('\\', DS, $namespace);
     return \lib\base\File::pathD($fileName);
      
 }    
/**
 megnézi előbb a rootban majd a MOttoban, 
 ha nem talál érvényes filet megnézi előtagokkal(#MOtto,#root) self::path()-al
 */ 
static    public    function getContent($filepath){ 
    
    $filepath=self::pathF($filepath);
   return file_get_contents($filepath,true);
    
} 
/**
 megnézi előbb a rootban majd a MOttoban, 
 ha nem talál érvényes filet megnézi előtagokkal(#MOtto,#root) self::path()-al
 */
static  public  function pathD($filepath){
$ok=true;   
$resB=$res=self::path( $filepath);
//echo $res.'--------';
if(is_dir($res)){ $ok=false;}
if($ok){
   $res= \PATH::$rootDir.DS.$filepath; 
// echo 'res:'.$res;
   if(is_dir($res)){$ok=false;}
}
if($ok){
    $res= \PATH::$MOttoDir.DS.$filepath;
    if(is_dir($res)){$ok=false;}
}
if($ok){$res=$resB;}
return  $res;
}
/**
 megnézi előbb a rootban majd a MOttoban, 
 ha nem talál érvényes filet megnézi előtagokkal(#MOtto,#root) self::path()-al
 */
static    public    function pathF($filepath){
 $ok=true;   
$resB=$res=self::path($filepath);   
if(is_file($res)){$ok=false;}
if($ok){
   $res= \PATH::$rootDir.DS.$filepath; 
   if(is_file($res)){$ok=false;}
}
if($ok){
    $res= \PATH::$MOttoDir.DS.$filepath;
    if(is_file($res)){$ok=false;}
}
if($ok){$res=$resB;}
return  $res;
}
/**
kicseréli az előtagokat (#MOtto,#root) és a könyvtárelválsztókat.DS-re
 */
static    public    function path($filepath){
      
   if(substr($filepath, 0,5)=='MOtto'){
       
       $filepath=substr($filepath, 5); 
 // echo 'ffffffffffffffff'.$filepath;      
        $filepath=\PATH::$MOttoDir.$filepath;
     
   } elseif (substr($filepath, 0,4)=='ROOT' || substr($filepath, 0,4)=='root'){
       
       $filepath=substr($filepath, 4); 
       $filepath=\PATH::$rootDir.$filepath;
   }

 $filepath=preg_replace("/(\/+)|(\\\\+)/",DS , $filepath);
 $filepath = ltrim($filepath, DS); //Ha van előtte könyvtár elvállasztó levágja
//echo $filepath;
  return  $filepath;
    
}
 static    public    function ReadCSV($filepath,$sep=','){
        $fileT=[];
        $file = fopen($filepath, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            $fileT[]=$line;
        }
        fclose($file);
        return $fileT;
    }    
 static   public    function toFile($content,$path,$utf8=true ){
        $fp = fopen($path, 'w');
        if($utf8) {fwrite($fp, "\xEF\xBB\xBF".$content);}
        else{fwrite($fp, $content);}
        fclose($fp);
    
    }	
/**
ha a mezőtomb üres az elsősorból veszi a mezőneveket
 */
static public function  readCSV_assocT($filepath,$sep=',',$mezoT=[]){
		$file = fopen($filepath, 'r');$fileT=[];$T=[];
		if(empty($mezoT)){$mezoT=fgetcsv($file);}	
		//print_r($mezoT);
		while (($line = fgetcsv($file)) !== FALSE) {
			foreach ($mezoT as $key=>$mezo){
				$value='';
				if(isset($line[$key])){$value=$line[$key];}
				$T[$mezo]=$value;
			}
			
		$fileT[]=$T;
		}
		fclose($file);
		return $fileT;
	}
	
static public function dirLista($dir){
	    $fileT=[];
	    if ($handle = opendir($dir)) {
	        while (false !== ($entry = readdir($handle))) {
	
	            if ($entry != "." && $entry != "..") {
	                if(is_dir($dir.'/'.$entry)){$fileT[]=$entry;}
	               
	            }
	        }
	        closedir($handle);
	    }
	    return $fileT;
	}	
static public function  lista($dir,$dirAllow=true){
		$fileT=[];
		if ($handle = opendir($dir)) {
		while (false !== ($entry = readdir($handle))) {
	
				if ($entry != "." && $entry != "..") {
					if(is_dir($dir.'/'.$entry)){if($dirAllow){$fileT[]=$entry;}}
					else{$fileT[]=$entry;}
				}
			}
			closedir($handle);
		}
		return $fileT;
	}	

static public function  allowedFileLista($dir,$allowT=[]){
		$fileT=[];
		if ($handle = opendir($dir)) {
			while (false !== ($entry = readdir($handle))) {
	
				if ($entry != "." && $entry != "..") {
					$ext = pathinfo($entry,PATHINFO_EXTENSION);
					$ext = strtolower($ext);
					if(in_array($ext, $allowT)){$fileT[]=$entry;}	
				}
			}
			closedir($handle);
		}
		return $fileT;
}
static public function  kep_cim($dir,$allowT,$refT=[]){
	
		$fileT=File::allowlista($dir,$allowT);
		$resT=[];
		foreach ($fileT as $file){
	//nagy kezdőbetű css: h6{text-transform: lowercase;} h6:first-letter {text-transform: uppercase;}
					$src=$dir.'/'.$file ;
					$nev = pathinfo($file,PATHINFO_FILENAME);
				
					if(isset($refT[$file]['cim'])){$cim=$refT[$file]['cim'];}else{$cim=$nev;}
					if(isset($refT[$file]['text'])){$text=$refT[$file]['text'];}else{$text='';}
					$resT[$nev]=['src'=>$src,'cim'=>$cim,'text'=>$text];
					//echo "";
				}
		return $resT;
		}
static 	public function vanfile_plusz($filename)
		{
		    $van=false;
		    $fileParts = pathinfo($filename);
		    if(is_file($filename)){$van=true;}
		    $i=1;
		    while ($van)
		    {
		        $file=$fileParts['filename'].$i ;
		    if(!is_file($fileParts['dirname'].'/'.$file.'.'.$fileParts['extension']))
		    {$van=false;$filename=$fileParts['dirname'].'/'.$file.'.'.$fileParts['extension'];}  $i++;
		    }
		    return $filename;
		}
static 	public function webnev($string)
		{$webnev='';
		$string= strtolower($string);
		$hungarianABC = array( 'á','é','í','ó','ö','ő','ú','ü','ű','&','#','@','$','%','/','\\',' ','-',',','+',);
		//$englishABC = array( 'a','e','i','o','o','o','u','u','u','A','E','I','O','O','O','U','U','U','e','e','e','e','e','e','e');
		$englishABC = array( 'a','e','i','o','oe','oe','u','u','u','_and_','_se_','_at_','_doll_','_szaz_','_slash_','_bslash_','_','_','_com_','_plus_');
		$string=str_replace($hungarianABC, $englishABC, $string);
		$string= preg_replace("/(_+)/", '_', $string);
		
		$webabc = array( 'a','e','i','o','u','b','c','d','f','g','h','j','k','l','m','n','p','_','q','r','s','z','v','w','x','y','t','0','1','2','3','4','5','6','7','8','9','.');
		
		for ($n = 0; $n < strlen($string); ++$n)
		{
		    if (in_array($string{$n},$webabc))
		    {$webnev.=$string{$n};}
		}
		return $webnev;
		}		
}