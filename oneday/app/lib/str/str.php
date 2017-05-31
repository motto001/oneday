<?php
namespace lib\str;
defined( '_MOTTO' ) or die( 'Restricted access' );
/**
eval()-al átadhatóparaméterk az str_replace()-nek
 */
class STR_ch
{ 
static public $regx='"<<".$nev.">>", $val, $text';	
}

class STR
{
static  public function randomSTR($long){
 
    $string = "";  
 
    $CharacterMap = array("A", "a", "B", "b", "C", "c", "D", "d", "E", "e", "F", "f",  
                          "G", "g", "H", "h", "I", "i", "J", "j", "K", "k", "L", "l",  
                          "M", "m", "N", "n", "O", "o", "P", "p", "Q", "q", "R", "r",  
                          "S", "s", "T", "t", "U", "u", "V", "v", "W", "w", "X", "x",  
                          "Y", "y", "Z", "z", "0", "1", "2", "3", "4", "5", "6", "7",  
                          "8", "9");  
  
    for ($i = 0; $i < $long; $i++) {  
  
        $string .= $CharacterMap[array_rand($CharacterMap, 1)];   
    }   
    return $string;   
}  
    
    /**
tesztelve. A $text szöveget csseréli ki Az $LT megfelelő elemével utána ha van $changeT
akkor a szövegben lévő <<>> elemeket csrél iki a $changeT megfelelő elemeire
 Ha a $changeT kulcsa 'LT.'-vel kezdődik akor az értékét előbb becseréli a $LT tömbből 
 és azzal cserli ki az <<>> elemet.
     */
static  public function Change($text,$changeT=[],$LT=[]){
 // echo 'str::Change:'.$nev;   
        if(isset($LT[$text])){$text=$LT[$text];}
    
        foreach ($changeT as $nev=>$val)
        {   //echo 'str::Change: '.substr($nev,0,3);
            if(substr($val,0,3)=='LT.')
            {
                $val=substr($val,3);
                if(isset($LT[$val])){$val=$LT[$val];}
            }
            $text= str_replace('<<'.$nev.'>>', $val, $text);
        }
        return $text;
    }    
    
	/**
$regex-re illeszkedő tartalmak kigyüjtése pl.:$regex='/<div class=\"main\">([^`]*?)<\/div>/'
kigyujti egy tömbbe a main osztályú div-ek tartalmát
	 */
static public function kigyujt($regx,$text){
		$matches=[];
		preg_match_all ($regx, $text, $matches);
		return $matches;	
	}
	
static public function to_tomb($string, $tagolo1 = ',', $tagolo2 = ':'){
//pl.:$string='class:hhh,id:azon,name:név'
    $tomb=array();
        $tx1 = explode($tagolo1, $string);
        foreach ($tx1 as $mezo) {
            $tx2 = explode($tagolo2, $mezo);
            $tomb[$tx2[0]] = $tx2[1];
        }
        return $tomb;
    }

static public function webnev($string,$hosz=20)
    {$webnev='';
        $hungarianABC = array( 'á','é','í','ó','ö','ő','ú','ü','ű','Á','É','Í','Ó','Ö','Ő','Ú','Ü','Ű','&','#','@','$','%','/','\\');
        $englishABC = array( 'a','e','i','o','o','o','u','u','u','A','E','I','O','O','O','U','U','U','e','e','e','e','e','e','e');
        $string=str_replace($hungarianABC, $englishABC, $string);
        $webabc = array( 'a','e','i','o','u','b','c','d','f','g','h','j','k','l','m','n','p','_','q','r','s','z','v','w','x','y','t','0','1','2','3','4','5','6','7','8','9');
        $string = strtolower( $string);
        for ($n = 0; $n < strlen($string); ++$n)
        {if($n<$hosz){if (in_array($string{$n},$webabc)){$webnev=$webnev.$string{$n};}}}
        return $webnev;
    }
}