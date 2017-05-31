<?php
namespace lib\itemview;
use lib\base\OB_Mo;
use lib\base\OB;
/**
a html feltöltését végzi adatokkal nyitó és zárótag alapján cserél
 */
trait replace{
	public function cserel($pre=''){
	
		foreach ($this->dataT as $nev=>$val){
			if($pre!=''){$nev=$pre.'.'.$nev;}
			$this->html= str_replace($this->elotag.$nev.$this->utotag,$val, $this->html);
		}
	}
	
	public function cserel_multidataT(){
	
		foreach ($this->dataT as $nev=>$val){
			$this->dataT=$val;
			$this->cserel($nev);
	
		}
	}
}
/**
egy itemet jelenit meg nem tartalmazza a megjelenítő funkciót
 azt a gyermek osztályban kell inicializálni $parT: dataT,html
 */
class ItemView_os extends OB_Mo{
	public $dataT=[];
	public $html='';
	public $multidataT=false;
	public $elotag='<!--#';
	public $utotag='-->';

	public function __toString(){
		
	if($this->multidataT){$this->cserel_multidataT();}else {$this->cserel();}	
	return $this->html;	
	}
}
/**
ItemView_os alapértelmezett csere fügvényekkel (replace trait)
 */
class ItemView extends ItemView_os{
use replace;	
	
}		
/**
echo OB::res('lib\itemview\ItemView_lista',$parT);$parT=['html'=>$html,'dataT'=>$dataT];
 */	
class ItemView_lista extends ItemView{
	function res($parT=[]){
		$lista=''; 
		//print_r($this->dataT);
		foreach ($this->dataT as $iT){
			$parT['dataT']=$iT;
			$lista.= OB::res('lib\itemview\ItemView',$parT);
	
		}
	return $lista;
	}
}	
/*
 Your Flight details back home are:

Date:19.05.2016   From:   FAO To:   FRA      Dept Time:  13:25

Arrival Time:   17:30    Flight No: LH1163    Booking Ref: 5R6WRL

TOD: Lufthansa - check in at airport
(N.B: These details are specific to you and therefore may not be the same as other delegates you may be in touch with)


Just to confirm, your uniform will be given to you in Portugal so please make sure you have room for this in your case this will weigh approx. 6kgs – So try to pack light on your way to Portugal. As no excess baggage will be covered on your way home.

As a professional company, Thomas Cook expects its employees to meet and maintain certain standards of behaviour and conduct, both on the flight and in Portugal. If your behaviour and standards don’t meet Thomas Cook requirements you will be asked to leave the course. The induction will start from the minute you arrive at the airport so make sure you turn up ready for work with a positive attitude (we’d strongly recommend against the consumption of alcohol on the journey out or day before). Remember your induction course forms part of your recruitment process.

Should you require any assistance or information in planning your journey for your flight, please contact clare.watts@thomascook.com in the iDS HR&Planning  department from 09:00 to 17:30 Monday to Friday. In emergencies only outside of these hours while you are travelling please call 07748071447.

May I take this opportunity to wish you all the very best for your Induction Course, we look forward to meeting you.

Kind regards,
 * 
$ht=<<<html
elotag <!--#0--> utotag-------

html;
//$munkaruha=[ 'Blakläder',' Sievi','Snickers',' Portwest'] ;

	//echo  listaz($ht, $munkaruha);///ItemView::res($ht, $munkaruha);
	//$probaT=['Ménkű 2'=>' hjk ghgjh'];
	//echo $probaT['Ménkű 2'];

// Munkaruha	


//echo listaz($view, $munkaruha);
//$g=new itemV();
//$g.=new itemV();

//Forgalmazott termékeink
$termekek=['Legrand','GAO','Weidmüller','EMOS','Düwi','Hilti','Müpro','ABB','Apolo MEA','B.E.G.
Brennensthul','Eaton','CEAG','Gewiss','Cellpack','Conta-Clip','Csatári-Plast Kft.','Danfoss','Dehn','DKC
Pyrsmian','EFEN','ELKO EP','Ensto','Erico','F-Tronic','Finder','Ganz-KK','GEYER','Grasslin
Hager','Harting','Haupa','Helvar','Hensel','Hirschman','Hunliux','J.Pröpster','Jean Müller','Kaiser
Kopos','Leipold','Socomec','Nideax','nkt cabels','OBO Bettermann','Omron','Osram','Orbitec','PCE
Phoenix contact','Pollmann','Sylvania','Rittal','Schneider Electric','Schrack','Siemens','Siku','Stahl','Gripple
Tele-Haase','Tracon Electric','Dietzel Univolt','Urmet','Wago','Werma','GE Hungary','EAE Elektrik','Stiebel Eltron'];

// Munkaruha
$munkaruha=[ 'Blakläder',' Sievi','Snickers',' Portwest'] ;

// Lámpatestek
$lampa=['Beghelli','Disano','Emika','Fosnova','Rábalux','EGLO','GLOBO','Simotrade','Simovill','Siteco
Trilux','Modus','OMS','Philips','SLV ','Delta Light','FLOS','Leds C4','Lucente','Rossini
Compass','Kanlux','Nowodvorski','Search Light','AZzardo','Artemide'];
*/