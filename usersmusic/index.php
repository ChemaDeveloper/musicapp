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
    <link href="css/customcss.css" rel="stylesheet">
    <script type="text/javascript" src="js/users.js"></script>
    <script type="text/javascript" src="js/navigation.js"></script>
    <script type="text/javascript" src="js/defaults.js"></script>
  </head>
  <body>
  	

    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-3">
                <div class="form-login">
                <h4>Register</h4>
                <input type="text" id="nameRegister" class="form-control input-sm chat-input" placeholder="username" />
                </br>
                <input type="text" id="passwordRegister" class="form-control input-sm chat-input" placeholder="password" />
                </br>
                <div class="wrapper">
                <span class="group-btn">     
                    <a href="javascript:createUser()" class="btn btn-primary btn-md">Register</a>
                    <label class="btn btn-primary">
                        <input type="checkbox" id="adminRegister"> Admin
                    </label>
                </span>
                </div>
                </div>
            
            </div>

            <div class="col-md-3">
                <div class="form-login">
                <h4>LogIn</h4>
                <input type="text" id="nameLogin" class="form-control input-sm chat-input" placeholder="username" />
                </br>
                <input type="text" id="passwordLogin" class="form-control input-sm chat-input" placeholder="password" />
                </br>
                <div class="wrapper">
                <span class="group-btn">     
                    <a href="javascript:loginUser()" class="btn btn-primary btn-md">LogIn</a>
                </span>
                </div>
                </div>
            
            </div>
        </div>
    </div>
  	    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>