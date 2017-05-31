<?php
namespace app\media\trt\task;
//echo '---------------------------';
trait Alap_ini{
 public function AppIni(){
//unset($_SESSION['subdir']) ;
// \GOB::$paramT['html']['head']['jsfile'][]='mod/media/media.js';
$this->ADT['user_rootdir'] = \PATH::$rootDir.DS.$this->ADT['user_rootdir'];
$this->ADT['user_rootdir'].=DS.$_SESSION['userid'];
if(!is_dir($this->ADT['user_rootdir']))
{mkdir($this->ADT['user_rootdir'], 0777);}
$this->ADT['admin_rootdir'] = \PATH::$rootDir.DS.$this->ADT['admin_rootdir'];
if(\GOB::get_userjog('admin')){ $rootdir=$this->ADT['admin_rootdir'];   }
else{$rootdir=$this->ADT['user_rootdir'];} 

$subdir=$_SESSION['subdir'] ?? '' ;
$subdir_old=$subdir;  //ha nem érvénes lesz a subdir megállapítás

if(isset($_GET['vdir']))
{
    if($_GET['vdir']=='home'){$subdir='';}
    if($_GET['vdir']=='up')
    {
        $dirT=explode(DS,$subdir);
        if(empty($dirT[1])){$subdir='';}
        else{$utolso = array_pop ($dirT);$subdir=implode(DS , $dirT);}
    }
}
else 
{
    if(isset($_GET['dir']))
    {
          if($subdir=='')
          {
              $subdir=$_GET['dir'];
          }
          else
          {
             $subdir.=DS.$_GET['dir'];  
          } 
     }  
}


if(is_dir($rootdir.DS.$subdir)){$_SESSION['subdir']=$subdir;}
else{$subdir=$subdir_old;}

if($subdir==''){ $path=$rootdir; }else{ $path=$rootdir.DS.$subdir;}
if(!is_dir($path)){$path=$rootdir;}

//$this->ADT['dir']=str_replace('//', DS, $path) ;
 $this->ADT['dir']= preg_replace("/(\/+)|(\\\\+)/", DS, $path);
// echo $this->ADT['dir'];
}}

trait Alap_Del{
    public function deldir($dir)
    {  
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir.DS.$object)){
                        $this->deldir($dir.DS.$object);
                    }else{
                        unlink($dir.DS.$object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);  
    }
    public function Del(){

        $filename=$this->ADT['dir']. DS . $_GET['did'];

        if(is_file($filename)){
            unlink($filename);
            $thumbname=$this->ADT['dir'].DS ."thumb".DS. $_GET['did'];
            if(is_file($thumbname)){ unlink($thumbname);}
        }
        if(is_dir($filename)){
            
            $this->deldir($filename);
        }
            
        $rs=$_GET['result'] ?? '';
        if($rs=='json'){echo $filename;}else{$this->ADT['TSK']['del']['next']='alap';}
    }
}
trait Alap_Newdir{
    public function Newdir(){
       $ujdir=$_GET['addir'] ?? 'newdir';
       if(!is_dir($this->ADT['dir'].DS.$ujdir)){
         mkdir($this->ADT['dir'].DS.$ujdir,0777);  
       }
       else {
        $nincs=true;$i=1;$ujdir2=$ujdir;
        
           while($nincs){
               $ujdir=$ujdir2;
               $ujdir.=$i;
               if(!is_dir($this->ADT['dir'].DS.$ujdir))
               {
                   mkdir($this->ADT['dir'].DS.$ujdir,0777);
                   $nincs=false;
               }  
               $i++;
           }
       }
       $rs=$_GET['result'] ?? '';
       if($rs=='json'){echo $filename;}else{$this->ADT['TSK']['newdir']['next']='alap';}
    }
}


