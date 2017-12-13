var urlBase = "http://localhost/musicapp/fuelphp-1.8/public/base/";
var urlLists = "http://localhost/musicapp/fuelphp-1.8/public/lists/";
var urlUsers = "http://localhost/musicapp/fuelphp-1.8/public/users/";
var urlVista = "http://localhost/musicapp/usersmusic/";
function saveToken(token){
	sessionStorage.setItem("token", token);
}
function saveID(id){
	sessionStorage.setItem("id", id);
}
function isLogged(logged){
	sessionStorage.setItem("isLogged", logged);
}
