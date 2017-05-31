<?php
namespace lib\tomb;
defined( '_MOTTO' ) or die( 'Restricted access' );
class TOMB {
/**
megállapítja egy tömbről hogy associatív-e dataT lista -e vagy item
 */    
static 	public function isAssoc( $arr)
{
    $keys = array_keys($arr);
    return array_keys($keys) !== $keys;
}   
	/**
az usort fuggvény parmétereként gasználható, associativ tömbot rendez a 'cim' mező szerint.
usort($assocT, "sortByName");
	 */
	function sortByName($a, $b)
	{
		$a = $a['cim'];
		$b = $b['cim'];
	
		if ($a == $b)
		{
			return 0;
		}
	
		return ($a < $b) ? -1 : 1;
	}
/**
$LT tömb $key kulcsához fűzi a $text szöveget a $changeT értékeivel becseréli a <<>> tagokat
pl.:$LT =\lib\base\TOMB::langTextToT('err','err_szoveg',$LT,$changeT=[]);
 */	
static 	public function langTextToT($key,$text,$LT=[],$changeT=[]){
	    $err=\lib\str\STR::Change($text,$changeT,$LT);
	    if($err!='')
	    {
	        $err0=$LT[$key] ?? '';
	        $LT[$key]=$err0.$err.'</br>';
	
	    }
	return $LT;
	}	
static 	public function errLog($text,$LT=[],$changeT=[]){
   $LT= self::langTextToT('err',$text,$LT=[],$changeT=[]);
   \GOB::$logT['err'][]=$text;
    return $LT;
}
static 	public function infoLT($text,$LT=[],$changeT=[]){
   $LT= self::langTextToT('info',$text,$LT=[],$changeT=[]);
    return $LT;
}
    /**
     * ['id'=>'user1','nev'=>'otto']
     * ból:[user1=>['id'=>'user1','nev'=>'otto']
     * a kulcsmező értékét kiemeli sor kulcsnak;
     * ha több egyforma érték is van, felülírja az ORDER BY-nak megfelellően
     */
static public function  mezoToKey($dataT,$mezo='id'){
		$resT=[];
		foreach ($dataT as $dataS){
			$resT[$dataS[$mezo]]=$dataS;
		}
		return $resT;
	}
static public function to_str($tomb)
    {
        $str = '';
        foreach ($tomb as $key => $value)
        {
            if (is_array($value))
            {
                $value =$str.self::to_str($value);
            }
         
           $str = $str . $key . ': ' . $value . '\n </br>';
            
        }
        return $str;
    }
  /**
félig kész
   */  
  static public function to_LTstr($tomb,$kulcsok=['kep','cim','intro'])
    {  
      foreach ($matches[1] as $match){
        $T=explode('-o-->', $match);
      $text.=PHP_EOL."'".$T[0]."'=>[";  
       // if(strlen("Hello")>50){$text.=PHP_EOL;}
     $text.=PHP_EOL."'".$this->baseLang."'=>'".$T[1]."',";
     $text.=PHP_EOL."'".$this->ujLang."'=>'  '";
     $text.=PHP_EOL."],";
    }
    $text=substr($text, 0, -1) ;
    $text.=']';
    return  $text;
    } 
}