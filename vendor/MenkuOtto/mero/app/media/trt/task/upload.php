<?php
namespace app\media\trt\task;

defined( '_MOTTO' ) or die( 'Restricted access' );
trait Upload{
    
 public function Upload()
 {
     $baselang='hu';
    \GOB::$LT['Invalid file type']='Nme engedélyezett filetipus';
    
    $feltolt_mezo=$this->ADT['feltolt_mezo'];
     if ($_FILES[$feltolt_mezo]['error'] > 0)
     {
         \GOB::$messageT['err']['sys_feltolt']=$_FILES[$feltolt_mezo]['error'];
     } else
     {
         $cim=$_FILES[$feltolt_mezo]['name'];
         $fileParts = pathinfo($_FILES[$feltolt_mezo]['name']);
         $tempFile = $_FILES[$feltolt_mezo]['tmp_name'];
         // echo "File type: " . $_FILES[$feltolt_mezo]['type'] ;
         //echo "File size: " . ($_FILES[$feltolt_mezo]['size'] ;
         //$fileExtension = strrchr($_FILES[$feltolt_mezo]['name'], ".");
         $kep_tipusok = array('jpg','jpeg','gif','png');
         $video_tipusok = array('avi','mpeg','flv','mp4','wmv');
         $doc_tipusok = array('doc','txt','csv');
     
         if (!empty($_FILES) ) {
             //kép feltöltés-----------------------------------------------------------
             if (in_array($fileParts['extension'],$kep_tipusok)) {
     
                 // $targetFolder = $_SERVER['DOCUMENT_ROOT'].'/'.$user_dir;
                 $targetFolder = $this->ADT['dir'];
                 
                 $targetFolder_thumb =$targetFolder .'/thumb';
                 
                 if(!is_dir($targetFolder_thumb)){mkdir($targetFolder_thumb, 0777);}
                 $manipulator = new \lib\image\ImageManipulator( $tempFile);
                 $newImage = $manipulator->resample(800,800);
                 //$filenev=$manipulator->uni_nev().'.'.$fileParts['extension'];
                 $filenev=$_FILES[$feltolt_mezo]['name'];
                 $manipulator->save($targetFolder.'/'.$filenev);
 // echo $targetFolder.'/'.$filenev;
                 $newImage = $manipulator->resample(100,100);
                 $manipulator->save($targetFolder_thumb.'/'.$filenev);
                 //echo $targetFolder_thumb.'/'.$filenev;
     
             }else{\GOB::$messageT['err']['Invalid file type']='';}
         }
     }
     $rs=$_GET['result'] ?? '';
   if($rs=='json'){echo 'ok';}else{$this->ADT['TSK']['upload']['next']='alap';}
 }   
    
}


