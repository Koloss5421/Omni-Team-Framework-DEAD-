<?php

	include("otf_config.php");
	#pull POST username and password
	#Connect to Database
	$conn=mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	
	$username=$_REQUEST['username'];
	$password=$_REQUEST['password'];
	$remember=$_REQUEST['remember-me'];
	
	#Query Database ( goto users table and check if the username and password are there
	$query="SELECT * FROM users WHERE username='$username' && password='$password'";

	$result=mysqli_query($conn, $query);

	#make sure there is only 1 row with the same username and password
	echo "Running Script...\n";
	if(mysqli_num_rows($result) == 1)
		{
			echo "Found a User\n";
			while($row = mysqli_fetch_assoc($result)) {
				$userID = $row['id'];
				echo "Got User ID\n";
				$username = $row['username'];
			}
			$getGroup = mysqli_query($conn, 'SELECT * FROM usergroups WHERE user_id = ' . $userID);
			
			while ($rs = mysqli_fetch_assoc($getGroup)) {
				echo "Checking users group...";
				if ($rs['group_id'] == "1" || $rs['group_id'] == "2") {
					
					session_start();
					echo "Starting Session...";
					$_SESSION['username']=$username;
					$_SESSION['group_id']=$rs['group_id'];
			
					# The username will last 12 hrs
					$UserTime = time() + 43200;
					# The Remember will last 1 week
					$RememberTime = time() + 604800;
					
					setcookie('remember_user', $username, $UserTime, "/");
					setcookie('remember_check', $remember, $RememberTime, "/");
					
					header('location: ../admin.php?f=schedule&p=view');
					
				}
				else
				{
					
					echo '<script type="text/javascript">';
					echo 'alert("You have not been assigned a login group!");';
					echo 'window.location= "../login.php";';
					echo '</script>';
					
				}
			}
		}
		else
		{
			echo '<script type="text/javascript">';
			echo 'alert("Wrong Username or Password! Please Try Again!");';
			echo 'window.location= "../login.php";';
			echo '</script>';
		}

?>