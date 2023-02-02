/* 
 * Serge Pillay<serge.pillay@orange.fr>
 */

$(document).ready(function() {
    $("#note_formation").change(function() {
        var note = $("#note_formation").val();
        if (note>=70) {
            $("#resultat_formation").text("Reçu");
        } else {
            $("#resultat_formation").text("Ajourné");
        }
    });
    
    $('.carousel').carousel();

	$('.userinfo').click(function(){
		var userid = $(this).data('id');
		var url_dest = $(this).data('route');
		var new_title = $(this).data('title');
		// AJAX request
		$.ajax({
		 	url: url_dest,
		 	type: 'post',
		 	data: {userid: userid},
		 	success: function(response){ 
		   		// Add response in Modal body
		   		$('.modal-body').html(response);
				$('.modal-title').html(new_title);   
				// Display Modal
				$('#empModal').modal('show');
		 	},
			error: function(){
				$('.modal-body').html("Une erreur est survenue.");
				$('.modal-title').html('Erreur');
				// Display Modal
				$('#empModal').modal('show');
			}
	   });
	});
	
});



/*
$('#FormModal').submit(function(event){
    // cancels the form submission
    event.preventDefault();
    submitForm();
});


$('#form-submit').click(function(){
	// cancels the form submission
    event.preventDefault();
    submitForm();
});

function submitForm(){
    // Initiate Variables With Form Content
    var _data = 'TEST=test&' + $('#FormModal').serialize();
	console.log(_data);
	alert(_data);
    var email = $("#email").val();
    var message = $("#message").val();
	
    $.ajax({
		type: "POST",
		url: "{{ path('addTag') }}",
		data: _data,
        type: "POST",
        url: "php/form-process.php",
        data: "name=" + name + "&email=" + email + "&message=" + message,
        success : function(text){
            if (text == "success"){
                formSuccess();
            }
        }
    });
}
function formSuccess(){
    $( "#msgSubmit" ).removeClass( "hidden" );
}
*/

// Example starter JavaScript for disabling form submissions if there are invalid fields
/*
$(function () {
	'use strict';
	window.addEventListener('load', function () {
	  // Fetch all the forms we want to apply custom Bootstrap validation styles to
	  var forms = document.getElementsByClassName('needs-validation');
	  // Loop over them and prevent submission
	  var validation = Array.prototype.filter.call(forms, function (form) {
		form.addEventListener('submit', function (event) {
		  if (form.checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
		  }
		  form.classList.add('was-validated');
		}, false);
	  });
	}, false);
}());
*/
function getthedate(dest){
	var mydate=new Date();
	var hours=mydate.getHours();
	var minutes=mydate.getMinutes();
	var seconds=mydate.getSeconds();
	if (minutes<=9)
	minutes="0"+minutes;
	if (seconds<=9)
	seconds="0"+seconds;
	var cdate=hours+":"+minutes+":"+seconds;
	document.getElementById(dest).value = cdate;
}

/*
 * Fonctions pour le chronomètre
 */
function chrono(){
	end = new Date()
	diff = end - start
	diff = new Date(diff)
	var msec = diff.getMilliseconds()
	var sec = diff.getSeconds()
	var min = diff.getMinutes()
	var hr = diff.getHours()-1
	if (min < 10){
		min = "0" + min
	}
	if (sec < 10){
		sec = "0" + sec
	}
	if(msec < 10){
		msec = "00" +msec
	}
	else if(msec < 100){
		msec = "0" +msec
	}
	document.getElementById("chronotime").value = hr + ":" + min + ":" + sec + ":" + msec
	timerID = setTimeout("chrono()", 10)
}
function chronoStart(){
    getthedate('h_debut');
	document.chronoForm.startstop.value = "stop!"
    document.chronoForm.startstop.class = "btn btn-danger"
	document.chronoForm.startstop.onclick = chronoStop
	document.chronoForm.reset.onclick = chronoReset
	start = new Date()
	chrono()
}
function chronoContinue(){
	document.chronoForm.startstop.value = "stop!"
	document.chronoForm.startstop.onclick = chronoStop
	document.chronoForm.reset.onclick = chronoReset
	start = new Date()-diff
	start = new Date(start)
	chrono()
}
function chronoReset(){
    
	document.getElementById("chronotime").value = "0:00:00:000"
	start = new Date()
}
function chronoStopReset(){
    document.getElementById("h_debut").value = ""
    document.getElementById("h_fin").value = ""
	document.getElementById("chronotime").value = "0:00:00:000"
	document.chronoForm.startstop.onclick = chronoStart
}
function chronoStop(){
    getthedate('h_fin');
	document.chronoForm.startstop.value = "start!"
    document.chronoForm.startstop.class="btn btn-info"
	document.chronoForm.startstop.onclick = chronoContinue
	document.chronoForm.reset.onclick = chronoStopReset
	clearTimeout(timerID)
}  

