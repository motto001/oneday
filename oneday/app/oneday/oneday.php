<?php
namespace app\oneday;
header('Access-Control-Allow-Origin: http://email.helyiakciok.hu/index.php');
defined( '_MOTTO' ) or die( 'Restricted access' );
//echo '--------------------------';
class ADT{
	static  public $ADT=[
			'jog'=>'user',
			'tablanev'=>'slider',
			'task'=>'alap',
			'view'=>'',
			'viewF'=>'base.html',
			'view_iniclass'=>'ViewInit', //ha van az aktuális tmpl-ben onnan ha nincs az app könyvtárbol tölti be
			'paramT'=>[],
			'evalSTR'=>''
    
	];
	public static $TRT=
	[
			'SetTask'=>'trt\Task_ADT_SetTask',
			'Task'=>'trt\Task',
			'ChangeApp'=>'trt\Dom_ChangeApp',
			'ChangeData'=>'trt\Dom_ChangeData',
			'SrcID'=>'trt\Change_SrcID',
	];

	public static $TSK=
	[   'szallasemail'=>
			[

					'TRT'=>[ 'Szallas'=>'\app\oneday\Email'  ],
			],
			'contact'=>
			[

					'TRT'=>[ 'Contact'=>'\app\oneday\Email'  ],
			],
			'hirdet'=>
			[

					'TRT'=>[ 'Hirdet'=>'\app\oneday\Hirdet'  ],
			],
			'sql'=>
			[

					//'TRT'=>[ 'SQL'=>'\app\oneday\SQL' ],
			],

			'alap'=>
			[
					'SQL'=>'SELECT * FROM slider WHERE pub=0 AND slid_id=\'nyito\' ORDER BY sorrend ASC','ChangeApp'=>'nem',
					'TRT'=>['DataLista'=>'\trt\taskbase\Data',
							//'View'=>'\trt\taskbase\View_byinit',
							'Slider'=>'\app\oneday\Slider',
							'Fomenu'=>'\app\oneday\Fomenu',
							'Nyitoszoveg'=>'\app\oneday\Nyitoszoveg'
					],
			],
			'keresoform'=>
			[
					'SQL'=>'SELECT * FROM szallas WHERE pub=0 ','ChangeApp'=>'nem',
					'TRT'=>['DataLista'=>'\trt\taskbase\Data',
							//'View'=>'\trt\taskbase\View_byinit',
							// 'Slider'=>'\app\oneday\Slider',
							'Keres_form'=>'\app\oneday\Keres' ,
							'Szolglista'=>'\app\oneday\Szolglista',
							'Varoslista'=>'\app\oneday\Varoslista',
							'Szallaslista'=>'\app\oneday\Szallaslista',
							'Fomenu'=>'\app\oneday\Fomenu'
					],
			],

			'modal'=>['SQL'=>'SELECT * FROM szallas WHERE id=\'".$_GET[\'id\']."\'','ChangeApp'=>'nem',
					'TRT'=>['Data'=>'\trt\taskbase\Data',
							'Modal'=>'\app\oneday\Modal']],
			'logout'=>['TRT'=>['Kilep'=>'app\login\trt\task\Kilep']] ,
			'email'=>['TRT'=>['View'=>'\trt\taskbase\View_byinit'],
					'paramT'=>
					[
							// 'Iconsor'=>['iconsorT'=>['email']],
							'Content'=>
							[
									'viewF'=>'MOtto/tmpl/baseadmin/app/email/email_form.html',
									//'view_iniclass'=>'ViewInit'
							]
					],

					'evalSTR'=>'$_SESSION[\'idT\']=$_POST[\'idT\']; $this->ADT[\'dataT\'][\'fromnev\']=\CONF::$fromnev;
        $this->ADT[\'dataT\'][\'setfrom\']=\CONF::$mailfrom;'
			],
			'mailkuld'=>['TRT'=>['Mailkuld'=>'\trt\task\Mailkuld'],'next'=>'alap'],
	];

}
trait SQL{
	public function SQL(){
		$res='';
		// $dataT3=\lib\db\DB::assoc_tomb('SELECT * FROM cikk2 WHERE kat=\'hirdetes\' ORDER BY sorrend ASC');

		$dataT=\lib\db\DB::assoc_tomb('SELECT * FROM odc_referenciak');
		// print_r($dataT);


		foreach ($dataT as $dataS)
		{
			//  if($dataS['cimview']=='0'){$dataS['cim']='';}
			$dataT2=\lib\db\DB::assoc_sor("SELECT * FROM odc_rfotok where Fokep='".$dataS['Afr_id']."'");
			$fotoid=$dataT2['Foto_id'] ?? 'nokep';
			$foto='images/referenciak/'.$fotoid.'.jpg';
			$szoveg=$dataS['Afr_cim'];
			$cim=substr($szoveg, 0,30);
			if($dataS['Afr_aktiv']=='I') {$pub='0';}else{$pub='1';}
			$sql="insert into cikk2 (kat,cim,szoveg,media,pub)values('hirdetes','".$cim."','".$szoveg."','".$foto."','".$pub."') ";
			\lib\db\DBA::parancs($sql);
		}

		$this->ADT['view']= 'ok: '.$sql;

	}
}


trait Email{

