<?php
session_start();

if(isset($_SESSION['username']))
	{
		
		header('location: admin.php?f=schedule&p=view');

	}
?>
<!doctype html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/custom.css">
<script src="js/bootstrap.js"></script>
<script src="js/npm.js"></script>

<meta charset="utf-8">
<title>Team Exile | Login</title>
</head>

<body style="background-color: #222;">
<!-- NAVBAR START -->
<div class="container-fluid">
	<div class="row">
    	<nav class="navbar navbar-default navbar-static-top navbar-inverse">
        	<div class="container">
            	<div class="navbar-header">
                	<a class="navbar-brand" href="index.php">
                    	<img alt="logo" src="img/logo.png" height="30px">
                    </a>
                    <h3 class="navbar-text">Team Exile | Login</h3>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- NAVBAR END -->
	<!-- Placeholder column -->
	<div class="col-lg-4">
    </div>
    
    <!-- Login Form column -->
    <div class="col-lg-4 centered well" style="background-color: #333333; color: #FFF;">
    <h3 class="text-center">Admin Login</h3>
    
    <form style="background-color: #555555" class="hoverbox" action="include/otf_auth.php" method="POST">
    	<div class="input-group form-group">
        	<span class="input-group-addon">
    			<span class="glyphicon glyphicon-user"></span>
        	</span>
        <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $_COOKIE['remember_user']; ?>">
        </div>
        <div class="input-group form-group">
        <span class="input-group-addon">
    			<span class="glyphicon glyphicon-lock"></span>
        	</span>
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <div class="input-group form-group">
        	<label for="remember-me" class="checkbox-inline text-right">
        		<input type="checkbox" value="1" name="remember-me" id="remember-me" <?php if(isset($_COOKIE['remember_check'])) {echo 'checked'; }?>> Remember Me?
            </label>
        </div>
        <button type="submit" class="btn btn-success btn-block">Login</button>
    </form>
    
    </div>
</div>
</body>
</html>