<?php
namespace lib\ell;
defined( '_MOTTO' ) or die( 'Restricted access' );
class Ell_lang{
	public static  $baselang='hu';
	public static $LT=[
			'cut_text'=>'a <<MEZO>> mező nem lehet hosszabbmint <<MAX>> karakter. A többlet el lett távolítva!',
			'change_comma'=>'a <<MEZO>> mező időzőjelekettartalmaz. Biztonsági okból ezek kódoltak igy 6 karakternek felenek meg!',
			'change_not_allowed_tag'=>'a <<MEZO>> mező nem engedélyezett html elemet vagy scriptet tartalmazott ezeket töröltük',
			'ERR_not_allowed_tag'=>'a <<MEZO>> mező nem engedélyezett html elemet vagy scriptet tartalmaz',
			'ERR_SZAM'=>'a <<MEZO>> mező csak szám lehet!', //pozitív vagy negativ szám tizeds tört is lehet
			'ERR_SZAM_POZ'=>'a <<MEZO>> mező csak pozitiv szám lehet!', //pozitív szám tizedes tört is lehet
			'ERR_EGESZ'=>'a <<MEZO>> mező  csak egész szám lehet!', //pozitív vagy negatív egész szám
			'ERR_EGESZ_POZ'=>'a <<MEZO>> mező  csak pozitív egész szám lehet!', //
			//text----------------------
			'ERR_ENG_SZO_KIS'=>'a <<MEZO>> mező  csak angol ABC kisbetűit tartalmazhtaja valamint számokat.Szóköz sem lehet!',
			'ERR_ENG_SZO'=>'a <<MEZO>> mező  csak angol ABC kis és nagybetűit tartalmazhtaja valamint számokat.Szóköz sem lehet!',  // 1 ha csak angol kis és nagybetű és szám van benne szóköz sem lehet
			'ERR_ENG_TOBB_SZO'=>'a <<MEZO>> mező  csak angol ABC kis és nagybetűit tartalmazhtaja valamint számokat és szóközt!',  //csak angol kis és nagybetű szám és szóköz van
			'ERR_ENG_TEXT'=>'csak angol ABC kis és nagybetűit tartalmazhtaja valamint számokat és szóközt és !?() karaktereket',//1 ha csak angol kis és nagybetű és szám szóköz és !?().:

			'ERR_MIN'=>'a <<MEZO>> mezőnek minimum <<MIN>> karakternek kell lennie!',
			'ERR_MAX'=>'a <<MEZO>> mező  maximum <<MAX>> karakternek lehet!',
			'ERR_HU_SZO_KIS'=>'a <<MEZO>> mező  csak a Magyar ABC kisbetűit tartalmazhtaja valamint számokat.Szóköz sem lehet!',
			'ERR_HU_SZO'=>'a <<MEZO>> mező  csak a Magyar ABC kis és nagybetűit tartalmazhtaja valamint számokat.Szóköz sem lehet!',  // eng_szo plusz ékezetesek
			'ERR_HU_TOBB_SZO'=>'a <<MEZO>> mező  csak a Magyar ABC ABC kis és nagybetűit tartalmazhtaja valamint számokat és szóközt!', //eng_tobb_szo plusz ékezetesek
			'ERR_HU_TEXT'=>'a <<MEZO>> csak a Magyar ABC kis és nagybetűit tartalmazhatja valamint számokat és szóközt és !?() karaktereket',//ures stringnél is hibát jelez!!!
			//tesztelve---------------
			//tagado 1 (true) az értéke ha megfelel a mintának, hogy a hiba legyen tagadni kell(!preg_match();)
			'ERR_MIN_MAX_UJ'=>'a <<MEZO>> mezőnek minimum <<min>>,maximum <<max>> karaktert kell tartalmaznia! ',//magyar karaktereket is figylembe veszi
			'ERR_MIN6_MAX20'=>'a <<MEZO>> mezőnek minimum 6,maximum 20 karaktert kell tartalmaznia!',//jelszónál pl
			//'MIN_MAX_UJ' =>'/^([a-záéíóöőúüűA-ZÁÉÍÓÖŐÚÜŰ0-9.,?!]){<<min>>,<<max>>}$/siu',
			//kereso------------------------
			'ERR_MAIL'=>'Az emailcím nem érvényes',
			'ERR_REGEX'=>'Regex hiba'
	] ;
}



