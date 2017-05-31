<?php
namespace lib\html;

defined( '_MOTTO' ) or die( 'Restricted access' );




class Frame extends OB_Mo{
	
	public $fileT=['app/tmpl/base.html','app/base/tmpl/base.html'];
				   	
public function handi($parT=[]){
	
	foreach ($this->fileT as $file)
	{	
		$htmlfile='';
		if(is_file($file)){$htmlfile=	$file;	}
	}
 return $htmlfile;
}
public function res($parT=[]){
		return file_get_contents($this->handi(), true);
	}

}	
class Frame_html extends Frame{
	public $filenev='base.html';
  function __construct($parT=[])
    {
        $this->initMo($parT);
        $this->fileT=['app/'.\GOB::$app.'/tmpl/'.$this->filenev,
        		'tmpl/'.\GOB::$basetmpl.'/'.$this->filenev,
        		'tmpl/'.\GOB::$tmpl.'/'.$this->filenev];

    }

	public function res($parT=[]){
		if(isset($parT['filenev'])){$this->filenev=$parT['filenev'];}
		
		return file_get_contents($this->handi(), true);
	}

}

class Frame_mod extends Frame_html{
	
	public $modnev='';
	
 	public function res($parT=[]){
 		
 	if(isset($parT['filenev'])){$this->filenev=$parT['filenev'];}
	if(isset($parT['modnev'])){$this->modnev=$parT['modnev'];}
 	$this->fileT=['app/'.\GOB::$app.'/tmpl/base.html',
 				'tmpl/'.\GOB::$basetmpl.'/base.html',
 				'tmpl/'.\GOB::$tmpl.'/'.$this->modnev.'/'.$this->filenev];
 		return file_get_contents($this->handi(), true);
 	}	
			
}