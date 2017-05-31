<?php
namespace app\admin\club\view;

class ClubIni
{
static public  function Res($html) {

\GOB::$paramT['html']['bodyhead']['docread'][]= <<<js

    var lejar =$('#lejar').val();   
    var tip =$('input[type=radio][name=dateplusz]').val();
    
	/*
    var yearbase = year+1;
    $('#lejar').val(yearbase+'-'+month+'-'+day) ;
      $('input[type=radio][name=dateplusz]').change(function(e) {
        tip = $("form input[type='radio'][name=dateplusz]:checked").val()  }); 
    */
    
	
    
    $('input[type=radio][name=lejar2]').change(function(e) {
    
    var evszam=parseInt($("form input[type='radio'][name=lejar2]:checked").val());
    var tip = $("form input[type='radio'][name=dateplusz]:checked").val();
    var d = new Date();
	var year = parseInt(d.getFullYear());
	var month = d.getMonth()+1;
	var day = d.getDate();
    
    if(tip =='akt' )
    {   
        if(lejar)
        {
        var year = parseInt(lejar.substring(0, 4));
	    var month =  parseInt(lejar.substring(5, 7));
	    var day =  parseInt(lejar.substring(8, 10));
        }
       
    }
    
    $('#lejar').val(year+evszam+'-'+month+'-'+day) ;   
    
    	
       
    });
js;
       
        $html=\PATH::$rootDir.DS.'app'.DS.'admin'.DS.'club'.DS.'view'.DS.$html;

        return file_get_contents($html,true);
    }

}

