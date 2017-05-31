<?php
namespace app\base;

defined( '_MOTTO' ) or die( 'Restricted access' );

class App {
use \app\trt\Ell;
public $ADT=[];

public function __construct(){
    $this->ADT['view'] ='<h3>Az email megerősítés nem sikerült!</h3>';
    $this->ADT['task'] ='confirm';
    $this->ADT['ellerr'] =true; // kell!!! 
    $this->ADT['TSK']['confirm']['ell']['id']['regx']=
    [['ENG_SZO','spec_char_err'],['/^.{<<MIN>>,<<MAX>>}$/u','long_err',['MEZO'=>'username','MIN'=>'1','MAX'=>'10']]];	
	$this->ADT['TSK']['confirm']['ell']['code']['regx']=
	[['ENG_SZO','spec_char_err'],['/^.{<<MIN>>,<<MAX>>}$/u','long_err',['MEZO'=>'username','MIN'=>'4','MAX'=>'20']]];
   $this->confirm(); 
}

function confirm(){
    
    
  if($this->Ell(true))
  {
// print_r($this->ADT['SPT']) ;    
    $sql= "SELECT * FROM tmp WHERE userid='".$this->ADT['SPT']['id']."' AND varname='regcode' AND value='".$this->ADT['SPT']['code']."'";
//echo $sql ; 
    $res=\lib\db\DB::assoc_sor($sql);
    $value=$res['value'] ?? '';
    if($value!=''){
         
        $res['bool']=true;
        
          if(\CONF::$autopub=='email')
          {
           
            $sql="UPDATE userek SET pub='0' WHERE id='".$this->ADT['SPT']['id']."'";
            $res =\lib\db\DBA::parancs($sql);
          }
          if(!$res['bool'])
          {
              $this->ADT['view'].='<h4>Adatbázis hiba próbálja újra.</h4>';
              \GOB::$logT['hiba']['confirm'][]='userid: '.$this->ADT['SPT']['id'].' hiba:Adatbázis';
          }
          else{ $this->ADT['view'] ='<h3>Az email megerősítés sikeres!</h3>';}
             // $sql="INSERT INTO ell (userid,tipus,val)VALUES ('".$this->ADT['SPT']['id']."','email','"
             // $res =\lib\db\DBA::parancs($sql);
     }     
  }
  else{
      
      $this->ADT['view'].='<h4>Az email ellenőrzési adatok hibásak.</h4>';
      \GOB::$logT['hiba']['confirm'][]='userid: '.$this->ADT['SPT']['id'].'code: '.$this->ADT['SPT']['code'].' hiba:rossz adatok';
  }
  
  \GOB::$html= str_replace('<!--|content|-->',$this->ADT['view'], \GOB::$html);
}
       
}
