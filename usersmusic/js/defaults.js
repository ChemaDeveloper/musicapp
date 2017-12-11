var urlBase = "http://localhost:8888/Chema/musicapp/fuelphp-1.8/public/base/";
var urlLists = "http://localhost:8888/Chema/musicapp/fuelphp-1.8/public/lists/";
var urlUsers = "http://localhost:8888/Chema/musicapp/fuelphp-1.8/public/users/";
var urlVista = "http://localhost:8888/Chema/musicapp/usersmusic/";
function saveToken(token){
	sessionStorage.setItem("token", token);
}
function saveID(id){
	sessionStorage.setItem("id", id);
}
function isLogged(logged){
	sessionStorage.setItem("isLogged", logged);
}