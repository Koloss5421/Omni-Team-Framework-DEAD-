<!doctype html>
<html>
<!-- Pull Style Sheets -->
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/monthly.css">
<link rel="stylesheet" type="text/css" href="css/custom.css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">


<script src="js/bootstrap.js"></script>
<script src="js/npm.js"></script>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
<title>Team Exile | Schedule</title>
</head>
<body>
<!-- NAVBAR START -->
<div class="container-fluid">
	<div class="row">
    	<nav class="navbar navbar-default navbar-static-top">
        	<div class="container">
            	<div class="navbar-header">
                	<a class="navbar-brand" href="index.php">
                    	<img alt="logo" src="img/logo.png" height="30px">
                    </a>
                    <h3 class="navbar-text">Team Exile | Schedule</h3>
                </div>
                <ul class="nav navbar-nav navbar-fltRight">
                <li><a href="login.php"><span class="glyphicon glyphicon-cog"></span> Sign In?</a></li>
            </ul>
            </div>
        </nav>
    </div>
</div>
<!-- NAVBAR END -->
<div class="container-fluid" style="margin-top: 30px;">
    <div class="row">
    	<div class="col-lg-2">
        </div>
		<div class="col-lg-12">
			<div class="monthly_container centered">
						<div class="monthly table table-striped table-bordered"  id="mycalendar"></div>
			</div>
		</div>
    </div>
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/monthly.js"></script>
<script type="text/javascript">

	$(window).load( function() {

		$('#mycalendar').monthly({
			mode: 'event',
			//jsonUrl: 'admin/schedule/events.json',
			//dataType: 'json'
			xmlUrl: 'admin/schedule/events.xml'
		});

	switch(window.location.protocol) {
	case 'http:':
	case 'https:':
	// running on a server, should be good.
	break;
	resize();
	}

	});
</script>
</body>
</html>