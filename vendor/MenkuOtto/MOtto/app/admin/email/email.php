<?php
namespace app\admin\email;

defined( '_MOTTO' ) or die( 'Restricted access' );
//echo 'club';

class ADT{
static  public $ADT=[
        'jog'=>'admin',
        'tablanev'=>'email',
        'task'=>'alap',
        'limit'=>70, //hány tétel legyen egy oldalon a listában vagy táblázatban
       // 'view'=>'admin user',
        'viewF'=>'admin.html',
        'view_iniclass'=>'ViewInit', //ha van az aktuális tmpl-ben onnan ha nincs az app könyvtárbol tölti be
        'paramT'=>[],
     
       
  
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
['reslista'=>
    [
  //  'SQL'=>'SELECT id,substr(cim,1,20) as cim,substr(subject,1,20) as subject,substr(body,1,20) as body,total,sended,csoport,datum FROM email','rendez'=>'DESC','rendezmezo'=>'id',
      'SQL'=>'SELECT * FROM eposted WHERE emailid=\'".$_GET[\'id\']."\'',
 		'viewF'=>'MOtto/tmpl/baseadmin/admin_body.html',
    		'TRT'=>['DataListaSQLplusz'=>'\trt\taskbase\Data',
    		'View'=>'\trt\taskbase\View'],
    		
       'paramT'=>
        [
        
          'Content'=>
            [
             'namespace'=>'Tabla',
            'tabla'=>'eposted',
              'dataszerkT'=>
                  [ 
                  'touserid'=>['cim'=>'userid','noorder'=>true],
                	'cim'=>['maxchar'=>30,'noorder'=>true],
                   'cimzett'=>['maxchar'=>20,'noorder'=>true], 
                  	'res'=>['noorder'=>true],              
                  ]
            ]
        ]  
    ],
'alap'=>
    [
  //  'SQL'=>'SELECT id,substr(cim,1,20) as cim,substr(subject,1,20) as subject,substr(body,1,20) as body,total,sended,csoport,datum FROM email','rendez'=>'DESC','rendezmezo'=>'id',
      'SQL'=>'SELECT * FROM email','rendez'=>'DESC','rendezmezo'=>'id',
 
    		'TRT'=>['DataListaSQLplusz'=>'\trt\taskbase\Data',
    		'View'=>'\trt\taskbase\View_byinit',
    		'SzuroMezok'=>'\app\admin\email\SzuroMezok'],
       'paramT'=>
        [
          'Iconsor'=>['iconsorT'=>['del'=>['type'=>'task_del']]],
          'Content'=>
            [
             'namespace'=>'Tabla',
            'tabla'=>'email',
              'dataszerkT'=>
                  [
                   'chk'=>['nocim'=>true,'func'=>'checkbox_mezo'],
                   'eye'=>['nocim'=>true,'funcSTR'=>'$this->eyeLink(\'index.php?app=admin|email&task=emailview&id=\'.$this->rekord[\'id\'].\'\')'],
                  // 'id'=>['width'=>'70px'],
                  'id'=>['width'=>'60px','br'=>true],
                   'cim'=>['szures'=>'input','funcSTR'=>'$this->eyeLinkPlusz(\'index.php?app=admin|email&task=reslista&id=\'.$this->rekord[\'id\'].\'\')'], //a sorcím és arendező nyilak külön sorba
                   'subject'=>['szures'=>'input'],
                   
				   //'body'=>['maxchar'=>25,'szures'=>'input'], 
                  	'total'=>['br'=>true],
                   'sended'=>['br'=>true],
                  	'csoport'=>['br'=>true,'szures'=>'select'],//szűrés lehe input is
                   'datum'=>['br'=>true,'maxchar'=>10,'width'=>'160px']
                  ]
            ]
        ]  
    ],
'new'=>['TRT'=>['View'=>'\trt\taskbase\View_byinit'],
        'paramT'=> ['Content'=> [//'viewF'=>'app\admin\club\view\club_form.html',
            'iniviewF'=>'club_form.html','view_iniclass'=>'app\admin\club\view\ClubIni']]],
'emailview'=>['TRT'=>['Data'=>'trt\taskbase\Data','View'=>'\trt\taskbase\View',
		'Emailview'=>'\app\admin\email\Emailview'],
		'viewF'=>'MOtto\app\admin\email\view\emailview.html',
		'SQL'=>'SELECT * FROM email WHERE id=\'".$_GET[\'id\']."\''],  
		
'del'=>['TRT'=>['Del'=>'\app\admin\email\Del'],'next'=>'alap'],
        
'email'=>['TRT'=>['View'=>'\trt\taskbase\View_byinit','Email'=>'\app\admin\club\Email'],
    'paramT'=>
        [
           // 'Iconsor'=>['iconsorT'=>['email']],
            'Content'=>
            [
               'viewF'=>'app\admin\club\view\email_form.html',
               //'view_iniclass'=>'ViewInit'
            ]
        ]],
    
'mailkuld'=>['TRT'=>['Mailkuld'=>'\trt\task\Mailkuld'],'next'=>'alap'],
];

} 
trait Emailview{

