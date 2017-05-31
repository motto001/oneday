<?php
namespace trt\taskbase;
defined( '_MOTTO' ) or die( 'Restricted access' );
//echo 'alap file';
trait Data_SqlPlusz{
	public function SqlPlusz($sql='')
	{
		$task=$this->ADT['task'];
		$taskId=$this->ADT['taskId'] ?? '';
		$rendezmezo=$_GET[$taskId.'rendez'] ?? '';
		$order=$_GET[$taskId.'order'] ?? 'DESC';
		if($rendezmezo!=''){$rendez=" ORDER BY $rendezmezo $order";}else{$rendez=' ORDER BY id DESC';}
		$pagenum=$_GET[$taskId.'page'] ?? 1;
		$limit=$this->ADT['limit'] ?? 50;
		$limitstart=($pagenum*$limit)-$limit;
		$limitSTR=" LIMIT $limitstart,$limit";
		if($sql==''){$sql=$this->ADT['TSK'][$task]['SQL'] ?? '';}
		eval('$sql="'.$sql.'";');
		//   echo $sql.$rendez.$limitSTR;
		return $sql.$rendez.$limitSTR;
	}
}
trait Data_SqlPlusz2{
	public function SqlPlusz2($sql='',$limit='',$rendezmezo='',$order='DESC')
	{
		$taskId=$this->ADT['taskId'] ?? '';
		if($rendezmezo!=''){$rendez=" ORDER BY $rendezmezo $order";}else{$rendez='';}

		$pagenum=$_GET[$taskId.'page'] ?? $_GET['page'] ?? 1;
		if($limit!=''){
			$limitstart=($pagenum*$limit)-$limit;
			$limitSTR=" LIMIT $limitstart,$limit";
		}else
		{$limitSTR='';}

		// echo $sql.$rendez.$limitSTR;
	
		return $sql.$rendez.$limitSTR;
	}
}
trait Data{

	use \trt\taskbase\Data_SqlPlusz2;
	public function DataListaSQLplusz($sql='')
	{
		$task=$this->ADT['task'];
		$taskId=$this->ADT['taskId'] ?? '';
		
		$limit=$_GET[$taskId.'limit'] ?? $_GET['limit'] ?? $_POST['limit'] ?? $this->ADT['TSK'][$task]['limit'] ?? $this->ADT['limit']  ?? '';
		if($limit=='all'){$limit='';}
		
		$order=$_GET[$taskId.'rendez'] ?? $_GET['rendez'] ?? $this->ADT['TSK'][$task]['rendez']  ?? '';
		$rendezmezo=$_GET[$taskId.'rendezmezo'] ?? $_GET['rendezmezo']  ?? $this->ADT['TSK'][$task]['rendezmezo'] ?? '';
		
	
		if(isset($this->ADT['TSK'][$task]['where'])){$where=' WHERE '.$this->ADT['TSK'][$task]['where'];}
		else{$where='';}
		
		
		$szuresmezoA=  $_POST['szuresmezo'] ?? [];
		$szuro='';
		foreach ($szuresmezoA as $szuresmezo) {
			 
		//	 $szures= $_POST[$szuresmezo] ?? '';
			if(isset($_POST[$szuresmezo]) && !empty($_POST[$szuresmezo])){
				//$like=str_ireplace(' ', '',$_POST[$szuresmezo]);
				$szuro.= $szuresmezo.' LIKE \'%'.$_POST[$szuresmezo].'%\' OR ';
			}
			
		//	if($szures!=''){}
			
		}
	//	echo '***'.$szuro;
		if($szuro!=''){$szuro=substr($szuro, 0,-3);}
	//	echo '***'.$szuro;
		if($where!='')
		{
			if($szuro!='')
			{	$where.= ' AND '.$szuro.'';}
		}
		else
		{	
			if($szuro!=''){$where.= ' WHERE '. $szuro;}
			
		}
		//echo $sql;
		
		$sql=$this->ADT['TSK'][$task]['SQL'] ?? $sql;
		eval('$sql="'.$sql.'";');
		$sql.=$where;

		$sql=$this->SqlPlusz2($sql,$limit,$rendezmezo,$order);
	//echo $sql;
	//$sql='SELECT * FROM userek WHERE id>6 AND email LIKE \'%citromail%\' OR csoport LIKE \'%kl%\' ORDER BY id DESC LIMIT 0,50';
		$dataT=\lib\db\DB::assoc_tomb_Count($sql);
		
		$sum=$dataT['sum'] ?? 0;//echo $dataT['sum'].'--'. $limit.ceil($sum/$limit);
		if($sum>0){
			$this->ADT['dataT']=$dataT['dataT'];
			$this->ADT['paramT']['Content']['dataT']=$dataT['dataT'];
			if($limit!=''){$this->ADT['paramT']['Pagin']['pages']= ceil($sum/$limit);}
			
		}
	}
	public function DataLista($sql='')
	{
		$task=$this->ADT['task'];
		if($sql==''){$sql=$this->ADT['TSK'][$task]['SQL'] ?? '';}
		$dataT=\lib\db\DB::assoc_tomb_Count($sql);

		$limit=$this->ADT['limit'] ?? 50;
		// print_r($dataT['dataT']) ;
		$sum=$dataT['sum'] ?? 0;//echo $dataT['sum'].'--'. $limit.ceil($sum/$limit);
		if($sum>0){
			$this->ADT['dataT']=$dataT['dataT'];
			$this->ADT['paramT']['Content']['dataT']=$dataT['dataT'];
			$this->ADT['paramT']['Pagin']['pages']= ceil($sum/$limit);
		}
	}

