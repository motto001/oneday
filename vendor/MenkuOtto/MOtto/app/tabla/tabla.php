<?php
namespace app\tabla;
defined( '_MOTTO' ) or die( 'Restricted access' );

class ADT
{
    
static public $ADT=[
    'view'=>'tab',
    'appID'=>'tab',
	//'tabla'=>'userek',	
    'taskID'=>'',
    'appIDuniq'=>true,
    'rendez_sor'=>true,
    'fejlec'=>true,
		'iconDir'=>'MOtto/res/ico/16/',
    'dataT'=>[],
    'dataszerkT'=>[],
    'TRT'=>['Tabla'=>'\app\tabla\Tabla'],
    'paramT'=>['icon'=>['size'=>'12']],
    'css'=>'<style>
    table { 
        background-color:whitesmoke;
        margin-left:5%;
        min-width:70% ;
        color: darkslategray;
    }
    .trfejlec{
        background-color: royalblue;
        color: white; 
    }
    th {
        height: 50px;
    }
    table, th, td { padding: 5px;
        border: 1px solid black;max-width:30%;
    }</style> '
    
];

}

trait Tabla 
{
 public $iconT=[];
 public $mezo='';
 public $val='';
 public $rekord=[];

public function checkbox_mezo()
    {
        return '<input type="checkbox" class="tabcheck" name="idT[]" value="'.$this->rekord['id'].'" />';
    }
    
    /**
 $valpar=link példa:index.php?app=mod&mod=eye&tab=email&id=\'.$this->rekord["id"].\'&key=mailid'
     */
    public function eyeLink($link='')
    {//echo'gg';
        eval('$link=\''.$link.'\';');
   		return'<span onclick="modal_betolt(\''.$link.'\',\'modalbase\');"
    		 data-toggle="modal" data-target="#myModal"><img width="32" height="32" src="MOtto/res/ico/16/eye.png"> </span>';
         
    }
 
    public function eyeLinkPlusz($link='')
    {      
    return '<div style="white-space: nowrap;">'.$this->eyeLink($link).$this->val.'</div>';
    }
    public function pub_mezo()
    {
        
        if($this->val=='0')
        { 
            if(!isset($this->iconT['pub'])){$this->iconT['pub']=\app\icon\Icon_S::simple('pub', 'tab_simple');}
            return $this->iconT['pub'];
        }
        else
        {
            if(!isset($this->iconT['unpub'])){$this->iconT['unpub']=\app\icon\Icon_S::simple('unpub', 'tab_simple');}
            return $this->iconT['unpub'];        
        }
    }
    public function SzuroSelect($szuresmezo){
    	$res='
    	<input type="hidden" name="szuresmezo[]" value="'.$szuresmezo.'" >		
		<select id="'.$szuresmezo.'" name="'.$szuresmezo.'" >
		<option value=""></option>';
    
    	$sql="SELECT id, GROUP_CONCAT( ".$szuresmezo." SEPARATOR ',') as ".$szuresmezo." FROM ".$this->ADT['tabla'];
    //	echo $sql;
    	$smezo=	\lib\db\DB::assoc_sor($sql);
    	$smezo['csoport']=$smezo['csoport'] ?? '';
    	$csoportA=explode(',',$smezo['csoport']);
    	$csoportA=array_unique($csoportA);
    	foreach ($csoportA as  $value) {
    		$res.='<option value="'.$value.'">'.$value.'</option>'	;
    	}
    	$res.='</select>';
    	return  $res;
    }
    public function SzuroInput($szuresmezo){
    	$res='
    	<div style="white-space: nowrap;"><input type="hidden" name="szuresmezo[]" value="'.$szuresmezo.'" >
		<input type="text"style="font-size:14 px; id="'.$szuresmezo.'" name="'.$szuresmezo.'" >
		<span style="font-size:14 px;" class="glyphicon glyphicon-search"></span></div>';
   
    	return  $res;
    }
    
    
    
