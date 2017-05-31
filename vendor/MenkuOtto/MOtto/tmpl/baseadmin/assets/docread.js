
	$('.btn').tooltip({ html: true});
	
//tábla funkciók-----------------------------------	

	
//----------------------------------------------------	
	$('body').on('hidden.bs.modal', '.modal', function () {
	    $(this).removeData('bs.modal');
	});
	$("#myModal").on("show.bs.modal", function(e) {
	    var link = $(e.relatedTarget);
	    $(this).find(".modal-body").load(link.attr("href"));
	   
	});	
	
	$(".confirmdelete").click(function(){
	    if(confirm("Az Ok gombra kattintva, a kiválasztott elem véglegesen törlődni fog!")){
	       // $("#delete-button").attr("href", "index.php");
	      
	    }
	    else{
	        return false;
	    }
	});
	var osszesT;
	var osszes;
	var last;
	  $("#cim").on("change paste keyup", function() {
		   //alert($(this).val()); 
		osszesT = $(this).val().split(',');
		last=osszesT[osszesT .length - 1];
		//$("#subject").val(last);
		if(last!=''){
		osszes=osszesT.length;
		$("#osszes").html(osszes) ;
		}
		
		});
	  