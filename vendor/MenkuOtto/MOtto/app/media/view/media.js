var kepcsereid='kep1';

var medialink='index.php?app=media';
//var beszurkepid='kep1';
/*
function beszur(id) //a html fileban kell létrehozni
{
//alert(kepcsereid)	;
$('#'+kepcsereid).attr('src',id);
$('#'+kepcsereid+'input').val(id);
}*/
function link_betolt(pluszGET='',loadID='modalbase') //
{
	$('#'+loadID).load(medialink+pluszGET);
		
}
function modal_betolt(link,loadID='modalbase') //
{
	$('#'+loadID).load(link);
		
}
function imagechange(kepid,pluszGET='',loadID='modalbase') //
{
	//alert(id)	;
	kepcsereid=kepid;
	
	link_betolt(pluszGET,loadID);
		
}

function dirchange(id) 
{
	//alert(medialink+'&dir='+id);
	  $.get(medialink+'&dir='+id,function(data, status){
		  data_betolt(data)  ;
	  }
	  ) ;
	
}
function up() 
{
	//alert(medialink+'&dir='+id);
	  $.get(medialink+'&vdir=up',function(data, status){
		  data_betolt(data)  ;
	  }
	  ) ;
	
}
function home() 
{
	//alert(medialink+'&dir='+id);
	  $.get(medialink+'&vdir=home',function(data, status){
		  data_betolt(data)  ;
	  }
	  ) ;
	
}
function image_del(id) 
{
	 if(confirm('Az Ok-- gombra kattintva, a kiválasztott elem véglegesen törlődni fog!'))
	 {
		  $.get(medialink+'&task=del&did='+id,function(data, status){
			  data_betolt(data)  ;
		  }) ; 
	 }
	 else{return false; } 
	 
}
function newdir() 
{
	var addir = $("#newdir_input").val();
	  $.get(medialink+'&task=newdir&addir='+addir , function(data, status){
		  data_betolt(data)  ;
	  }
	  ) ;
	
}

function data_betolt(data,loadID='modalbase') 
{
	$('#'+loadID).html(data); 
		
}
function feltolt() 
{
	
//$('#myModal').modal('hide');	
 var form = $('.uploadform')[0];
 //alert(form);
 var formData = new FormData(form);
 $.ajax({ 
	    url : 'index.php?app=media&task=upload',
	    type: "POST",
	    data : formData,
	    contentType: false,
	    cache: false,
	    processData:false,
	    dataType : 'json',
	    xhr: function(){
	        //upload Progress
	        var xhr = $.ajaxSettings.xhr();
	        if (xhr.upload) {
	            xhr.upload.addEventListener('progress', function(event) {
	                var percent = 0;
	                var position = event.loaded || event.position;
	                var total = event.total;
	                if (event.lengthComputable) {
	                    percent = Math.ceil(position / total * 100);
	                }
	                //update progressbar
	                $("#progress-wrp .progress-bar").css("width", + percent +"%");
	                $( "#progress-wrp .status").text(percent +"%");
	            }, true);
	        }
	        return xhr;
	    },
	    succes: function(msg){ 
	    	link_betolt()  ;	 
	      },
	     error: function(){ 
	    	 link_betolt()  ;
	      }
	});

}	





