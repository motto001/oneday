<?php
namespace app\icon;
//defined( '_MOTTO' ) or die( 'Restricted access' );
class Icon_ADT
{
    public static $ADT=[
        'task'=>'none',
        'size'=>'20',
        'view'=>'',
        'iconview'=>'',
        'label'=>'',
        
        'modalDIV'=>'#myModal',
       // 'TRTtmplCH'=>[], //!!!nem kell! tmpl init filet kell csinálni ami felülírja tmpl ellenőrzi hogy a tmpl\tnamespace\Class létezik-e,ha igen azt tölti be
        'TRT'=>[ 'Icon'=>'\app\icon\trt\Icon'],
        'iconDir'=>'MOtto'.DS.'res'.DS.'ico'.DS.'32'.DS, //kell a végére: /
       
        'simpleType'=>'image', //lehet:image,glyph
        'labelType'=>'none',
        'clickType'=>'simple',
        'simpleClass'=>'moiconimage',
        'simpleTypeT'=>[
                       'none'=>'',
                       'glyph'=>'<span  style="font-size: \'.$this->ADT[\'size\'].\'px; margin-bottom:4px;"
        		                  class="\'.$this->ADT[\'simpleClass\'].\' glyphicon glyphicon-\'.$this->ADT[\'iconT\'][$this->ADT[\'task\']][\'glyph\'].\'"></span>',
                       'image'=>'<img style="padding-bottom:4px;" class="\'.$this->ADT[\'simpleClass\'].\'" width="\'.$this->ADT[\'size\'].\'px" height="\'.$this->ADT[\'size\'].\'"
                                  src="\'.$this->ADT[\'iconDir\'].$this->ADT[\'iconT\'][$this->ADT[\'task\']][\'image\'].\'"/>'],
        
        'labelTypeT'=>['none'=>'','simple'=>'<div class="moiconlabel">\'.$this->ADT[\'label\'].\'</div>'],       //lehet
        //tömbök---------------------------------------
        'clickTypeClass'=>'btn btn-primary',
        'clickTypeT'=>[
                        'task'=>'<button class="\'.$this->ADT[\'clickTypeClass\'].\'"  type="submit" name="task"
                                 value="\'.$this->ADT[\'task\'].\'">\'.$this->ADT[\'iconview\'].\'</br>\'.$this->ADT[\'label\'].\'</button>',
                        'link'=>'<a class="\'.$this->ADT[\'clickTypeClass\'].\'" href="\'.$this->ADT[\'link\'].\'" >\'.$this->ADT[\'iconview\'].\'</br>\'.$this->ADT[\'label\'].\'</a>',
                        'link_change'=>'<a class="\'.$this->ADT[\'clickTypeClass\'].\'" href="#" >\'.$this->ADT[\'iconview\'].\'</br>\'.$this->ADT[\'label\'].\'</a>',
            
                         'modal'=>'<a class="\'.$this->ADT[\'clickTypeClass\'].\'" href="\'.$this->ADT[\'link\'].\'" data-remote="false"
                                   data-tg="tooltip" data-toggle="modal" data-target="#myModal"
                                   title="title" >\'.$this->ADT[\'iconview\'].\'</br>\'.$this->ADT[\'label\'].\'</a>',
                         'modal_link_change'=>'<a class="\'.$this->ADT[\'clickTypeClass\'].\'" href="#" data-remote="false"
                                   data-tg="tooltip" data-toggle="modal" data-target="#myModal"
                                   title="title" >\'.$this->ADT[\'iconview\'].\'</br>\'.$this->ADT[\'label\'].\'</a>',
            
                     ],
       
        'iconT'=>[
            'cancel'=>['image'=>'options.png','glyph'=>'option'],
            'sorment'=>['image'=>'save.png','glyph'=>'save'],
            'save'=>['image'=>'save.png','glyph'=>'save'],
            'sorrend'=>['image'=>'multi_plusz.png','glyph'=>'none'],
            'eye'=>['image'=>'eye.png','glyph'=>'eye-open'],
            'none'=>['image'=>'noikon.png','glyph'=>'none'],
            'up'=>['image'=>'up.png','glyph'=>'chevron-up','bgcolor'=>'blue'],
            'down'=>['image'=>'down.png','glyph'=>'chevron-down','bgcolor'=>'blue'],
            'pub'=>['image'=>'published.png','glyph'=>'ok-circle','color'=>'green'],
            'unpub'=>['image'=>'unpublished.png','glyph'=>'ban-circle','color'=>'red'],
            'edit'=>['image'=>'edit.png','glyph'=>'edit'],
            'new'=>['image'=>'plusz.png','glyph'=>'plus'],
            'form'=>['image'=>'plusz.png','glyph'=>'plus'],
            'del'=>['image'=>'torol.png','glyph'=>'trash'],
            'email'=>['image'=>'email.png','glyph'=>'envelope']
            //''=>['image'=>'','glyph'=>''],
        ],
        'typeT'=>[
            'tab_simple'=>['labelType'=>'none','clickType'=>'none'],
            'tab_link'=>['labelType'=>'none','clickType'=>'link'],
            'tab_link_change'=>['labelType'=>'none','clickType'=>'link_change'],
            'tab_modal'=>['labelType'=>'none','clickType'=>'modal'],
            'tab_modal_link_change'=>['labelType'=>'none','clickType'=>'modal_link_change'],
            'task'=>['labelType'=>'simple','clickType'=>'task','size'=>'32'],
            
            'task_del'=>['labelType'=>'simple','clickType'=>'task','size'=>'32','clickTypeClass'=>'btn btn-primary confirmdelete',],
            'task_info'=>[],
            'task_link'=>['labelType'=>'simple','clickType'=>'link','size'=>'32'],
            'task_modal'=>['labelType'=>'simple','clickType'=>'modal','size'=>'32']
             
        ]
    ];
    public static function initADT(){
    
        self::$ADT['iconDir']=\lib\base\File::pathD(self::$ADT['iconDir']);
 
    } 
    
}
    class Icon_S
    {
        public  static function simple($task,$type,$link='',$parT=[])
        {
            $parT=array_merge(\app\icon\Icon_ADT::$ADT['typeT'][$type],$parT) ;
            $parT['task']=$task;if($link!=''){$parT['link']=$link;}
            $iconDir=\app\icon\Icon_ADT::$ADT['iconDir'];
            $parT['iconDir']=\lib\base\File::pathD($iconDir);
            return \App_s::Res('icon',$parT);
        
        }
        
        public  static function Res($parT=[])
        {
            return \App_s::Res('icon',$parT); 
        }
    }

 
    






