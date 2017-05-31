<?php
namespace app\checklist;
defined( '_MOTTO' ) or die( 'Restricted access' );

class ADT
{
    public static $ADT=[
        'pikt'=>'',
        'ikondir'=>'/tmpl/oneday/res/icon/',
        'view'=>'',
        //'sor'=>'kártya|csekk'; vagy 'sor'=>['kártya','csekk'];
        //ha kell majd beírja, ha nincs akkor checkboxal listázza az összeset
        'baseikonT'=>[
            'kártya'=>['pikt1.gif','One Day Kártya elfogadás'],
            'csekk'=>['pikt2.gif','üdülési csekk elfogadás'],
            'étterem'=>['pikt3.gif','étterem'],
            'légkondi'=>['pikt4.gif','légkondi'],
            'akadálymentes'=>['pikt5.gif','mozgáskorlátozottak számára'],
            'fürdőszoba'=>['pikt6.gif','saját fürdőszoba'],
            'konyha'=>['pikt7.gif','felszerelt konyha'],
            'parkoló'=>['pikt8.gif','zárt parkoló'],
            'kert'=>['pikt9.gif','kert'],
            'tv'=>['pikt10.gif','televízió a szobában'],
            'kisállatok'=>['pikt11.gif','kisállatok fogadása'],
            'wifi'=>['pikt12.gif','wifi'],
            'internet'=>['pikt13.gif','internet hozzáférés'],
            'gyermekjáték'=>['pikt14.gif','gyermekjáték'],
            'ertibútor'=>['pikt15.gif','kertibútor'],
            'grillező'=>['pikt16.gif','grillező, kerti sütő'],
            'hitelkártya'=>['pikt17.gif','hitelkártya elfogadás'],
            'medence'=>['pikt18.gif','medence'],
            'pezsgőkád'=>['pikt19.gif','pezsgőkád'],
            'szolárium'=>['pikt20.gif','szolárium'],
            'szauna'=>['pikt21.gif','szauna'],
            'masszázs'=>['pikt22.gif','masszázs'],
            'konditerem'=>['pikt23.gif','konditerem, sporthelyiség'],
            'fodrászat'=>['pikt24.gif','fodrászat'],
            'kozmetika'=>['pikt25.gif','kozmetika, szépségszalon'],
            'sípálya'=>['pikt26.gif','sípálya'],
            'teniszpálya'=>['pikt27.gif','teniszpálya']]
    ];
    public static function listaImg($image,$alt){
        return '<img src="'.self::$ADT['ikondir'].$image.'" alt="'.$alt.'" title="'.$alt.'" >';
    }
    
    public static function listaCheck($val,$image,$alt,$piktT){
        if(in_array($val, $piktT)){$checked='checked';}else{$checked='';}
        return '<div style="float:left;"><img src="'.\PATH::$rootDir.self::$ADT['ikondir'].$image.'" alt="'.$alt.'" title="'.$alt.'" >
           </br> <input name="pikt[]" type="checkbox" '.$checked.' value="'.$val.'">
         </div>';

}
public static function initADT($piktT=[]){
     
    $res='<div>';
   /* if(isset(self::ADT['sor']) && !empty(self::ADT['sor']))
    {
        if(!is_array(self::ADT['sor'])){self::ADT['sor']=explode('|', self::ADT['sor']);}
        foreach (self::ADT['sor'] as $val)
        {$res.=self::listaImg(self::ADT[$val][0],self::ADT[$val][1] );}

    }
    else
    {*/
        foreach (self::$ADT['baseikonT'] as $val=>$dT)
        {$res.=self::listaCheck($val,$dT[0],$dT[1],$piktT);}
    //}
    $res.='<div style="clear:both;"></div></div>';
    self::$ADT['view']=$res;
  return $res;

}
}

trait Checklist{
public function   Checklist(){
 $pikt=$this->ADT['dataT']['pikt'] ?? '';
 $piktT=explode('|',$pikt);
 
$res= \app\checklist\ADT::initADT($piktT);
 $this->ADT['view']= str_replace('<!--checklist-->', $res,$this->ADT['view'] )  ;
}
    
}
class Checklist_Iconlist_S
{
    public static function Res($iconstr){
        $piktT=explode('|',$iconstr);  
        $res='';
    foreach($piktT as $key){
        $image=\app\checklist\ADT::$ADT['baseikonT'][$key][0] ?? '';
        $alt=\app\checklist\ADT::$ADT['baseikonT'][$key][1] ?? '';
       if($image!='') {
        $res.=  '<img src="'.\PATH::$rootDir.\app\checklist\ADT::$ADT['ikondir'].$image.'" alt="'.$alt.'" title="'.$alt.'" >';  
       }
     
    }
    return $res;
    }
}
class Checklist_Iconlist_thumbS
{
    public static function Res(){
        $res='';
        foreach(\app\checklist\ADT::$ADT['baseikonT'] as $nev=>$parT){
            
            $image=$parT[0] ?? '';
            $alt=$parT[1] ?? '';
            if($image!='') {
                $res.=  '<span id="'.$nev.'" style="margin:2px;" class="btn btn-primary" onclick="
         szolgjelol(\''.$nev.'\');"><img src="'.\PATH::$rootDir.\app\checklist\ADT::$ADT['ikondir'].$image.'" alt="'.$alt.'" title="'.$alt.'" ></span>';
            }
             
        }
        return $res;
    }
}
class Checklist_S
{
    public static function Res($parT=[]){
         
       return \App_s::Res('checklist',$parT);
    }  
}

 

