<?php
namespace app\admin\trt;
defined( '_MOTTO' ) or die( 'Restricted access' );
trait Szallasdata
{
 public function Szallasdata()
    { 
       
        
        $id=$_POST['id'] ?? 0;
        $sql="SELECT nev,substr(egyeb,1,150) as intro,kep1 FROM szallas WHERE id='".$id."'";
        $dataT=\lib\db\DB::assoc_sor($sql); 
        $dataT['link']='index.php?app=szallas&id='.$id;    
        $this->ADT['view']=json_encode($dataT);
   
   }} 