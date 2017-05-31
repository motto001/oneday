<?php
namespace app\admin\szallas;
defined( '_MOTTO' ) or die( 'Restricted access' );

class ADT{
	static  public $ADT=[
			'jog'=>'admin',
			'tablanev'=>'szallas',
			'task'=>'alap',
			'limit'=>70, //hány tétel legyen egy oldalon a listában vagy táblázatban
			'view'=>'admin user',
			'viewF'=>'admin.html',
			'view_iniclass'=>'ViewInit', //ha van az aktuális tmpl-ben onnan ha nincs az app könyvtárbol tölti be
			'paramT'=>[],
			'evalSTR'=>'$this->ADT[\'dataT\'][\'id\']=$_POST[\'idT\'][0] ?? 0;$this->ADT[\'id\']=$_POST[\'id\'] ?? 0;'
    

	];
	public static $TRT=
	[
			'SetTask'=>'trt\Task_ADT_SetTask',
			'Set_ID'=>'trt\Set_ID',
			'Task'=>'trt\Task',
			'ChangeApp'=>'trt\Dom_ChangeApp',
			'ChangeData'=>'trt\Dom_ChangeData',
			'SrcID'=>'trt\Change_SrcID',
	];

	public static $TSK=
	[
			'alap'=>
			[
					'SQL'=>'SELECT * FROM szallas','rendez'=>'DESC','rendezmezo'=>'id',
					'TRT'=>['DataListaSQLplusz'=>'\trt\taskbase\Data','View'=>'\trt\taskbase\View_byinit',
								'SzuroMezok'=>'\app\admin\szallas\SzuroMezok'],
					'paramT'=>
					[
							'Iconsor'=>['iconsorT'=>['new','edit','pub','unpub','email','del'=>['type'=>'task_del']]],
							'Content'=>
							[
									'namespace'=>'Tabla',
									'dataszerkT'=>
									[
											'chk'=>['nocim'=>true,'func'=>'checkbox_mezo'],
											'pub'=>['nocim'=>true,'func'=>'pub_mezo'],
											'varos'=>['szures'=>'input'],
											'id'=>[],
											'nev'=>['szures'=>'input'],
											'bemutat'=>[],
											'hirdeto_tel'=>[],'datum'=>[],
									]
							]
					]
			],
			'new'=>['TRT'=>['View'=>'\trt\taskbase\View_byinit','Media'=>'\trt\Media',
					'Checklist'=>'\app\checklist\Checklist','Imagelist'=>'\app\admin\trt\Imagelist'],
					'paramT'=> ['Content'=> [//'viewF'=>'app\admin\club\view\club_form.html',
							'iniviewF'=>'szallas_form.html','view_iniclass'=>'app\admin\szallas\view\SzallasIni']]],
			'new2'=>['TRT'=>['View'=>'\trt\taskbase\View_byinit','Media'=>'\trt\Media',
					'Checklist'=>'\app\checklist\Checklist','Imagelist'=>'\app\admin\trt\Imagelist'],'viewF'=>'admin_body.html',
					'paramT'=> ['Content'=> [//'viewF'=>'app\admin\club\view\club_form.html',
							'iniviewF'=>'szallas_form.html','view_iniclass'=>'app\admin\szallas\view\SzallasIni']]],
			'edit'=>['TRT'=>['Data'=>'trt\taskbase\Data'],'next'=>'new',//'SQL'=>'SELECT * FROM szallas WHERE id=\'".$_POST[\'idT\'][0]."\''],
					'SQL'=>'SELECT * FROM szallas WHERE id=\'".$this->ADT[\'id\']."\''],
			'edit2'=>['TRT'=>['Data'=>'trt\taskbase\Data'],'next'=>'new2',//'SQL'=>'SELECT * FROM szallas WHERE id=\'".$_POST[\'idT\'][0]."\''],
					'SQL'=>'SELECT * FROM szallas WHERE id=\'".$this->ADT[\'id\']."\''],

			'pub'=>['TRT'=>['Pub'=>'trt\task\Pub'],'next'=>'alap'],
			'unpub'=>['TRT'=>['unPub'=>'\trt\task\Pub'],'next'=>'alap'],
			'del'=>['TRT'=>['Del'=>'\trt\task\Del'],'next'=>'alap'],

			'savenew'=>['next'=>'save'], //a Save postban érzékeli a savenew-t és a mentés után a new-ra irányít,nem a next-re
			'saveimage'=>['TRT'=>['Imagelist'=>'\app\admin\trt\Imagelist']],
			'imagedel'=>['TRT'=>['Imagelist'=>'\app\admin\trt\Imagelist']],
			'save'=>['TRT'=>['Save'=>'\trt\taskbase\Save'],'next'=>'alap','hibatask'=>'edit',
					'mentmezoT'=>['szallas'=>['kapcsolomezo'=>'szallasid',
							'mezok'=>['szjelszo','nev','orszag','varos','cim','bemutat','egyeb','kep1','kep2','pikt','hirdeto_cegnev','hirdeto_nev','hirdeto_cim','hirdeto_tel','hirdeto_email','pub']]]],


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
trait SzuroMezok{
	
	public function CsoportSelect(){
	$res='	<label>Csoport Szűrés:</label>
		<select id="szures" name="szures" >';
	
	$sql="SELECT id, GROUP_CONCAT( csoport SEPARATOR ',') as csoport FROM userek";
	$smezo=	\lib\db\DB::assoc_sor($sql);
	$csoportA=explode(',',$smezo['csoport']);
	$csoportA=array_unique($csoportA);
	foreach ($csoportA as  $value) {
	$res.='<option value="'.$value.'">'.$value.'</option>'	;
	}	
		$res.='</select>';
		return  $res;
	}
	
	public function SzuroMezok(){
	$docread='	
	$("#limit").val(limit) ;
	$("#szures").val(szures) ;
	$("input[name=kijelol][value=" + kijelol + "]").attr("checked", "checked");
	if(kijelol=="all" || kijelol=="visible"){$("input[class=tabcheck").attr("checked",true);}
			
	$(".page-link").click(function(){ 
		 $("#tablaform").attr("action",$(this).attr("href"));
	        $("#tablaform").submit();
	        return false;
		});
	$(".rendezikon").click(function(){ 
		
		 $("#tablaform").attr("action",$(this).attr("href"));
	        $("#tablaform").submit();
	        return false;
		});
			
	 $("input[class=kijelol]").change(function() {
		 kijelol = $(this).val();  
		 if(kijelol=="all"|| kijelol=="visible"){$("input[class=tabcheck").prop("checked", true);}
		 else{$("input[class=tabcheck").prop("checked", false);}
		      
	    });';	
	\GOB::$paramT['html']['head']['docread'][]=$docread;
		$kijelol='  <label>Kijelölés:
  					<input type="radio" class="kijelol" name="kijelol" value="visible"> Láthatóak	
  					<input type="radio" class="kijelol" name="kijelol" value="nincs"> Eggyiksem	';
		$limit='<label> | Megjelnített sorok:</label>
  					<select id="limit" name="limit" >
					  <option value="50" selected >50</option>
					  <option value="100"  >100</option>
					  <option value="200">200</option>
					  <option value="500">500</option>
					  <option value="all">mind</option>
					</select>';
		$frissit='<button class="btn btn-primary btn-xs"  type="submit" name="task"
                                 value="alap">Keres,Frissit</button> ';
		
		$this->ADT['view']= str_replace('<!--limit-->', $limit,$this->ADT['view'] );
		$this->ADT['view']= str_replace('<!--kijelol-->', $kijelol,$this->ADT['view'] );
		$this->ADT['view']= str_replace('<!--frissit-->', $frissit,$this->ADT['view'] );
		///$this->ADT['view']= str_replace('<!--csoport-->',$this->CsoportSelect(),$this->ADT['view'] );
		
	}
}