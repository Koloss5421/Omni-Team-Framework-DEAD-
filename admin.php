<?php
session_start();

if(!isset($_SESSION['username']))
	{
		header('location: login.php');
	}
?>
<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, height=device-height initial-scale=1.0">
<meta charset="utf-8">
<title>Team Exile | Admin</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/omniteam.css">
<link rel="stylesheet" type="text/css" href="css/custom.css">
<script src="js/bootstrap.js"></script>
<script src="js/npm.js"></script>
</head>

<body>
<!-- NAVBAR START -->
<div class="container-fluid">
	<div class="row">
    	<nav class="navbar navbar-default navbar-static-top navbar-inverse">
            	<div class="navbar-header">
                	<a class="navbar-brand" href="index.php">
                    	<img alt="logo" src="img/logo.png" height="30px">
                    </a>
                    <h3 class="navbar-text">Team Exile | Admin</h3>
                </div>
                <ul class="nav navbar-nav navbar-fltRight"">
                <li><span class="nav navbar-text"><span style="margin-right: 10px;" class="glyphicon glyphicon-user"></span>Signed in as <?php echo $_SESSION['username'];?> <a href="include/otf_logout.php">[Logout]</a></span></li>
            </ul>

        </nav>
    </div>
	<div class="row">
		<div class="admin-nav">

		
					<ul>
						<li class="nav-divider"><span style="margin-right: 10px" class="glyphicon glyphicon-home"></span>Dashboard</li>
						<div id="Dashboard">
							<li><a href="admin.php?f=schedule&p=view"><span style="margin-right: 10px" class="glyphicon glyphicon-calendar"></span>Schedule</a></li>

							<li><a href="admin.php?f=users&p=view"><span style="margin-right: 10px" class="glyphicon glyphicon-user"></span>Users</a></li>

							<li><a href="admin.php?f=groups&p=view"><span style="margin-right: 10px" class="glyphicon glyphicon-tags"></span>Groups</a></li>
						</div>
						
						<?php if($_SESSION['group_id'] <= "2") { echo '<li class="nav-divider"><span style="margin-right: 10px" class="glyphicon glyphicon-wrench"></span>Utilities</li>';} ?>
						
						<div id="Utilities">
							<?php if($_SESSION['group_id'] <= "2") { echo '<li><a href="admin.php?f=settings&p=massMessage"><span style="margin-right: 10px" class="glyphicon glyphicon-comment"></span>Mass Message</a></li>';} ?>
						</div>
						
						<li class="nav-divider"><span style="margin-right: 10px" class="glyphicon glyphicon-cog"></span>Settings</li>
						<div id="Settings">
							<li><a href="admin.php?f=settings&p=editProfile"><span style="margin-right: 10px" class="glyphicon glyphicon-folder-open"></span>Edit Profile</a></li>
							<?php if($_SESSION['group_id'] == "1") { echo '<li><a href="admin.php?f=settings&p=viewCarriers"><span style="margin-right: 10px" class="glyphicon glyphicon-earphone"></span>View Carriers</a></li>';} ?>
							<?php if($_SESSION['group_id'] == "1") { echo '<li><a href="admin.php?f=settings&p=config"><span style="margin-right: 10px" class="glyphicon glyphicon-cog"></span>Configuration</a></li>';} ?>
						</div>
					</ul>
					
			<div class="side-footer">Omni-Team Framework © 2016</div>
			
					
		</div>
            <div id="content" class="otf-admin-content">
            	<div class="content-area-size">
                <?php
				
					$p = $_GET['p'];
					$dir = $_GET['f'];
					
					$page = "admin/" . $dir . "/". $p . ".php";
					
					
					if(file_exists($page))
					{
						include($page);
					}
					else if(!isset($p) && !isset($dir))
					{
						
					}
					else
					{
						
						echo '<div class="alert alert-danger" role"alert"><strong><span class="glyphicon glyphicon-exclamation-sign"></span> Error:</strong> ' . $page . ' does not exist!</div>';
					}
				
				?>
                </div>
            </div>
        </div>
	</div>
</div>
<!-- NAVBAR END -->
    </div>

    <script src="js/bootstrap.js"></script>
	<script src="js/jquery-3.1.1.js"></script>
	<script src="js/npm.js"></script>
</div>
</body>
</html>