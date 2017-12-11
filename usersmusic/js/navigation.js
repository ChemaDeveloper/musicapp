function checkAlowedNavigation(){
	var isLogged = sessionStorage.getItem("isLogged");
	if(isLogged == "false"){
		location.replace(urlVista+"notauth.html");
	}
}

function logout(){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlBase+"default_auth.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Autorization", token);
	ajax_request.send();
	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetAuth = JSON.parse( ajax_request.responseText );
			if(jsonObjetAuth.code == 200){
				saveToken("");
				isLogged(false);
				location.replace(urlVista+"index.php");
			}else{
				window.alert("Acción no permitida");
			}
		}
	}	
}
function navigateToUsersList(){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlBase+"default_auth.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Autorization", token);
	ajax_request.send();
	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetAuth = JSON.parse( ajax_request.responseText );
			if(jsonObjetAuth.code == 200){
				location.replace(urlVista+"userlist.php");
			}else{
				window.alert("Acción no permitida");
			}
		}
	}
}
function navigateToPrivateLists(){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlBase+"default_auth.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Autorization", token);
	ajax_request.send();
	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetAuth = JSON.parse( ajax_request.responseText );
			if(jsonObjetAuth.code == 200){
				location.replace(urlVista+"musiclists.php");
			}else{
				window.alert("Acción no permitida");
			}
		}
	}
}
function navigateToNewList(){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlBase+"default_auth.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Autorization", token);
	ajax_request.send();
	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetAuth = JSON.parse( ajax_request.responseText );
			if(jsonObjetAuth.code == 200){
				location.replace(urlVista+"newlist.php");
			}else{
				window.alert("Acción no permitida");
			}
		}
	}
}
function navigateToUpdate(id){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlBase+"default_auth.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Autorization", token);
	ajax_request.send();
	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetAuth = JSON.parse( ajax_request.responseText );
			if(jsonObjetAuth.code == 200){
				saveID(id);
				location.replace(urlVista+"updateuser.php");
			}else{
				window.alert("Acción no permitida");
			}
		}
	}
	
}