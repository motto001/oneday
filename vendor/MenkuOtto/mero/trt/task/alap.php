<?php
namespace trt\task;
defined( '_MOTTO' ) or die( 'Restricted access' );

trait Alap_SqlPlusz{
public function SqlPlusz($sql='')   
{
    $task=$this->ADT['task'];
    
    $rendezmezo=$_GET['rendez'] ?? '';
    $order=$_GET['order'] ?? 'ASC';
    if($rendezmezo!=''){$rendez=" ORDER BY $rendezmezo $order";}else{$rendez='';}
    $limitstart=$_GET['tab_start'] ?? '0';
    $limit=$this->ADT['paramT']['Pagin']['limit'] ?? '50';
    $limitSTR=" LIMIT $limitstart,$limit";
    if($sql==''){$sql=$this->ADT['TSK'][$task]['sql'];}
   return $sql.$rendez.$limitSTR;
}   
}
trait Alap_lista{

    use \trt\task\View;
    use \trt\task\Alap_SqlPlusz;

    public function Alap()
    {

        $task=$this->ADT['task'];
      
        eval('$sql="'.$this->ADT['TSK'][$task]['sql'].'";');
        $sql=$this->SqlPlusz($sql);
      //  echo $sql;
        $dataT=\lib\db\DB::assoc_tomb_Count($sql);
      //  print_r($dataT);
        $this->ADT['paramT']['Pagin']['recordSum']=$dataT['sum'];
        $lista_view=$this->ADT['listaview'] ?? '';
        
        if(is_file($lista_view)){
            
           $lista_view=file_get_contents($lista_view,true); 
        }
       
        $lista='';
        foreach ($dataT['dataT'] as $datasor)
        {
            $datasor['fajtaid']=$_GET['fajtaid'] ?? '';;
            $datasor['pubikon']=\mod\ikon\Ikon_pub_S::Res($datasor['pub']);
            $datasor['link']='index.php?app=admin&iniF=omni/fajtavar&fajtaid='.$datasor['id'].'&fajta='.$datasor['nev'];
           
          $lista.=\lib\html\dom\Dom_S::ChangeDataPar($lista_view,$datasor) ;
        } 
        
        $this->View();
        $this->ADT['view']=str_replace('<!--|lista|-->',$lista ,$this->ADT['view']);

    }}
trait Alap{
    
use \trt\task\View;
use \trt\task\Alap_SqlPlusz;
   
public function Alap()
{ 

    $task=$this->ADT['task'];
    $sql=$this->SqlPlusz();
    $dataT=\lib\db\DB::assoc_tomb_Count($sql);
    $this->ADT['paramT']['Tabla']['dataT']=$dataT['dataT'];
    $this->ADT['paramT']['Pagin']['recordSum']=$dataT['sum'];
    $tabla=\mod\tabla\Tabla_S::Res( $this->ADT['paramT']['Tabla']);
    $this->View();
    $this->ADT['view']=str_replace('<!--|lista|-->',$tabla ,$this->ADT['view']);
}}