	public   $setfom= '';
	public   $fromnev='';
	public   $cim= '';
	public   $cimzett='';
	public   $subject='';
	public   $body= '';

	public function Emailbeir(){
		$sql="insert into email (userid,setfrom,fromnev,cim,cimzett,subject,body)values ('".$_SESSION['userid']."','".$this->setfom."','". $this->fromnev."','".$this->cim."','".$this->cimzett."','".$this->subject."','".$this->body."') ";
		$emailT= \lib\db\DBA:: beszur($sql);
		// $this->ADT['view']= json_encode($emailT);
		//  $this->ADT['view']= "{'emailid': '15'}";
		return $emailT['id'] ;
	}
	public function Contact(){
		$res='';
		// $code=\lib\str\STR::randomSTR(10);
		// $userT=\lib\db\DB::assoc_sor('SELECT id,name,email FROM userek WHERE id=\''.$_SESSION['userid'].'\'');
		$this->setfom=\lib\ell\Get_S::Text('setfrom',2,50);
		$this->fromnev=\lib\ell\Get_S::Text('fromnev',2,50);
		$this->body=\lib\ell\Get_S::Text('body',2,1000);

		$this->cim=\CONF::$mailfrom;
		$this->cimzett='Admin';
		$this->subject='kapcsolat';

		if($res==''){
			$id= $this->Emailbeir();
			if($id!=0){header("Location: http://email.helyiakciok.hu/index.php?emailid=".$id);}
			else{$this->ADT['view']= 'Adatbázis hiba';}
		}
	}

