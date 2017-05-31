<?php
namespace lib\ell;
//use lib\ell\trt\Ell;
/**
Az  $ELL=new Ell; $ADT=$ELL->res($ADT,$TSK); formában App és modul ostályokban használható
 */
/*class Ell
{
use \lib\ell\trt\Ell;
public $ADT=[];
	public function __construct($parT = []){
		foreach ($parT as $name => $value)
		{$this->ADT[$name]=$value;}
	}

}


class Ell_login extends Ell
{
use \lib\ell\trt\Regx;
use \lib\ell\trt\Ell_match;
use \lib\ell\trt\DB_Marvan;
use \lib\ell\trt\DB_ValidPasswd;
	
}*/

class RegexT
{ 
static public $messageT=[
 'hu'=>[
     '#'=>'a <<MEZO>> mező ',
     'SZAM'=>'# csak szám lehet!', //pozitív vagy negativ szám tizeds tört is lehet
     'SZAM_POZ'=>'# csak pozitiv szám lehet!', //pozitív szám tizedes tört is lehet
     'EGESZ'=>'# csak egész szám lehet!', //pozitív vagy negatív egész szám
     'EGESZ_POZ'=>'# csak pozitív egész szám lehet!', //
     //text----------------------
     'ENG_SZO_KIS'=>'# csak angol ABC kisbetűit tartalmazhtaja valamint számokat.Szóköz sem lehet!', 
     'ENG_SZO'=>'# csak angol ABC kis és nagybetűit tartalmazhtaja valamint számokat.Szóköz sem lehet!',  // 1 ha csak angol kis és nagybetű és szám van benne szóköz sem lehet
     'ENG_TOBB_SZO'=>'# csak angol ABC kis és nagybetűit tartalmazhtaja valamint számokat és szóközt!',  //csak angol kis és nagybetű szám és szóköz van
     'ENG_TEXT'=>'csak angol ABC kis és nagybetűit tartalmazhtaja valamint számokat és szóközt és !?() karaktereket',//1 ha csak angol kis és nagybetű és szám szóköz és !?().:
    
     'MIN'=>'#nek minimum <<MIN>> karakternek kell lennie!',
     'MAX'=>'# maximum <<MAX>> karakternek lehet!',
     'HU_SZO_KIS'=>'# csak a Magyar ABC kisbetűit tartalmazhtaja valamint számokat.Szóköz sem lehet!',
     'HU_SZO'=>'# csak a Magyar ABC kis és nagybetűit tartalmazhtaja valamint számokat.Szóköz sem lehet!',  // eng_szo plusz ékezetesek
     'HU_TOBB_SZO'=>'# csak a Magyar ABC ABC kis és nagybetűit tartalmazhtaja valamint számokat és szóközt!', //eng_tobb_szo plusz ékezetesek
     'HU_TEXT'=>'csak a Magyar ABC ABC kis és nagybetűit tartalmazhtaja valamint számokat és szóközt és !?() karaktereket',//ures stringnél is hibát jelez!!!
     'MAIL'=>'nem érvényes emailcím',//1 ha email
     //tesztelve---------------
     //tagado 1 (true) az értéke ha megfelel a mintának, hogy a hiba legyen tagadni kell(!preg_match();)
     'MIN_MAX_UJ'=>'/^.{#nek minimum <<min>>,maximum <<max>> karaktert kell tartalmaznia! ',//magyar karaktereket is figylembe veszi
     'MIN6_MAX20'=>'#nek minimum 6,maximum 20 karaktert kell tartalmaznia!',//jelszónál pl
     
     
     //'MIN_MAX_UJ' =>'/^([a-záéíóöőúüűA-ZÁÉÍÓÖŐÚÜŰ0-9.,?!]){<<min>>,<<max>>}$/siu',
     //kereso------------------------
     'DIV'=>'#<div[^>]*>(.*?)</div>#', //le kell ellenőrizni
     'DIV_CLASS'=>'/<div class=\"main\">([^`]*?)<\/div>/'
  ]   
     
 ]  ; 
      

static public $regexT=[
			//nincs ellenőrizve------------
			'SZAM'=>'/^[-+]?(\d*[.])?\d+$/', //pozitív vagy negativ szám tizeds tört is lehet
			'SZAM_POZ'=>'/^(\d*[.])?\d+$/', //pozitív szám tizedes tört is lehet
			'EGESZ'=>'/^[-]?[\d ]+$/', //pozitív vagy negatív egész szám
			'EGESZ_POZ'=>'/^(\d*[.])?\d+$/', //pozitív egész zsám
			//text----------------------
			'ENG_SZO_KIS'=>'/^[a-z\d]+$/',  // 1 ha csak angol kisbetű és szám van benne szóköz sem lehet
			'ENG_SZO'=>'/^[a-zA-Z\d]+$/',  // 1 ha csak angol kis és nagybetű és szám van benne szóköz sem lehet
			'ENG_TOBB_SZO'=>'/^[a-zA-Z\d ]+$/',  //csak angol kis és nagybetű szám és szóköz van
			'ENG_TEXT'=>'/^[a-zA-Z\d \!\"\?\.\:\(\)]+$/',//1 ha csak angol kis és nagybetű és szám szóköz és !?().:
			'MIN_MAX_UJ' =>'/^([a-záéíóöőúüűA-ZÁÉÍÓÖŐÚÜŰ0-9.,?!]){<<min>>,<<max>>}$/siu',
			'MIN'=>'/^.{<<min>>,}$/',
			'MAX'=>'/^.{1,<<max>>}$/',
            'HU_SZO_KIS'=>'/^[a-z\d éáűíúőóüö]+$/u',
			'HU_SZO'=>'/^[a-zA-Z\d éáűíúőóüöÁÉŰÚÍŐÓÜÖ]+$/u',  // eng_szo plusz ékezetesek
			'HU_TOBB_SZO'=>'/^[a-zA-Z\d éáűúíőóüöÁÉŰÚ<ŐÓÜÖ]+$/u', //eng_tobb_szo plusz ékezetesek
	        'HU_TEXT'=>'/^[a-zA-Z\d \!\"\?\.\:\(\)éáűíúőóüöÁÉŰÚÍŐÓÜÖ]+$/u',
			'MAIL'=>'/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',//1 ha email
			//tesztelve---------------
			//tagado 1 (true) az értéke ha megfelel a mintának, hogy a hiba legyen tagadni kell(!preg_match();)
			'MIN_MAX'=>'/^.{<<min>>,<<max>>}$/',//magyar karaktereket nem veszi figyelembe
			'MIN_MAX_UJ'=>'/^.{<<min>>,<<max>>}$/u',//magyar karaktereket is figylembe veszi
			'MIN6_MAX20'=>'/^.{6,20}$/u',//jelszónál pl
			'MAIL'=>'/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',//1 ha email
			//ures stringnél is hibát jelez!!!
			//'MIN_MAX_UJ' =>'/^([a-záéíóöőúüűA-ZÁÉÍÓÖŐÚÜŰ0-9.,?!]){<<min>>,<<max>>}$/siu',
			//kereso------------------------
			'DIV'=>'#<div[^>]*>(.*?)</div>#', //le kell ellenőrizni
			'DIV_CLASS'=>'/<div class=\"main\">([^`]*?)<\/div>/'
	];

}	
	
