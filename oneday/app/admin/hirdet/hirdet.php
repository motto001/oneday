<?php
namespace app\admin\hirdet;
defined( '_MOTTO' ) or die( 'Restricted access' );
//echo 'club';

class ADT{
	static  public $ADT=[
			'jog'=>'admin',
			'tablanev'=>'cikk2',

			'task'=>'alap',
			'limit'=>200, //hány tétel legyen egy oldalon a listában vagy táblázatban
			'view'=>'admin user',
			'viewF'=>'admin.html',
			'view_iniclass'=>'ViewInit', //ha van az aktuális tmpl-ben onnan ha nincs az app könyvtárbol tölti be
			'paramT'=>[],
			'evalSTR'=>'$this->ADT[\'dataT\'][\'id\']=$_POST[\'idT\'][0] ?? 0;'
    

	];
	public static $TRT=
	[
			 
			'SetTask'=>'trt\Task_ADT_SetTask',
			'Task'=>'trt\Task',
			'ChangeApp'=>'trt\Dom_ChangeApp',
			'ChangeData'=>'trt\Dom_ChangeData',
			'SrcID'=>'\trt\Change_SrcID'
	];

	public static $TSK=
	[

			'alap'=>
			[
					'SQL'=>'SELECT id,cim,substr(szoveg,1,200) as szoveg,media,pub FROM cikk2 WHERE kat=\'hirdetes\' ORDER BY sorrend ASC, id DESC',
					'TRT'=>['DataLista'=>'\trt\taskbase\Data','View'=>'\trt\taskbase\View_byinit'],
					'paramT'=>
					[
							'Iconsor'=>['iconsorT'=>['new','edit','pub','unpub','sorrend','del'=>['type'=>'task_del']]],
							'Content'=>
							[
									'namespace'=>'Tabla',
									'dataszerkT'=>
									[
											'chk'=>['nocim'=>true,'func'=>'checkbox_mezo'],
											'pub'=>['nocim'=>true,'func'=>'pub_mezo'],
											'cim'=>['noorder'=>true],
											'media'=>['noorder'=>true],
											'szoveg'=>['noorder'=>true]
									]
							]
					]
			],
			'sorrend'=>['TRT'=>['DataLista'=>'trt\taskbase\Data',
					'View'=>'\trt\taskbase\View_byinit',
					'Sorrend'=>'\app\admin\hirdet\Sorrend'],
					'paramT'=> ['Iconsor'=>['iconsorT'=>['sorment','cancel']],
							'Content'=> [
									'iniviewF'=>'sorrend.html','view_iniclass'=>'app\admin\slider\view\SliderIni']],
					'SQL'=>'SELECT id,cim FROM cikk2 WHERE kat=\'hirdetes\' ORDER BY sorrend ASC',],
			'sorment'=>['TRT'=>['Save_sorrend'=>'\app\admin\hirdet\Save_sorrend'],'next'=>'alap'],


			'new'=>['TRT'=>['View'=>'\trt\taskbase\View_byinit','Media'=>'\trt\Media'],
					'paramT'=> ['Content'=> [//'viewF'=>'app\admin\club\view\club_form.html',
							'viewF'=>'app/admin/hirdet/view/hirdet_form.html']]],
			'edit'=>['TRT'=>['Data'=>'trt\taskbase\Data'],'next'=>'new',
					'SQL'=>'SELECT id,cim,cimview,substr(szoveg,1,200) as szoveg,media,pub FROM cikk2 WHERE kat=\'hirdetes\' AND id=\'".$_POST[\'idT\'][0]."\''],
			'pub'=>['TRT'=>['Pub'=>'trt\task\Pub'],'next'=>'alap'],
			'cancel'=>['next'=>'alap'],
			'unpub'=>['TRT'=>['unPub'=>'\trt\task\Pub'],'next'=>'alap'],
			'del'=>['TRT'=>['Del'=>'\trt\task\Del'],'next'=>'alap'],
			'savenew'=>['next'=>'save'], //a Save postban érzékeli a savenew-t és a mentés után a new-ra irányít,nem a next-re
			 
			'save'=>['TRT'=>['Save'=>'\trt\taskbase\Save'],'next'=>'alap','hibatask'=>'edit',
					'mentmezoT'=>['cikk2'=>['kapcsolomezo'=>'userid', //csak többtáblánál kell
							'mezok'=>['kat','cim','cimview','szoveg','media','pub']]]],
			 
	];

}
trait dataScserel{
	public function  dataScserel(){
		//$this->ADT['dataT']['media']='oneday/'.$this->ADT['dataT']['media'];

		$dataT=\lib\db\DB::assoc_tomb("select * from cikk2 where kat='hirdetes'");
		foreach ($dataT as $dataS)
		{
				
			$sql="update cikk2 set media='oneday/".$dataS['media']."' where id='".$dataS['id']."' and kat='hirdetes'";
			//echo $sql;
			\lib\db\DBA::parancs($sql);

		}

	}
}
trait Sorrend{
	public function  Sorrend(){
		$dataT=$this->ADT['dataT'] ?? [];
		$res='';
		//  $item_view='<li id="sorid" class="ui-sortable-handle" ><button  dat-inner="cim" class="btn btn-primary "></button> </li>';
		//  $item_view='<li id="sorid" dat-inner="cim"> </li>';
		$item_view='<li id="sorid" ><div  class="btn btn-primary " dat-inner="cim" > </div></li>';
		$i=1;

		foreach ($dataT as $dataS)
		{
			$item_view2=str_replace('id="sorid"','id="'.$dataS['id'].'"', $item_view);
			$res.=\lib\html\dom\Dom_s::ChangeData($item_view2, $dataS);
			$i++;
		}


		$this->ADT['view']=str_replace('<!--sorrend-->', $res, $this->ADT['view']);
		 
	}

}


trait Save_Sorrend{
	public function  Save_Sorrend(){
		$sorrend=$_POST['sorrend'] ?? '';
		$sorrendT=explode(',',$sorrend);

		$i=1;
		foreach ($sorrendT as $data)
		{
			$sql="update cikk2 set sorrend='".$i."' where id='".$data."' and kat='hirdetes'";
			//echo $sql;
			\lib\db\DBA::parancs($sql);
			$i++;
		}


		//  $this->ADT['view']=str_replace('<!--sorrend-->', $res, $this->ADT['view']);
		 
	}

}



trait Lista
{
	static public function listaz($html,$dataT)
	{
		$res='';
		//   print_r($dataT);
		foreach($dataT as $dataS){
			$dataS['onclick']="beszur_item('".$dataS['id']."');";
			 
			$res.=\lib\html\dom\Dom_s::ChangeData($html, $dataS);
		}
		return $res;
	}
	 

	public function Lista()
	{// echo '-------------';
		$task=$this->ADT['task'];

		$viewF=$this->ADT['listaF']  ?? '';
		$viewF=$this->ADT['TSK'][$task]['listaF'] ?? $viewF;;
		$viewdir=$this->ADT['view_dir'] ?? '';
		$viewdir=$this->ADT['TSK'][$task]['view_dir'] ?? $viewdir;

		if($viewF!='')
		{
			if(isset($this->ADT['viewdir'])){$viewF=$this->ADT['viewDir'].DS.$viewF;}
			$html=\lib\base\File::getContent($viewF);

		}

		$this->ADT['view']=self::listaz($html, $this->ADT['dataT']);


	}


}



