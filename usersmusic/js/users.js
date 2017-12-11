function getUsers(){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlUsers+"users.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Autorization", token);
	ajax_request.send();

	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetUser = JSON.parse( ajax_request.responseText );
			for (var i = jsonObjetUser.name.length - 1; i >= 0; i--) {
				$(document.getElementById('usersList')).append("<li class='list-group-item text-center'>"+jsonObjetUser.name[i]+
				"<button id='delete' onclick='deleteUser("+jsonObjetUser.id[i]+")' class='btn btn-primary col-md-offset-3'>Remove user</button><button id='navigateUpdate' onclick='navigateToUpdate("+jsonObjetUser.id[i]+")' class='btn btn-primary col-md-offset-3'>Update user</button></li>");
			}
		}
	}
}
function deleteUser(idUser){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlUsers+"delete.json";
	var params = "id="+idUser;
	var ajax_request = new XMLHttpRequest();
	ajax_request.open("POST", ajax_url, true);
	ajax_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax_request.setRequestHeader("Autorization", token);
	ajax_request.send(params);

	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetResponse = JSON.parse( ajax_request.responseText );
			if(jsonObjetResponse.code == 200){
				window.alert(jsonObjetResponse.name+" borrado");
				location.reload();
			}
		}
	}
}
function loginUser(){
	var name = document.getElementById('nameLogin');
	var password = document.getElementById('passwordLogin');
	var ajax_url = urlUsers+"login.json";
	var params = "name="+name.value+"&password="+password.value;
	ajax_url += '?' + params;
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.send();

	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetUser = JSON.parse( ajax_request.responseText );
			if(jsonObjetUser.code == 200){
				saveToken(jsonObjetUser.token);
				isLogged(true);
				location.replace(urlVista+"userlist.php");
			}else{
				window.alert(jsonObjetUser.code+": "+jsonObjetUser.message);
			}
		}
	}
}
function createUser(){
	var name = document.getElementById('nameRegister');
	var password = document.getElementById('passwordRegister');
	var role = $('#adminRegister').is(":checked");
	if(name.value != ""){
		var ajax_url = urlUsers+"create.json";
		var params = "name="+name.value+"&password="+password.value+"&role="+role;
		var ajax_request = new XMLHttpRequest();
		ajax_request.open("POST", ajax_url, true);
		ajax_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax_request.send(params);

		ajax_request.onreadystatechange = function() {
			if (ajax_request.readyState == 4 ) {
				var jsonObjetUser = JSON.parse( ajax_request.responseText );
				window.alert( jsonObjetUser.code+": "+jsonObjetUser.message);
			}
		}
	}else{
		window.alert("Debes poner un nombre");
	}
}
function updateUser(){
	var name = document.getElementById('nameUpdate');
	var password = document.getElementById('passwordUpdate');
	var id = sessionStorage.getItem("id");
	var token = sessionStorage.getItem("token");
	var ajax_url = urlUsers+"update.json";
	var params = "id="+id+"&name="+name.value+"&password="+password.value;
	var ajax_request = new XMLHttpRequest();
	ajax_request.open("POST", ajax_url, true);
	ajax_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax_request.setRequestHeader("Autorization", token);
	ajax_request.send(params);

	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetUser = JSON.parse( ajax_request.responseText );
			if(jsonObjetUser.token != null){
				saveToken(jsonObjetUser.token);
			}
			window.alert(jsonObjetUser.message);
			location.replace(urlVista+"userlist.php");
		}
	}

}

function getUserData(){
	var name = document.getElementById('nameUpdate');
	var password = document.getElementById('passwordUpdate');
	var id = sessionStorage.getItem("id");
	var token = sessionStorage.getItem("token");
	var ajax_url = urlUsers+"user_data.json";
	var params = "id="+id;
	ajax_url += '?' + params;
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Autorization", token);
	ajax_request.send();

	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetUser = JSON.parse( ajax_request.responseText );
			name.value = jsonObjetUser.name;
			password.value = jsonObjetUser.password;
		}
	}
}
