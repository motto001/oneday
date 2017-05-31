<?php
namespace app\admin\trt;
defined( '_MOTTO' ) or die( 'Restricted access' );
//echo 'alap file';
trait Alap_SqlPlusz{
public function SqlPlusz($sql='')   
{
    $task=$this->ADT['task'];
    $taskId=$this->ADT['taskId'] ?? '';
    $rendezmezo=$_GET[$taskId.'rendez'] ?? '';
    $order=$_GET[$taskId.'order'] ?? 'ASC';
    if($rendezmezo!=''){$rendez=" ORDER BY $rendezmezo $order";}else{$rendez='';}
    $pagenum=$_GET[$taskId.'page'] ?? 1;
    $limit=$this->ADT['limit'] ?? 50;
    $limitstart=($pagenum*$limit)-$limit;
    $limitSTR=" LIMIT $limitstart,$limit";
    if($sql==''){$sql=$this->ADT['TSK'][$task]['sql'] ?? '';}
   return $sql.$rendez.$limitSTR;
}   
}
trait Alap_lista{

    use \trt\task\View;
    use \app\admin\trt\Alap_SqlPlusz;

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
     

    }}
trait Alap{
    
///use \trt\task\View;
use \app\admin\trt\Alap_SqlPlusz;
   
public function Alap()
{ 

    $task=$this->ADT['task'];
    $sql=$this->SqlPlusz();
//echo $sql;
    $dataT=\lib\db\DB::assoc_tomb_Count($sql);
    $limit=$this->ADT['limit'] ?? 50;
// print_r($dataT['dataT']) ;  
    $sum=$dataT['sum'] ?? 0;//echo $dataT['sum'].'--'. $limit.ceil($sum/$limit);
    if($sum>0){        
    $this->ADT['paramT']['Content']['dataT']=$dataT['dataT'];
    $this->ADT['paramT']['Pagin']['pages']= ceil($sum/$limit); 
    }

  //  $this->View();
}}