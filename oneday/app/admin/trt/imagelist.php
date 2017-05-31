<?php
namespace app\admin\trt;
defined( '_MOTTO' ) or die( 'Restricted access' );
trait Imagelist{
    public function   Imagelist(){
        $szallasid=$this->ADT['id'] ?? 0;
        $szallasid=$_POST['szallodaid'] ?? $szallasid;
        $task=$_POST['task'] ?? '';
        
        
        if($task=='saveimage')
        {
         $kep=str_replace(\PATH::$rootDir, '',$_POST['kep']);
  // $keppath=str_replace(\PATH::$MOttoDir, '',$this->ADT['dir'].DS.$file_nev );
  
         if(empty($_POST['szallodaid']))
              {
                  $sql="insert into szallas (nev) values ('nem kész')";
                  $szallasid=\lib\db\DBA::beszur($sql)['id'];
                  //$this->ADT['view']="{'id':'".$szallasid."'}";
                  $resT['id']=$szallasid;
                  header("Content-type:application/json");
                  $this->ADT['view']=json_encode($resT);
                  
              } 
              else
              {
                  $szallasid=$_POST['szallodaid'];
                  $this->ADT['view']='<!--imagelist-->';
              }
        $sql="insert into szallasfotok (szallasid,foto) values ('".$szallasid."','".$kep."')";
        \lib\db\DBA::parancs($sql);
         
        }
        
        
        if($task=='imagedel')
        {
            $kep=str_replace(\PATH::$rootDir, '',$_POST['kep']);
            // $keppath=str_replace(\PATH::$MOttoDir, '',$this->ADT['dir'].DS.$file_nev );
            
          $sql="DELETE FROM szallasfotok WHERE szallasid='".$szallasid ."' AND foto='".$kep."'";
            \lib\db\DBA::parancs($sql);
            $this->ADT['view']='<!--imagelist-->';
        } 
        
        $sql="select * from szallasfotok where szallasid='".$szallasid."'";
      //  lib\db\DB
        $imageT=\lib\db\DB::assoc_tomb($sql);
        $res='';
       
        foreach ($imageT as $imageS) {
        $res.='<div style="width:100px;height:150px;float:left"><img onclick="imagedel(\''.$imageS['foto'].'\')" src="MOtto/res/ico/16/torol.png">
            <img width="95ppx;" height="95px;" src="ROOT'.$imageS['foto'].'">
            <a onclick="kepcsere(\'kep1\',\''.$imageS['foto'].'\',\''.\PATH::$rootDir.'\');" class="btn btn-default btn-xs ">kep1</a>
            <a onclick="kepcsere(\'kep2\',\''.$imageS['foto'].'\',\''.\PATH::$rootDir.'\');" class="btn btn-default btn-xs ">kep2</a>
            </div>';
            
        }
        $res.='<div style="clear:both"></div>';
       $this->ADT['view']= str_replace('<!--imagelist-->', $res,$this->ADT['view'] )  ;
      // if($task=='saveimage')
      //  {  $this->ADT['view']='222222222222222222';}
        
}}