var feltoltve=0; 
var feltolteni=0;
function inputba_ir(filenev) {
   $('#kep').val(filenev);
   var imagehtml=beszur(); 
   $.ajax({
  method: "POST",
  url: "index.php?app=media&task=kepkuld",
  data: { kep:imagehtml }
})
}

function setup_reader(file,i) {
    var name = file.name;
    var reader = new FileReader();  
    reader.onload = function(e) {  
     $('#upalap'+i).find('.upikon').attr('src', e.target.result);
    }
 reader.readAsDataURL(file);
}
function beszur(){
var file=$('#kep').val();
var wd=$('#wd').val();
var hg=$('#hg').val();
var flo='float="left"';
if($('#flo').val()=='imgright'){flo='float="right"'};
var html='<img src="'+file+'" width="'+wd+'" height="'+hg+'" '+flo+' class="editimg ">';
        //parent.kepbeszur(html);
        return html;
}

function fileSelected(){
$('#upcontener').html('');
 var len = document.getElementById("fileToUpload").files.length;
 feltolteni=len;
    for (var i = 0, len = document.getElementById("fileToUpload").files.length; i < len; i++) 
    {    
    var ikon = $('#upalap').clone().attr('id', 'upalap'+i);
        $(ikon).find('.pr').attr('id', 'pr'+i);
        $(ikon).appendTo('#upcontener');  
         setup_reader(document.getElementById("fileToUpload").files[i],i)  ;
    }
}

//feltöltéshez kell
function obi(i){
var fd = new FormData();
		fd.append("fileToUpload", document.getElementById('fileToUpload').files[i]);
		 var xhr = new XMLHttpRequest();
		 xhr.upload.addEventListener("progress", uploadProgress, false);
		 xhr.addEventListener("load", uploadComplete, false);
		 xhr.open("POST", "http://localhost/soc_proba/mod/media/upload.php");
		 xhr.send(fd);	
		 
function uploadProgress(evt) {
 /* A fájlművelet aktuális százalékértékének kiszámítása */

 if (evt.lengthComputable) {
 var percentComplete = Math.round(evt.loaded * 100 / evt.total);
  $('#pr'+i).attr('value',percentComplete);
 }
 }		 
function uploadComplete(evt) {
feltoltve++;
  $('#upalap'+i).remove();
if(feltoltve==feltolteni){location.reload(); }
 }	

}
//-----------------------------------


function feltolt() {
var fileInput = document.getElementById("fileToUpload"); 
if (fileInput.multiple == true) {

    for (var i = 0, len = fileInput.files.length; i < len; i++) {
      var  dd= new obi(i);
    }
	
// only one file available
} else {
    var file = fileInput.files.item(0);
}}
 function uploadProgress(evt,i) {
 /* A fájlművelet aktuális százalékértékének kiszámítása */
 if (evt.lengthComputable) {
 var percentComplete = Math.round(evt.loaded * 100 / evt.total);
 document.getElementById('fileType').innerHTML = percentComplete.toString() + '%';
  $('#pr'+i).attr('value',percentComplete);
 }
 else {
 document.getElementById('fileType').innerHTML = 'nem kiszámithato';
 }
 }
 