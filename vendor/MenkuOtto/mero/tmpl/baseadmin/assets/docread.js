
	$('.btn').tooltip({ html: true});
	
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
	