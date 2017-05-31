<?php
namespace app\tabla;;
defined( '_MOTTO' ) or die( 'Restricted access' );

class ADT
{
    
static public $ADT=[
    'view'=>'tab',
    'appID'=>'tab',
    'taskID'=>'tab',
    'appIDuniq'=>true,
    'rendez_sor'=>true,
    'fejlec'=>true,
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
    public function eyeLink($evalpar='')
    {
        eval('$link=\''.$evalpar.'\';');
        if(!isset($this->iconT['eye']))
        {
             $this->iconT['eye']=\app\icon\Icon_S::simple('eye', 'modal_link_change');      
        }
       return str_replace('"#"', '"'.$link.'"', $this->iconT['eye']);         
    }
 
    public function listaLink($evalpar='')
    {
        $res=$this->val;
        if($res=='lista'){
            
           $res=$this->eyeLink($evalpar).' Lista';
        }
    return $res;
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
    
    public   function orderikon(){

        $csereTdown=[$this->ADT['taskID'].'_rendez'=>$this->mezo,$this->ADT['taskID'].'order'=>'ASC'];
        $linkdown =\lib\base\LINK::GETcsereT($csereTdown);
         if(!isset($this->iconT['down'])){$this->iconT['down']=\app\icon\Icon_S::simple('down', 'tab_link_change');}
        $iconDown=str_replace('"#"', '"'.$linkdown.'"', $this->iconT['down']); 
        
        $csereTup=[$this->ADT['taskID'].'_rendez'=>$this->mezo,$this->ADT['taskID'].'order'=>'DESC'];
        $linkup =\lib\base\LINK::GETcsereT($csereTup);
          if(!isset($this->iconT['up'])){$this->iconT['up']=\app\icon\Icon_S::simple('up', 'tab_link_change');}
        $iconUp=str_replace('"#"', '"'.$linkup.'"', $this->iconT['up']); 
    
        return $iconUp.$iconDown;;
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
          
			if(isset($mezotomb['func'])) 
			{
			   $evalpar=$mezotomb['paramEV'] ?? [];
			    	       
			        $func=$mezotomb['func'];
			        $this->val=$this->$func($evalpar);   
			}
            else{
              $this->val=substr($this->val, 0,30);
            }    
            $html.=$this->mezo($this->val);
        }
        $html.='</tr>';
        return $html;
    }
    public function fejlec()
    { 

       
        $html='<tr class="trfejlec">';

        foreach($this->ADT['dataszerkT']  as $mezonev => $mezotomb)
        { 
           $onclick='';
           if(isset($mezotomb['nocim'])){ $mezocim=' ';}
           else{
           $mezocim=$mezotomb['cim'] ?? $mezonev;
           $mezocim=\GOB::$LT[$mezonev] ?? $mezocim;
           if(!isset($mezotomb['noorder'])){ $mezonev.=' '.$this->orderikon($mezonev);}  
          
           }

           $html.=$this->mezo($mezocim);
           
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
         
       return \App_s::Res('icon',$parT);
    }  
}

Eszterházy Károly Egyetem, Eger