trait Alap_Lista{
    //public  $thumb_view='';
    public  $dir_view='';
    public  $dirT= [];
    public  $fileT= []; 
    public  $del_ikon='';
    public function setFileT()
    {
        if ($open_dir = opendir($this->ADT['dir'])) {
    
            while ($filenev = readdir($open_dir)) {
                if ($filenev != "." && $filenev != "..") {
                    if (is_dir($this->ADT['dir']. DS . $filenev)) {
                        if (!in_array($filenev, $this->ADT['hidden_dirs'])) {
                            $this->dirT[] = $filenev;
                        }
                    } else {
                        $ext = pathinfo($filenev, PATHINFO_EXTENSION);
                        // $fn = pathinfo($file, PATHINFO_FILENAME);
                        if (in_array($ext, $this->ADT['view_filetipus']))
                        {
                            $this->fileT[] = $filenev;
                        }
                    }
                }
            }
            closedir($open_dir);
        }
    }
    
    
    function kep_thumb($file_nev)
    {
        $dataT['nev'] = pathinfo($file_nev, PATHINFO_FILENAME);
       // echo $this->ADT['dir'].DS.'thumb'.DS.$file_nev;
        
        if(is_file($this->ADT['dir'].DS.'thumb'.DS.$file_nev))
        {
            $src=str_replace('\\', '/',$this->ADT['dir'].DS.'thumb'.DS.$file_nev);
        }
        $keppath=str_replace('\\', '/',$this->ADT['dir'].DS.$file_nev );
 //  $keppath=str_replace(\PATH::$rootDir, '',$this->ADT['dir'].DS.$file_nev );
  // $keppath=str_replace(\PATH::$MOttoDir, '',$this->ADT['dir'].DS.$file_nev );
        $dataT['src']=$src ??  $keppath;
        $dataT['onclick']="beszur('".$keppath."');";
        //echo $dataT['src'];
        $dataT['title']=$file_nev;
        
        $dataT['image_del']="image_del('".$file_nev."');";
       // $dataT['src_torol']=$this->ADT['src_torol'];
        $dataT['ikon_torol']=$this->del_ikon;
       // $dataT['del_link']='index.php?app=media&med=del&did='.$file_nev;
      // print_r($dataT);
        $thumb=\lib\html\dom\Dom_S::ChangeData($this->thumb_view,$dataT);
        return $thumb;
    }
    function dir_thumb($file_nev)
    {
        $dataT['nev'] = $file_nev;
        $dataT['onclick']="dirchange('".$file_nev."');";
        $dataT['ikon_torol']=$this->del_ikon;
        $dataT['image_del']="image_del('".$file_nev."');";
        $dataT['src']=\PATH::$MOttoDir.DS.'res/ico/dir.png';
        $thumb=\lib\html\dom\Dom_S::ChangeData($this->thumb_view,$dataT);
        return $thumb;
    }
    function ikon_thumb($cim,$kep,$func)
    {
        $dataT['ikon_torol']=$this->del_ikon;
        $dataT['nev'] = $cim;
        $dataT['onclick']=$func."();";
        $dataT['src']=$kep;
        $thumb=\lib\html\dom\Dom_S::ChangeData($this->thumb_view,$dataT);
        return $thumb;
    }
    
    public function lista_keszit(){
    
        $res='';
        $this->setFileT();
        $this->del_ikon=\app\icon\Icon_S::simple('del','tab_simple','',['size'=>'18']);
        $this->ADT['view']=file_get_contents(\PATH::$MOttoDir.DS.'app'.DS.'media'.DS.'view'.DS.'media_full.html',true);
        $this->thumb_view= \lib\html\dom\Dom_S::getViewFromHTML($this->ADT['view'],'thumb_base');
       
//echo'dddddddddddddd.: '. $this->thumb_view;
       // $this->dir_view= \lib\html\dom\Dom_S::getViewFromHTML($this->ADT['view'],'dir_base');
        
        $res.= $this->ikon_thumb('fel',\PATH::$MOttoDir.DS.'res/ico/up.png','up') ; 
        $res.= $this->ikon_thumb('Home',\PATH::$MOttoDir.DS.'res/ico/home.png','home') ;
        foreach ($this->dirT as $file)
        { $res.= $this->dir_thumb($file) ;}
        
        foreach ($this->fileT as $file)
        {$res.= $this->kep_thumb($file) ;}
       
    
        return $res;
    }
    
    public function Lista(){

        $this->ADT['view']= $this->lista_keszit();  
    }
}
trait Alap{
  
use   \app\media\trt\task\Alap_Lista; 

    public function Alap(){
        
        $res=$this->lista_keszit();    
        $this->ADT['view']= str_replace('<!--filelista-->',$res ,$this->ADT['view']);
  
        //return $html;
    }
}