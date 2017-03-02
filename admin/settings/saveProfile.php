<?php
session_start();

if(!isset($_SESSION['username']))
	{
		header('location: ../../login.php');
	}
?>
<?php

 include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");

 $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBTABLE);
 
 $UserID = $_REQUEST['F_UserID'];
 $NewUsername = $_REQUEST['F_Username'];
 $NewPassword = $_REQUEST['F_Password'];
 $CurrentPassword = $_REQUEST['F_CurPassword'];
 $NewEmail = $_REQUEST['F_Email'];
 $NewPhoneNum = $_REQUEST['F_PhoneNum'];
 $NewCarrier = $_REQUEST['F_Carrier'];
 


 	if ($conn->connect_error) {
		die("Connection Failed: " . $conn->connect_error);
	}
	 
	
	if($_POST['editUserFormButton']) {
		
		$checkPass = mysqli_query($conn, "SELECT * FROM users WHERE id='$UserID'");
		
		if(mysqli_num_rows($checkPass) == 1) {
		
			if($NewPassword == "" || $NewPassword == NULL) {
				$query = "UPDATE users SET username='$NewUsername', email='$NewEmail', phone_num='$NewPhoneNum', carrier='$NewCarrier' WHERE id='$UserID'";
			}
			else
			{
				$query = "UPDATE users SET username='$NewUsername', password='$NewPassword', email='$NewEmail', phone_num='$NewPhoneNum', carrier='$NewCarrier' WHERE id='$UserID'";
			}
			
		}
		else
		{
					echo '<script type="text/javascript">';
					echo 'alert("You have not been assigned a login group!");';
					echo 'window.location= "' . $SERVER[DOCUMENT_ROOT] . '/login.php";';
					echo '</script>';
			
			//header ("location: admin.php?f=settings&p=editProfile");
			
		}
		
		
		
		if ($conn->query($query) === TRUE) {

			
		}
		else
		{
			echo "ERROR: <br />" . $query . "<br>" . $conn->error;
		}
	
	}
	if ($NewUsername != $_SESSION['username']) {
		echo '<script type="text/javascript">';
		echo 'alert("Your Username has been changed! Please Re-Login!");';
		echo 'window.location= "' . $SERVER[DOCUMENT_ROOT] . '/include/otf_logout.php";';
		echo '</script>';
	}
	else {
		header ("location: admin.php?f=settings&p=editProfile");
	}
	$conn->close();
	

	
	

?>