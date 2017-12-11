<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>App de música</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="js/users.js"></script>
    <script type="text/javascript" src="js/navigation.js"></script>
    <script type="text/javascript" src="js/defaults.js"></script>
    <script type="text/javascript">checkAlowedNavigation();</script>

  </head>
  <body onload="getUsers()">
 	<div class="container">
  		<div><h1>Usuarios</h1></div>
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Usuarios en la página</h3>
                </div>
                <ul id="usersList" class="list-group">
                </ul>
            </div>
        </div>
  		<div class="row">
  			<div class="col-md-8 col-md-offset-2">
  				<div class="form-group">
				  <label class="col-md-6 control-label" for=""></label>
				  <div class="col-md-6">
				    <a id="logout" href="javascript:logout()" type="submit" class="btn btn-primary">Logout</a>
				  </div>
				</div>	
  			</div>
  		</div>
  	</div>
    <div class="container">
      <div><h1>Listas</h1></div>
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Listas</h3>
                </div>
                <span class="group-btn col-md-offset-4">     
                    <a href="javascript:navigateToNewList()" class="btn btn-primary btn-md">Añadir lista</a>
                    <a href="javascript:navigateToPrivateLists()" class="btn btn-primary btn-md">Ver mis listas</a>
                </span>
            </div>
        </div>
      </div>
  	    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>