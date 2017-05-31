<?php
class Lang{
 public static  $htmlPar_elotag='lt'; //lt-inner="innermezonev"
 public static  $dirT=['res'];  // $lt_szovegnev='szöveg';
 public static $elemT=[];
 static   public function getParamVal($elem,$param) {
     $match=[];
     preg_match('/[^-]'.$param.' *= *"([^"]*)"/', $elem, $match);
     $res=$match[1] ?? '';
     //print_r($match);
     return $res;
 
 }
 static public function  HTML_keres($file){
     //példa: <.... lt-inner="érték"....>inner érték<
     //match tömb:0=a teljes elem, 1=param (pl.:inner), 2="érték", 3=inner érték ha van
     $html_minta='/(<.*'.self::$htmlPar_elotag.'-([^ ]+) *= *"([^"]*)"[^>]*>)([^<]*)</';
     $html= file_get_contents( $file,true);
     $elemek=[];$resT=[];
     preg_match_all($html_minta, $html, $elemek);
     $i=0;
     foreach ($elemek[0] as $key=>$elem)
     {
     $rsT['elem']=$elemek[1][$key] ?? ''; // <elem>
        $rsT['paramnev']=$elemek[2][$key] ?? ''; //dat-paramnev="paramval" 
        $rsT['paramval']=$elemek[3][$key] ?? '';//(dataT kulcsa)
        $rsT['full']=$elemek[0][$key] ?? ''; //<elem>value<
        
        if($rsT['paramnev']=='inner')
        { $rsT['value']=$elemek[4][$key] ?? '';}//<>value< vagy paramnev="value"
        else 
        {$rsT['value']=self::getParamval($rsT['elem'],$rsT['paramnev']);}
        
         $rsT['file']=$file;
         $resT[]=$rsT;
         // !!!!!! tesztelés:  echo "elem:".$elemek[1][$key]." |paramnev:".$elemek[2][$key]." |paramertek:".$elemek[3][$key] ." |value:".$value." |full:".$elemek[0][$key]."\n"; 
     } 
     return $resT;
 }   
static public function  PHP_keres($file){  

$preg=<<<'preg'
/(\\GOB::\$LT\[['|"]([^'"\]]*)['|"]\] *= *['|"]([^'"]*)['|"])|(\\GOB::\$LT\[['|"]([^'"\]]*)['|"]\])/u
preg;
//echo $php_minta;
 $html= file_get_contents( $file,true);
 $elemek=[];
 preg_match_all($preg, $html, $elemek); 
 
  $i=0;$resT=[];

 foreach ($elemek[0] as $key=>$elem)
  {    
     $rsT['ltname']=$elemek[2][$key] ?? '';
     if($rsT['ltname']==''){$rsT['ltname']=$elemek[5][$key] ?? '';}
     $rsT['value']=$elemek[3][$key] ?? '';
     $rsT['full']=$elemek[0][$key] ?? '';
     $rsT['file']=$file;
     $resT[]=$rsT;
 // !!!!!! tesztelés:  echo "elem:".$elemek[1][$key]." |paramnev:".$elemek[2][$key]." |paramertek:".$elemek[3][$key] ." |value:".$value." |full:".$elemek[0][$key]."\n";
        
  }
 // print_r($resT);
  return $resT;
}
 static public function  lista($dir)
 {
     $resT=[];
 
    if ($handle = opendir($dir)) 
    {
        while (false !== ($entry = readdir($handle))) 
        {
            if ($entry != "." && $entry != "..") 
            {
                if(is_dir($dir.'/'.$entry)){self::lista($dir.'/'.$entry);}
                else
                {
                     switch ( pathinfo($dir.'/'.$entry, PATHINFO_EXTENSION)) 
                     {
                         case 'php':
                            $resT=  self::PHP_keres($dir.'/'.$entry);  break;
                         case 'html':
                             $resT= self::HTML_keres($dir.'/'.$entry);  break;
                     }     
                 self::$elemT=array_merge (self::$elemT,$resT);
                }
            }
        }
        closedir($handle);
    }
    
 }
static public function setElemT()
{
    foreach (self::$dirT as $dir) {
        self::lista($dir);
    }
    
}

}

Lang::setElemT();

print_r(Lang::$elemT);

/*
Cheat Sheet
[abc]	A single character of: a, b or c
[^abc]	Any single character except: a, b, or c
[a-z]	Any single character in the range a-z
[a-zA-Z]	Any single character in the range a-z or A-Z
^	Start of line
$	End of line
\A	Start of string
\z	End of string
.	Any single character
\s	Any whitespace character
\S	Any non-whitespace character
\d	Any digit
\D	Any non-digit
\w	Any word character (letter, number, underscore)
\W	Any non-word character
\b	Any word boundary
(...)	Capture everything enclosed
(a|b)	a or b
a?	Zero or one of a
a*	Zero or more of a
a+	One or more of a
a{3}	Exactly 3 of a
a{3,}	3 or more of a
a{3,6}	Between 3 and 6 of a

Options
i case insensitive  
m treat as multi-line string  
s dot matches newline  
x ignore whitespace in regex  A matches only at the start of string  
D matches only at the end of string 
U non-greedy matching by default

*/
