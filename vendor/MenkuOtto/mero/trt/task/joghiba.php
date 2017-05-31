<?php
namespace trt\task;
defined( '_MOTTO' ) or die( 'Restricted access' );

trait Joghiba{ 
    public function Joghiba(){
  
    if($_SESSION['userid']==0)
    {$this->ADT['view']=\App_S::Res('login'); }
    else 
    {
       $this->ADT['view'] =\GOB::$LT['joghiba'] ?? 'Jogosultság hiba. Jelentkezz be adminnal!';
        $this->ADT['view']='<h3>'.$this->ADT['view'].'<h3>'.$this->ADT['view']=\App_S::Res('login') ;
    }
     
}
/*
public function Res(){

    if($_SESSION['userid']==0)
    {$this->ADT['view']=\mod\login\Login_S::Res(); }
    else
    {
        $this->ADT['view'] =\GOB::$LT['joghiba'] ?? 'Jogosultság hiba';
        $this->ADT['view']='<h3>'.$this->ADT['view'].'<h3>';
    }
     
}
*/

}