/**
 függvényei nem alakítják át az adatokat csak az idézőjeleket.Azoknál figyelmeztetnek minden másnál hibát jeleznek.
 a hibát és figyelmeztetéseket logolják, hibánál a GOB::hibaT['ell']-t false ra állítják.
 */
class Ell_S{


	static public function Res($parT)
	{   $res=[];
	$res['bool']=true;
	$res['ADT']=$parT;
	$res['ADT']['SPT']=$_POST;
	return $res;

	}


	public static $hibaTbeir=true;
	 
	static public function regex_cserel($regtext,$parT=[])
	{

		foreach ($parT as $nev=>$val){
			$regtext= str_replace('<<'.$nev.'>>', $val, $regtext);
			// $regtext= str_replace('<<'.$nev.'>>', '<<'.$val.'>>', $regtext);
		}
		return $regtext;
	}
	static public function Regx($valnev,$regx,$parT=[],$getData='data',$datapar='')
	{
		$res=true;$changeT=[];

		if($getData=='data'){$data=\lib\ell\Get_S::Data($valnev,$datapar);}
		else{$data=\lib\ell\Get_S::DataPar($valnev,$datapar);}
		$regxkulcs=$regx;
		$regx=\lib\ell\RegexT::$regexT[$regx] ?? $regx;
		$regx=self::regex_cserel($regx,$parT);
		 
		if(isset(\lib\ell\Ell_lang::$LT['ERR_'.$regxkulcs] )){$err='ERR_'.$regxkulcs;}
		else{$err='ERR_REGEX';}
		$err=$parT['err'] ?? $err;
		//  echo $err.\lib\ell\Ell_lang::$LT['ERR_'.$regxkulcs];
		if (!preg_match($regx,$data))
		{
			\GOB::$logT['err']['ell'][]=[$_SESSION['userid'],$regx,$err];
			\GOB::$messageT['err']['ell'][$valnev][]=[$err,$parT];
			if(self::$hibaTbeir){ \GOB::$hibaT['ell']=false;}
			$res=false;
		}

		return $res;

	}



	static public function Text($valnev,$min=0,$max=2000,$getData='data',$datapar='')
	{
		$res=true;
		if($getData=='data'){$data=\lib\ell\Get_S::Data($valnev,$datapar);}
		else{$data=\lib\ell\Get_S::DataPar($valnev,$datapar);}
		//  $value= $data; '= &#039;  "= &quot; htmlspecialchars($data, ENT_QUOTES); nem jó!!! mert a < -t is kicseréli
		$value= str_ireplace('\'','&#039;', $data);
		$value= str_ireplace('"','&quot;', $value);
		if($data!=$value){
			//  echo 'val:'.$value;
			\GOB::$logT['alert']['ell'][]=[$_SESSION['userid'],'change_comma',$valnev];
			\GOB::$messageT['alert']['ell'][$valnev][]=['change_comma'];
		}

		$old_value=$data;
		$value2= strip_tags($data);
		// echo 'val:'.$value;
		if($old_value!=$value2){
			//  echo 'val:'.$value;
			\GOB::$logT['err']['ell'][]=[$_SESSION['userid'],'ERR_not_allowed_tag',$valnev];
			\GOB::$messageT['err']['ell'][$valnev][]=['ERR_not_allowed_tag'];
			$res=false;
			if(self::$hibaTbeir){ \GOB::$hibaT['ell']=false;}
		}

		$lenght=strlen($value);
		if($lenght<$min)
		{
			\GOB::$logT['err']['ell'][]=[$_SESSION['userid'],'ERR_MIN',$valnev];
			\GOB::$messageT['err']['ell'][$valnev][]=['ERR_MIN',['MIN'=>$min]];
			if(self::$hibaTbeir){ \GOB::$hibaT['ell']=false;}
			$res=false;
		}
		if($lenght>$max)
		{
			\GOB::$logT['err']['ell'][]=[$_SESSION['userid'],'ERR_MAX',count_chars($value),$max];
			\GOB::$messageT['err']['ell'][$valnev][]=['ERR_MAX',['Max'=>$max]];
			if(self::$hibaTbeir){ \GOB::$hibaT['ell']=false;}
			$res=false;
		}
		if($res){\GOB::$safeT[$valnev]=$value;}
		return $res;
	}


}