	public function Szallas(){
		$res='';
		// $code=\lib\str\STR::randomSTR(10);
		// $userT=\lib\db\DB::assoc_sor('SELECT id,name,email FROM userek WHERE id=\''.$_SESSION['userid'].'\'');
		$this->setfom=\lib\ell\Get_S::Text('setfrom',2,50);
		$this->fromnev=\lib\ell\Get_S::Text('fromnev',2,50);

		$link='<a href="http://oneday.helyiakciok.hu/'.\lib\ell\Get_S::Text('szallaslink',2,100).'">szallodalink</a>';
		$this->body="<h3>".$link."</h3>\n".\lib\ell\Get_S::Text('body',2,1000);
		$this->cim=\CONF::$mailfrom;
		$this->cimzett='Admin';
		$this->subject='Szálloda info';

		if($res==''){
			$id= $this->Emailbeir();
			if($id!=0){header("Location: http://email.helyiakciok.hu/index.php?emailid=".$id);}
			else{$this->ADT['view']= 'Adatbázis hiba';}
		}
	}
}


trait Szolglista{
	public function  Szolglista(){
		$list= \app\checklist\Checklist_Iconlist_thumbS::Res();
		$this->ADT['view']= str_replace('<!--checklist-->', $list,$this->ADT['view'] );
	}}
	trait Varoslista{
		public function  Varoslista(){
			$varosT=[];
			$res='<div id="hu">Magyarország</div> ';
			$sql="select id,orszag,varos,cim from szallas";
			$cimT=\lib\db\DB::assoc_tomb($sql);
			foreach ($cimT as $cimS) {
				$varos= $cimS['varos'] ?? '';
				if(!in_array($varos, $varosT)){
					$varosT[]=$varos;
					if($cimS['orszag']=='HU') {$orszag='HU';}else{$orszag='EGYEB';}
					$dataT[$orszag][]=['id'=>$cimS['id'],'varos'=>$varos];
				}
			}

			foreach ( $dataT['HU'] as $dataS) {
				if(!empty($dataS['varos']))  {

					$res.=' <span id="varos'.$dataS['id'].'" class="btn btn-primary" onclick="
         jelol(\'varos'.$dataS['id'].'\',\''.$dataS['varos'].'\');">'.$dataS['varos'].' </span>';

				}

			}
			$res.='<div>Külföld</div>';
			foreach ( $dataT['EGYEB'] as $dataS) {
				if(!empty($dataS['varos']))  {
					$res.=' <span id="varos'.$dataS['id'].'" class="btn btn-primary" onclick="
         jelol(\'varos'.$dataS['id'].'\',\''.$dataS['varos'].'\');">'.$dataS['varos'].' </span>';
				}
			}
			 
			$this->ADT['view']= str_replace('<!--varoslist-->', $res,$this->ADT['view'] );
			 
		}

	}

	trait Hirdet{
		public function Hirdet(){

			//	<div class="flexrow">   flexbox hoz kell itt nem használjuk
			//	$item_view='<div class="flexhirdet" dat-id="id" style="margin-top:10px;" >

			$res='<center><h3>Eladó,kiadó üdülési hetek</h3></center>
            <style>
  .hirdetesitem{
-webkit-border-bottom-right-radius: 20px;
-moz-border-radius-bottomright: 20px;
border-bottom-right-radius: 20px;
   border-style: solid;
    border-width: 0px 0px 3px 0px;
  
   min-height:100px;padding:5px;overflow:hidden;
  background-color:#D6DBDF;
    }
            </style>
 <div class="col-sm-6"> ';
			$res2=' <div class="col-sm-6">            ';
			$dataT=\lib\db\DB::assoc_tomb('SELECT * FROM cikk2 WHERE kat=\'hirdetes\' AND pub=\'0\' ORDER BY sorrend ASC,id DESC');
			// print_r($dataT);
			$item_view='<div class="flexhirdet" dat-id="id" style="margin-top:10px;" >
   <div class=" hirdetesitem ">
     <div  style="float:left;" dat-inner="image" > </div>
   
       <h4 dat-inner="cim" id="nev" ></h4>
       <h5 dat-inner="szoveg" id="egyeb" ></h5>
       </div>
    </div>';
			$this->ADT['view']=file_get_contents(\PATH::$rootDir.'/tmpl/oneday/app/oneday/kereso.html',true);
			$i=1;
			foreach ($dataT as $dataS)
			{
				if(empty($dataS['media']) || $dataS['media']=='images/referenciak/.jpg'){$dataS['image']='';}else{
					$dataS['image']='<img style="margin:10px;max-height:200px;" class="img-thumbnail" dat-src="media" width="200px"  src="'.$dataS['media'].'">';
				}
					
				// $dataS['media']='oneday/'.$dataS['media'];
				if($dataS['cimview']=='0'){$dataS['cim']='';}
				if($i % 2 == 0){$res2.=\lib\html\dom\Dom_s::ChangeData($item_view, $dataS);}
				else{$res.=\lib\html\dom\Dom_s::ChangeData($item_view, $dataS);}
				$i++;
			}
			$res.='</div>';
			$res2.='</div>';
			$this->ADT['view']= str_replace('<!--content-->', $res.$res2,$this->ADT['view'] );

		}

	}



	trait Keres{
		public function  Keres_form(){
			// echo $_POST['hiddenkereso'];
			$this->ADT['view']=file_get_contents(\PATH::$rootDir.'/tmpl/oneday/app/oneday/kereso.html',true);
			$keresform=file_get_contents(\PATH::$rootDir.'/app/oneday/view/kereso_form.html',true);
			$this->ADT['view']= str_replace('<!--kereso-->', $keresform,$this->ADT['view'] );
			// $this->ADT['view']='-------------------';
		}
		public function  Keres(){


		}
	}
	trait Szallaslista2{
		public function  Szallaslista(){
			$sql="select id,nev,cim from szallas2 ";
			$dataT = \lib\db\DB::assoc_tomb($sql);
			//  print_r($dataT);
			foreach ($dataT as $dataS)
			{
				$cimT=explode(';',$dataS['cim']) ?? [];
				$varos=str_ireplace(' ', '',$cimT[1] ) ?? 'NO';
				$orszag=str_ireplace(' ', '',$cimT[0]) ?? 'NO';
				$cim=$cimT[2] ?? 'NO';
				$sql2="update szallas set orszag='".$orszag."', varos='".$varos."', cim='".$cim."' where id='".$dataS['id']."'";
				//  echo $sql2;
				\lib\db\DBA::parancs($sql2);
			}

		}}
		trait Szallaslista{
			public function  Szallaslista(){
				$res='';
				$item_view='
 <div  dat-id="id" class="szallasthumb"  data-varos="eee" data-szolg="" data-vis=""

            style="display:visible;width:16%;height:180px;padding:5px;overflow:hidden;float:left;" >
   <div class="listathumb" dat-onclick="onclick" onclick="" data-toggle="modal" data-target="#myModal" >
        <img style="" dat-src="kep1" width="98%" height="125px" src="">
        <div dat-inner="nev" id="nev" style="margin:10px;font-size:16px,bold;" class="thumb_nev">
        </div>
    </div>
 </div>            ';
				$kereso=$_POST['kereso'] ?? '';
				$keres=true;
				if($kereso=='')
				{//echo 'kkkkkkkkk'.$keresoszo;
					$sql="select id,nev,varos,kep1 from szallas where pub=0";
					$dataT = \lib\db\DB::assoc_tomb($sql);
					$keres=false;
				}else
				{
					$kereso=str_ireplace(',', ' ', $kereso);
					$keresoT=explode(' ', $kereso);
					$dataT1=[];$dataT3=[];
					foreach($keresoT as $keres)
					{
						//$sql="select id,nev,varos,kep1 from szallas where pub=0 and (nev LIKE '%".$keres."%' or bemutat LIKE '%".$keres."%' or egyeb LIKE '%".$keres."%') ";
						$sql="select id,nev,varos,kep1 from szallas where pub=0 and (LOWER(nev) LIKE LOWER('%".$keres."%') or LOWER(bemutat) LIKE LOWER('%".$keres."%') or LOWER(egyeb) LIKE LOWER('%".$keres."%')) ";
						$dataT1 = array_merge( $dataT1,\lib\db\DB::assoc_tomb($sql));
					}
					foreach($dataT1 as $dataS)
					{
						$dataS['visible']='visible';
						$dataT3[]= $dataS;
					}

					$sql="select id,nev,varos,kep1 from szallas where pub=0";
					$dataT2 = \lib\db\DB::assoc_tomb($sql);
					$dataT = array_merge($dataT2, $dataT3);
				}

				 
				foreach ($dataT as $dataS)
				{
					 
					$dataS['kep1']= \lib\base\LINK::thumb_src( $dataS['kep1']);
					$link='index.php?app=szallas&id='.$dataS['id'];
					$dataS['onclick']='modal_betolt(\''.$link.'\',\'modalbase\');';
					$visible =$dataS['visible'] ?? 'none';
					$dataS['visible']=$visible;
					$dataS['szolg']=$dataS['pikt'] ?? '-';
					$dataS['vis']=$dataS['visible'];
					 
					$item=\lib\html\dom\Dom_s::ChangeData($item_view, $dataS);
					$item=\lib\html\dom\Dom_s::setData($item, $dataS);
					 
					if($keres && $dataS['visible']!='visible'){
						$item=str_replace('display:visible','display:none',$item );
					}
					$res.=$item;
					//echo $item;
				}
				$this->ADT['view']= str_replace('<!--szallaslist-->', $res,$this->ADT['view'] );
			}

		}
		trait Fomenu{
			public function  Fomenu(){
				$item_view=file_get_contents(\PATH::$rootDir.'/app/oneday/view/fomenu.html',true);
				//  echo '--------'.$item_view;
			$admingomb='<a href="index.php?app=admin\slider"  lt-inner="email" class="btn btn-primary "> <span style="font-size:18px;" class="glyphicon glyphicon-text-background"></span></a>';	
			
			if(\GOB::get_userjog('admin')){$item_view.=$admingomb;}
			
			$this->ADT['view']= str_replace('<!--fomenu-->', $item_view,$this->ADT['view'] );
			}

		}

		trait Slider{
			public function  Slider(){
				$dataT=$this->ADT['dataT']?? '';
				$html=file_get_contents(\PATH::$rootDir.'/tmpl/oneday/app/oneday/slider.html',true);
				$view=file_get_contents(\PATH::$rootDir.'/tmpl/oneday/app/oneday/view/slider.html',true);
				$item_view= \lib\html\dom\Dom_S::getViewFromHTML($view,'slider_item');
				//echo '---------vbmcvnv'. $item_view;
				$res='';
				// 'style="display: none;"';
				$i=1;
				foreach ($dataT as $dataS)
				{
					$dataS['kepthumb']= \lib\base\LINK::thumb_src( $dataS['kep']);
					$intro=$dataS['intro'] ?? '';
					$dataS['intro']=substr($intro, 0,200);
					$dataS['onclick']='modal_betolt(\''.$dataS['link'].'\',\'modalbase\');';
					//  $dataS['onclick']='taskbeallit(\'szallasemail\',\''.$dataS['link'].'\');"';
					if($i==1){$dataS['visible']='';}
					else
					{$dataS['visible']='display: none;';}
					$res.=\lib\html\dom\Dom_s::ChangeData($item_view, $dataS);
					$i++;
				}

				$html= str_replace('<!--lista-->', $res,$html )  ;
				$this->ADT['view']=$html;
				//   $this->ADT['view']= str_replace('<!--:Content-->', $html,$this->ADT['view'] )  ;
			}

		}
		trait Nyitoszoveg{
			public function Nyitoszoveg (){
				$dataS=\lib\db\DB::assoc_sor("select szoveg from cikk2 where id='1'");
				$this->ADT['view']=\lib\html\dom\Dom_s::ChangeData($this->ADT['view'], $dataS);

			}

		}



		trait Modal{
			public function  Modal(){
				$dataT=$this->ADT['dataT'] ?? '';
				$html=file_get_contents(\PATH::$rootDir.'/tmpl/oneday/app/oneday/view/szallas_modal.html',true);
				//print_r($dataT);
				$res=\lib\html\dom\Dom_s::ChangeData($html,$dataT);

				$this->ADT['view']=$res;

			}

		}

		class Checklist_S
		{
			public static function Res($parT=[]){
				 
				return \App_s::Res('checklist',$parT);
			}
		}