	public function Emailview(){
	if($this->ADT['dataT']['total']>$this->ADT['dataT']['sended'])
		{
			$this->ADT['dataT']['gomb']='<span onclick="csoportoskuld();" class="btn btn-primary btn-xn">Folytat</span>';
		}
		
	}
}
trait Del{

    static public function Del()
    {
		$id_tomb=$_POST['idT'];
        foreach($id_tomb as $id)
		{
		$sql="DELETE FROM email WHERE id = '".$id."'";
        $sth =\lib\db\DBA::parancs($sql);
		$sql="DELETE FROM eposted WHERE emailid = '".$id."'";
        $sth =\lib\db\DBA::parancs($sql);
		
        return $sth;	
		}
    }
	
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
		$kijelol='  <label>Kijelölés: </label><input type="radio" class="kijelol" name="kijelol" value="all"> Mind	
  					<input type="radio" class="kijelol" name="kijelol" value="visible"> Láthatóak	
  					<input type="radio" class="kijelol" name="kijelol" value="nincs"> Eggyiksem	';
		$limit='<label>Megjelnített sorok:</label>
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
	//	$this->ADT['view']= str_replace('<!--kijelol-->', $kijelol,$this->ADT['view'] );
		$this->ADT['view']= str_replace('<!--frissit-->', $frissit,$this->ADT['view'] );
		///$this->ADT['view']= str_replace('<!--csoport-->',$this->CsoportSelect(),$this->ADT['view'] );
		
	}
}

trait Email{

    public   $setfom= '';
    public   $fromnev='';
    public   $cim= '';
    public   $cimzett='';
    public   $subject='';
    public   $body= '';
    public   $emailszam= '';

    public function Emailbeir(){
        $res=$this->emailszam.'/0';
        $sql="insert into email (userid,setfrom,fromnev,cim,cimzett,subject,body,res)values ('".$_SESSION['userid']."','".$this->setfom."','". $this->fromnev."','".$this->cim."','".$this->cimzett."','".$this->subject."','".$this->body."','".$res."') ";
        $emailT= \lib\db\DBA:: beszur($sql);
        // $this->ADT['view']= json_encode($emailT);
        //  $this->ADT['view']= "{'emailid': '15'}";
        return $emailT['id'] ;
    }
    public function Emailkuld(){
        $res='';
        // $code=\lib\str\STR::randomSTR(10);
        // $userT=\lib\db\DB::assoc_sor('SELECT id,name,email FROM userek WHERE id=\''.$_SESSION['userid'].'\'');
        $this->setfom=\CONF::$mailfrom;
        $this->fromnev='Admin';
        $this->body=\lib\ell\Get_S::Text('body',2,1000);
        $this->emailszam=$_POST['emailszam'];
        $this->cim=\CONF::$mailfrom;
        $this->cimzett=implode(',', $_POST['idT']);
        $this->subject=\lib\ell\Get_S::Text('subject',2,50);
      

        if($res==''){
            $id= $this->Emailbeir();
            if($id!=0){header("Location: http://email.helyiakciok.hu/index.php?emailid=".$id);}
            else{$this->ADT['view']= 'Adatbázis hiba';}
        }
    }
    public function Email(){
       $dataS['emailszam']=count($_POST['idT']);
       $dataS['cim']=implode(',', $_POST['idT']);
       $this->ADT['view']=\lib\html\dom\Dom_s::ChangeData($this->ADT['view'], $dataS);
        
    }
}
    