	public function Data($sql='')
	{
		$task=$this->ADT['task'];
		// $sql=$this->SqlPlusz();
		$sql2=$this->ADT['TSK'][$task]['SQL'] ?? '';
		eval('$sql="'.$sql2.'";');
		//echo $sql;
		//$sql="SELECT * FROM szallas WHERE id='".$_GET['id']."'";

		$dataT=\lib\db\DB::assoc_sor($sql);
		$ADTdataT=$this->ADT['dataT'] ?? [];
		$this->ADT['dataT']=array_merge($ADTdataT,$dataT);

		// $this->ADT['paramT']['Content']['dataT']=$dataT['dataT'];
	}


	/*
	 public function Fotoimport()
	 {
	 $sql="SELECT * FROM szallas";
	 $dataT=\lib\db\DB::assoc_tomb($sql);

	 foreach ($dataT as $dataS){
	 $kep1="";$kep2="";
	  
	  
	  
	 $sql="SELECT * FROM szallasfotok WHERE szallasid='".$dataS['id']."' and Foto_index='I' ";
	 $rs=\lib\db\DB::assoc_sor($sql);
	 $sql="SELECT * FROM szallasfotok WHERE szallasid='".$dataS['id']."' and Foto_index<>'I' ";
	 $rsT=\lib\db\DB::assoc_tomb($sql);
	 $kepidT=$rsT[0];
	 $kepid2=$kepidT['id'];

	 // print_r($rs);
	 $kepid1=$rs['id'] ?? '';
	 if(is_file('oneday/images/nagykepek/'.$kepid1.'.jpg')){$kep1='ROOT/images/nagykepek/'.$kepid1.'.jpg';}
	 else{$kep1='ROOT/images/nagykepek/'.$rsT[1]['id'].'.jpg';}

	 if(is_file('oneday/images/nagykepek/'.$kepid2.'.jpg')){$kep2='ROOT/images/nagykepek/'.$kepid2.'.jpg';}
	 $dT['kep1']=$kep1;
	 $dT['kep2']=$kep2;
	 \lib\db\DBA::frissit_tombbol('szallas',$dataS['id'],$dT,'id');
	 }
	 }

	 public function Szallasimport()
	 {

	 // print_r($dataT);
	 $pikT=[
	 'pikt1'=>'kártya',
	 'pikt2'=>'csekk',
	 'pikt3'=>'étterem',
	 'pikt4'=>'légkondi',
	 'pikt5'=>'akadálymentes',
	 'pikt6'=>'fürdőszoba',
	 'pikt7'=>'konyha',
	 'pikt8'=>'parkoló',
	 'pikt9'=>'kert',
	 'pikt10'=>'tv',
	 'pikt11'=>'kisállatok',
	 'pikt12'=>'wifi',
	 'pikt13'=>'internet',
	 'pikt14'=>'gyermekjáték',
	 'pikt15'=>'ertibútor',
	 'pikt16'=>'grillező',
	 'pikt17'=>'hitelkártya',
	 'pikt18'=>'medence',
	 'pikt19'=>'pezsgőkád',
	 'pikt20'=>'szolárium',
	 'pikt21'=>'szauna',
	 'pikt22'=>'masszázs',
	 'pikt23'=>'konditerem',
	 'pikt24'=>'fodrászat',
	 'pikt25'=>'kozmetika',
	 'pikt26'=>'sípálya',
	 'pikt27'=>'teniszpálya'];
	 /*  'pikt1'=>'One Day Kártya elfogadás',
	 'pikt2'=>'üdülési csekk elfogadás',
	 'pikt3'=>'étterem',
	 'pikt4'=>'légkondi',
	 'pikt5'=>'mozgáskorlátozottak számára',
	 'pikt6'=>'saját fürdőszoba',
	 'pikt7'=>'felszerelt konyha',
	 'pikt8'=>'zárt parkoló',
	 'pikt9'=>'kert',
	 'pikt10'=>'televízió a szobában',
	 'pikt11'=>'kisállatok fogadása',
	 'pikt12'=>'wifi',
	 'pikt13'=>'internet hozzáférés',
	 'pikt14'=>'gyermekjáték',
	 'pikt15'=>'kertibútor',
	 'pikt16'=>'grillező, kerti sütő',
	 'pikt17'=>'hitelkártya elfogadás',
	 'pikt18'=>'medence',
	 'pikt19'=>'pezsgőkád',
	 'pikt20'=>'szolárium',
	 'pikt21'=>'szauna',
	 'pikt22'=>'masszázs',
	 'pikt23'=>'konditerem, sporthelyiség',
	 'pikt24'=>'fodrászat',
	 'pikt25'=>'kozmetika, szépségszalon',
	 'pikt26'=>'sípálya',
	 'pikt27'=>'teniszpálya'];*/
	/*
	 $sql="SELECT * FROM odc_szallas";
	 $dataT=\lib\db\DB::assoc_tomb($sql);

	 foreach ($dataT as $dataS){
	 $orszagT=['1'=>'HU','2'=>'RO','3'=>'HR','4'=>'SL','5'=>'SK','6'=>'AT'];
	 $sql="SELECT * FROM odc_varosok WHERE Af_varosID='".$dataS['Af_telepules']."'";
	 $rs=\lib\db\DB::assoc_sor($sql);
	 $orszag=$orszagT[$dataS['Af_orszag']] ?? ''; $telep=$rs['Af_varosNev'] ?? '';$cim=$dataS['Af_cim'] ?? '';
	  
	 $dT['cim']=$orszag.'; '.$telep.'; '.$cim;
	  
	 $pikSTR='';
	 for ($i = 1; $i < 28; $i++) {
	 $piknev='pikt'.$i;
	 if(isset($dataS['Af_'.$piknev]) && $dataS['Af_'.$piknev]=='I')
	 {$pikSTR.=$pikT[$piknev].'|';}
	 // Af_pikt1 Af_pikt1
	 }
	 $pikSTR = substr($pikSTR, 0, -1);

	 $dT['pikt']=$pikSTR ;

	 $irszam=$dataS['Af_hirdeto_irszam'] ?? ''; $telep=$dataS['Af_hirdeto_telepules'] ?? '';$cim=$dataS['Af_hirdeto_cim'] ?? '';
	  
	 $dT['hirdeto_cim']=$irszam.' '.$telep.'; '.$cim;
	 if($dataS['Af_aktiv']=='I'){$dT['pub']='0';}else{$dT['pub']='1';}

	 \lib\db\DBA::frissit_tombbol('szallas',$dataS['Af_id'],$dT,'id');

	 }
	 }
	 */



