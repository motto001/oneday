<?php
namespace app\admin\club;
defined( '_MOTTO' ) or die( 'Restricted access' );
//echo 'club';

class ADT{
static  public $ADT=[
        'jog'=>'admin',
        'tablanev'=>'userek',
        'task'=>'alap',
        'limit'=>70, //hány tétel legyen egy oldalon a listában vagy táblázatban
       // 'view'=>'admin user',
        'viewF'=>'admin.html',
        'view_iniclass'=>'ViewInit', //ha van az aktuális tmpl-ben onnan ha nincs az app könyvtárbol tölti be
        'paramT'=>[],
        'evalSTR'=>'$this->ADT[\'dataT\'][\'id\']=$_POST[\'idT\'][0] ?? 0;$this->ADT[\'id\']=$_POST[\'idT\'][0] ?? 0;$this->ADT[\'id\']=$_POST[\'id\'] ?? 0;'
       
  
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
'jelszo'=>
	[
	'TRT'=>['View'=>'\trt\taskbase\View_byinit'],
	'paramT'=> ['Content'=> ['viewF'=>'ROOT/app/admin/club/view/jelszo_form.html',]]
	],
'jelszoment'=>
    [
'paramT'=> ['Content'=> ['viewF'=>'ROOT/app/admin/club/view/jelszo_form.html']],
	'TRT'=>['View'=>'\trt\taskbase\View_byinit','Jelszoment'=>'\app\admin\club\Jelszoment']
	],
'alap'=>
    [
    'SQL'=>'SELECT * FROM userek','where'=>'id>6','limit'=>'50','rendez'=>'DESC','rendezmezo'=>'id',
    'TRT'=>['DataListaSQLplusz'=>'\trt\taskbase\Data',
    		'View'=>'\trt\taskbase\View_byinit',
    		'SzuroMezok'=>'\app\admin\club\SzuroMezok'],
       'paramT'=>
        [
          'Iconsor'=>['iconsorT'=>['new','edit','pub','unpub','email','del'=>['type'=>'task_del']]],
          'Content'=>
            [
             'namespace'=>'Tabla',
            'tabla'=>'userek',
              'dataszerkT'=>
                  [
                   'chk'=>['nocim'=>true,'func'=>'checkbox_mezo'],
                   'pub'=>['nocim'=>true,'func'=>'pub_mezo'],
                  // 'id'=>['width'=>'70px'],
                  'id'=>['width'=>'60px','br'=>true],
                   'name'=>['br'=>true,'szures'=>'input'], //a sorcím és arendező nyilak külön sorba
                   'email'=>['br'=>true,'szures'=>'input'],
                   'jelszo'=>['br'=>true], 
                  	'csoport'=>['br'=>true,'szures'=>'select'],//szűrés lehe input is
                   'datum'=>['br'=>true],
                   'lejar'=>['br'=>true],
                  ]
            ]
        ]  
    ],
'new'=>['TRT'=>['View'=>'\trt\taskbase\View_byinit'],
        'paramT'=> ['Content'=> [//'viewF'=>'app\admin\club\view\club_form.html',
            'iniviewF'=>'club_form.html','view_iniclass'=>'app\admin\club\view\ClubIni']]],
'edit'=>['TRT'=>['Data'=>'trt\taskbase\Data'],'next'=>'new','SQL'=>'SELECT * FROM userek WHERE id=\'".$_POST[\'idT\'][0]."\''],  
 
'pub'=>['TRT'=>['Pub'=>'trt\task\Pub'],'next'=>'alap'],
'unpub'=>['TRT'=>['unPub'=>'\trt\task\Pub'],'next'=>'alap'],
'del'=>['TRT'=>['Del'=>'\trt\task\Del'],'next'=>'alap'],
    
'savenew'=>['next'=>'save'], //a Save postban érzékeli a savenew-t és a mentés után a new-ra irányít,nem a next-re
   
'save'=>['TRT'=>['SaveUser'=>'\trt\taskbase\Save'],'next'=>'alap','hibatask'=>'edit',
        'mentmezoT'=>['userek'=>['kapcsolomezo'=>'userid', //csak többtáblánál kell
                                 'mezok'=>['name','username','email','password','jelszo','tel','cim','lejar','csoport','pub']]]], 
    
'email'=>['TRT'=>['View'=>'\trt\taskbase\View_byinit','Email'=>'\app\admin\club\Email'],
    'paramT'=>
        [
           // 'Iconsor'=>['iconsorT'=>['email']],
            'Content'=>
            [
               'viewF'=>'ROOT\app\admin\club\view\email_form.html',
               //'view_iniclass'=>'ViewInit'
            ]
        ]],
    
'mailkuld'=>['TRT'=>['Mailkuld'=>'\trt\task\Mailkuld'],'next'=>'alap'],
];

} 
trait Jelszoment{
	
	public function Jelszoment(){
		$oldjelszo=$_POST['oldpassword'] ?? '';
		$jelszo=$_POST['password'] ?? '';
		$jelszo2=$_POST['password2'] ?? '';
		$sql="select password  from userek where id='".$_SESSION['userid']."'";
		$DBpass=\lib\db\DB::assoc_sor($sql)['password'];
		if($DBpass==md5($oldjelszo))
		{
			if($jelszo==$jelszo2){
			
				if(strlen($jelszo)>5){
				
				$sql="update userek set password='".md5($jelszo)."' where id='".$_SESSION['userid']."'";
		$kk=\lib\db\DBA::parancs($sql);	
		$this->ADT['view']=str_ireplace('<!--hiba-->','<center><h2 style="color:red;">A jelszó megváltozott.</h2></center>',$this->ADT['view']);
		
				}
				else{
					$this->ADT['view']=str_ireplace('<!--hiba-->','<center><h2 style="color:red;">A jelszónak minimum 6karakternek kell lennie!</h2></center>',$this->ADT['view']);
				}
			}
			else{
				$this->ADT['view']=str_ireplace('<!--hiba-->','<center><h2 style="color:red;">A két új jelszó nem egyezik!</h2></center>',$this->ADT['view']);
			}
		
		}
		else
		{
			$this->ADT['view']=str_ireplace('<!--hiba-->','<center><h2 style="color:red;">Hibás jelszó!</h2></center>',$this->ADT['view']);
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
		$kijelol='  <label>Kijelölés:
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
		$this->ADT['view']= str_replace('<!--kijelol-->', $kijelol,$this->ADT['view'] );
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
    