/*	//select integers only
	var intRegex = /[0-9 -()+]+$/;
	//match any ip address
	var ipRegex = 'bd{1,3}.d{1,3}.d{1,3}.d{1,3}b';
	//match number in range 0-255
	var num0to255Regex = '^([01][0-9][0-9]|2[0-4][0-9]|25[0-5])$';
	//match number in range 0-999
	var num0to999Regex = '^([0-9]|[1-9][0-9]|[1-9][0-9][0-9])$';
	//match ints and floats/decimals
	var floatRegex = '[-+]?([0-9]*.[0-9]+|[0-9]+)';
	//Match Any number from 1 to 50 inclusive
	var number1to50Regex = /(^[1-9]{1}$|^[1-4]{1}[0-9]{1}$|^50$)/gm;
	var emailRegex = '^[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}$'; 
//match credit card numbers
var creditCardRegex = '^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35d{3})d{11})$'; 
//match username
var usernameRegex = '/^[a-z0-9_-]{3,16}$/'; 
//match password
var passwordRegex = '/^[a-z0-9_-]{6,18}$/'; 
//Match 8 to 15 character string with at least one upper case letter, one lower case letter, and one digit (useful for passwords).
var passwordStrengthRegex = /((?=.*d)(?=.*[a-z])(?=.*[A-Z]).{8,15})/gm; 
//match elements that could contain a phone number
var phoneNumber = /[0-9-()+]{3,20}/; 
//select whitespace
var whiteSpaceRegex = '^[ t]+'; 
//select whitespace and tabs
var whiteSpaceRegex = '^[ t]+|[ t]+$';  
//select whitespace and linebreaks
var whiteSpaceRegex = '[ trn]';  
//replace newline characters with  tags
newLineToBr = function(str) { return str.replace(/(rn|[rn])/g, ''); } 

//match domain name (with HTTP)
var domainRegex = /(.*?)[^w{3}.]([a-zA-Z0-9]([a-zA-Z0-9-]{0,65}[a-zA-Z0-9])?.)+[a-zA-Z]{2,6}/igm; 
//match domain name (www. only) 
var domainRegex = /[^w{3}.]([a-zA-Z0-9]([a-zA-Z0-9-]{0,65}[a-zA-Z0-9])?.)+[a-zA-Z]{2,6}/igm; 
//match domain name (alternative)
var domainRegex = /(.*?).(com|net|org|info|coop|int|com.au|co.uk|org.uk|ac.uk|)/igm; 
//match sub domains: www, dev, int, stage, int.travel, stage.travel
var subDomainRegex = /(http://|https://)?(www.|dev.)?(int.|stage.)?(travel.)?(.*)+?/igm;
//Match jpg, gif or png image	
var imageRegex = /([^s]+(?=.(jpg|gif|png)).2)/gm; 
//match all images
var imgTagsRegex = //ig;  
//match just .png images
//match a HTML tag (v1)
var htmlTagRegex = '/^< ([a-z]+)([^<]+)*(?:>(.*)< /1>|s+/>)$/'; 
//match HTML Tags (v2)
var htmlTagRegex = /(< (/?[^>]+)>)/gm; 
jquery:
 function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    };

	*/
	


