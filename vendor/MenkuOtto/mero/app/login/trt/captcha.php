<?php
namespace app\login\trt;
trait Captcha{
    public function Captcha(){
      $megjelenit=\CONF::$captcha ?? true; 
      if($megjelenit)
      {
        $cp= \app\captcha\Captcha_S::Res();
// echo '*************'.$cp;
      $this->ADT['view']=str_replace('<!--|captcha|-->', $cp, $this->ADT['view']) ;   
      }
     
    }
}

trait Captcha_CodeEll{
    public function CodeEll($err='captcha_error'){
        $baselang='hu';
        \GOB::$LT['captcha_error']='Captcha hiba!';
          $res = true; 
          $megjelenit=\CONF::$captcha ?? true;
          if($megjelenit)
          {
             if(!\app\captcha\Captcha_S::Bool()){
              $res = false; \GOB::$messageT['err'][$err]=''; 
            }
          } 
        return $res;
       
        
    }
}