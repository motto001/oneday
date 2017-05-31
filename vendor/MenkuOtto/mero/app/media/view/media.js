var medialink='index.php?app=modal&mod=media';

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
		  $.get(medialink+'&med=del&did='+id,function(data, status){
			  data_betolt(data)  ;
		  }) ; 
	 }
	 else{return false; } 
	 
}
function newdir() 
{
	var addir = $("#newdir_input").val();
	  $.get(medialink+'&med=newdir&addir='+addir , function(data, status){
		  data_betolt(data)  ;
	  }
	  ) ;
	
}
function link_betolt(pluszGET='',loadID='modalbase') 
{
	//alert(medialink+pluszGET);
	$('#'+loadID).load(medialink+pluszGET); 
		
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
	    url : 'index.php?app=modal&mod=media&med=upload',
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