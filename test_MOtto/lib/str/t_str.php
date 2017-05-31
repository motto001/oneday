<?php
namespace test\lib\str;




use test\lib\html\T_szotar;

class T_STR{
    static public function change(){
        
      echo "\n T_str::change: ";
        
       $res=\lib\str\STR::Change('alap',[],['alap'=>'alapcsere']);
       $god='alapcsere';
        if($res==$god){echo 'OK,';}
        else{echo '!!!,';
        \GOBT::$resT['T_str']['change']='1';
        }
        
        $res=\lib\str\STR::Change('alapdd',[],['alap'=>'alapcsere']);
        $god='alapdd';
        if($res==$god){echo 'OK,';}
        else{echo '!!!,';
        \GOBT::$resT['T_str']['change']='2';
        }
        
        $text='alap';
        $changeT=['egyes'=>'első','kettes'=>'második'];
        $LT=['alap'=>'alap szoveg <<egyes>> és <<kettes>> változóval'];
        $god='alap szoveg első és második változóval';
        $res=\lib\str\STR::Change($text,$changeT,$LT);
       // echo $res;
        if($res==$god){echo 'OK,';}
        else{echo '!!!,';
        \GOBT::$resT['T_str']['change']='3';
        }
        
        $text='alap szoveg <<egyes>> és <<kettes>> változóval';
        $changeT=['egyes'=>'LT.egyes','kettes'=>'második'];
        $LT=['egyes'=>'ltelső','alap'=>'alap szoveg <<egyes>> és <<kettes>> vjjlkl'];
        $god='alap szoveg ltelső és második változóval';
        $res=\lib\str\STR::Change($text,$changeT,$LT);
        // echo $res;
        if($res==$god){echo 'OK,';}
        else{echo '!!!,';
        \GOBT::$resT['T_str']['change']='5';
        }
        
        $res=\lib\str\STR::Change('gg',[],[]);
        $god='gg';
        if($res==$god){echo 'OK,';}
        else{echo '!!!,';
        \GOBT::$resT['T_str']['change']='6';
        }
        
    }
}

T_STR::change();