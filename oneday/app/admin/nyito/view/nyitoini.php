<?php
namespace app\admin\nyito\view;

class NyitoIni
{
static public  function Res($html) {
\GOB::$paramT['html']['head']['jsfile'][]= 'vendor/MenkuOtto/MOtto/vendor/ckeditor/ckeditor.js';  
//\GOB::$paramT['html']['head']['cssfile'][]= 'vendor/MenkuOtto/MOtto/vendor/ckeditor/samples.css'; // a modalt eltolja    
\GOB::$paramT['html']['bodyhead']['jsfile'][]= 'vendor/MenkuOtto/MOtto/vendor/ckeditor/sample.js'; 


//<link rel="stylesheet" href="css/samples.css">
//<script src="../ckeditor.js"></script>
//<script src="js/sample.js"></script>

       
        $html=\PATH::$rootDir.DS.'app'.DS.'admin'.DS.'nyito'.DS.'view'.DS.$html;

        return file_get_contents($html,true);
    }

}