	/*
	 public function Userimport()
	 {
	 $sql="SELECT * FROM odc_vendeg";
	 $dataT=\lib\db\DB::assoc_tomb($sql);
	 // print_r($dataT);
	 foreach ($dataT as $dataS){
	 // echo '--'.$dataS['Afv_email'] ;
	 $dT['id']=$dataS['Afv_id']  ?? ''  ;
	 $dT['oldid']=$dataS['Afv_id']  ?? ''  ;
	 $nev1=$dataS['Afv_vezeteknev'] ?? ''; $nev2=$dataS['Afv_keresztnev'] ?? '';
	 $dT['name']=$nev1.' '.$nev2;
	 $dT['username']=$dataS['Afv_email']  ?? ''  ;
	 $dT['email']=$dataS['Afv_email'] ?? '';
	 $dT['password']=md5($dataS['Afv_jelszo']) ;
	 $dT['jelszo']=$dataS['Afv_jelszo'] ?? '' ;
	 $dT['tel']=$dataS['Afv_telefon'] ?? '' ;
	 $orszag=$dataS['Afv_orszag'] ?? ''; $irszam=$dataS['Afv_irszam'] ?? ''; $telep=$dataS['Afv_telepules'] ?? '';$cim=$dataS['Afv_cim'] ?? '';
	 $dT['cim']=$orszag.', '.$irszam.' '.$telep.', '.$cim;
	 $dT['datum']=$dataS['Afv_datum'] ?? '' ;
	 $dT['lejar']=$dataS['Afv_erv_veg'] ?? '' ;
	 $dT['statusz']=$dataS['Afv_tipus'] ?? '' ;
	 $dT['pub']='0';
	 \lib\db\DBA::beszur_tombbol('userek',$dT);

	 }



	 }*/

}