window.onload = function(){
	var modal = document.getElementById('myModal');

	var btn = document.getElementById('myBtn');

	var span = document.getElementById('close');
	span.style.cursor = "pointer";

	document.getElementById('myBtn').onclick = function(){
		modal.style.display = "block";
	}

	document.getElementById('close').onclick = function(){
		modal.style.display = "none";
		console.log ("hello");
	}

	window.onclick = function(event) {
		if (event.target == modal){
			modal.style.display = "none";
		}
	}
}