    public   function orderikon($mezonev){
		$taskid=$this->ADT['taskID'] ?? '';
		if($taskid!=''){$taskid.='_';}
		
        $csereTdown=[$taskid.'rendezmezo'=>$mezonev,$taskid.'rendez'=>'DESC'];
        $linkdown =\lib\base\LINK::GETcsereT($csereTdown);
        $iconDown='<a class="rendezikon" href="'.$linkdown.'"><img src="'.$this->ADT['iconDir'].'up.png"></a>';
        
      //   if(!isset($this->iconT['down'])){$this->iconT['down']=\app\icon\Icon_S::simple('down', 'tab_link_change');}
       // $iconDown=str_replace('"#"', '"'.$linkdown.'"', $this->iconT['down']); 
        
        $csereTup=[$taskid.'rendezmezo'=>$mezonev,$taskid.'rendez'=>'ASC'];
        $linkup =\lib\base\LINK::GETcsereT($csereTup);
         
        $iconUp='<a class="rendezikon" href="'.$linkup.'"><img src="'.$this->ADT['iconDir'].'down.png"></a>'; 
    
        return $iconUp.$iconDown;
    }

    public function mezo($data="")
    {
        $html="<td>". $data."</td>";
        return $html;
    }
/**
lehet több egyforma index is! a cimet határozza meg, nem a mezőnevet.
 ha a mezőnév nem azonos az indexel külön 'mezo' paraméter kell 
 */
    public function sor()
    {
        $html='<tr>';
      //  if($this->ADT['checkbox']){$html.='<td></td>';}
      //  if($this->ADT['pubikon']){$html.='<td></td>';}
        
        foreach($this->ADT['dataszerkT'] as $cim=> $mezotomb)
        {
             
          
            $this->mezo=$mezotomb['mezo'] ?? $cim;
           
            $this->val=$this->rekord[$this->mezo] ?? ' ';
            $maxchar=$mezotomb['maxchar'] ?? 25;
            if($maxchar!='no')
            {
            	$this->val=substr($this->val, 0,$maxchar);
            }
			if(isset($mezotomb['func'])) 
			{
				$funcT=explode(';',$mezotomb['func']);
				foreach ($funcT as $func){
				$this->val=$this->$func();
					
				}
	  
			}
			if(isset($mezotomb['funcSTR']))
			{
				$funcT=explode(';',$mezotomb['funcSTR']);
				foreach ($funcT as $func){
					eval('$this->val='.$func.';');		
				}
				 
			}
            $html.=$this->mezo($this->val);
        }
        $html.='</tr>';
        return $html;
    }
    
    public function szurosor()
    {
    	$html='<tr>';
    
    	foreach($this->ADT['dataszerkT'] as $mezonev=> $mezotomb)
    	{
    		
    		$html.='<td>';
    		$szures=$mezotomb['szures'] ?? '';
    		if($szures=='select'){$szures=$this->SzuroSelect($mezonev);}
    		if($szures=='input'){$szures=$this->SzuroInput($mezonev);}
    		$html.=$szures;
    		$html.='</td>';
    	}
    	$html.='</tr>';
    	return $html;
    }
    
    
    public function fejlec()
    { 

       
        $html='<tr class="trfejlec">';

        foreach($this->ADT['dataszerkT']  as $mezonev => $mezotomb)
        { 
        
           if(isset($mezotomb['nocim'])){ $mezocim=' ';}
           else{
           $mezocim=$mezotomb['cim'] ?? $mezonev;
           $mezocim=\GOB::$LT[$mezocim] ?? $mezocim;
           if(isset($mezotomb['br'])) {$br='</br>';}else{$br='';}
           if(!isset($mezotomb['noorder'])){ $mezocim='<div style="white-space: nowrap;">'.$mezocim.$br.' '
           		.$this->orderikon($mezonev).'</div>' ;}  
          
           }
          if(isset($mezotomb['width'])) {$width=' width="'.$mezotomb['width'].'" ';}else{$width='';}
           $html.='<td '.$width.'>'.$mezocim.'</td>';
           
        }
        $html.="</tr>";
        return $html;
    }

    public function Tabla($parT=[])
    { 
        $this->ADT=array_merge ($this->ADT,$parT);
        if(empty($this->ADT['dataT']))
         {$html='<h3>A táblázat nem tartalmaz adatokat!<h3>';}
         else
         {         
            $html=$this->ADT['css'] ?? '';
            $html.='<table>';
            $html.=$this->szurosor();
            $html.=$this->fejlec();
           // $html.=$this->rendez_sor();
            foreach($this->ADT['dataT'] as $datasor)
            {
                $this->rekord=$datasor;
                $html.=$this->sor();
    
            }
            $html.='</table>';   
        }
       
      $this->ADT['view'] =$html;
    }
}

class Tabla_S
{
    public static function Res($parT=[]){
         
       return \App_s::Res('tabla',$parT);
    }  
}

 

