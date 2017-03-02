<?php
session_start();

if(!isset($_SESSION['username']))
	{
		header('location: ../../login.php');
	}
?>
<?php

	include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");

	$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
 
 $UserID = $_REQUEST['F_UserID'];
 $NewUsername = $_REQUEST['F_Username'];
 $NewPassword = $_REQUEST['F_Password'];
 $NewEmail = $_REQUEST['F_Email'];
 $NewPhoneNum = $_REQUEST['F_PhoneNum'];
 $NewCarrier = $_REQUEST['F_Carrier'];
 
 echo $NewCarrier;
 
 echo $NewPassword . "<br />";

 	if ($conn->connect_error) {
		die("Connection Failed: " . $conn->connect_error);
	}
	 echo "Connected Successfully! <br />";
	 
	if($_POST['addUserFormButton']) {
		echo 'inside adduser IF Statement <br />';
		
		$query = "INSERT INTO users (username, password, email, phone_num, carrier) VALUES ('$NewUsername', '$NewPassword', '$NewEmail', '$NewPhoneNum', '$NewCarrier')";
		
		if ($conn->query($query) === TRUE) {
			echo "New Record Created! <br />";
		}
		else
		{
			echo "ERROR: <br />" . $query . "<br>" . $conn->error;
		}
	
	}
	
	if($_POST['editUserFormButton']) {
		echo 'inside adduser IF Statement <br />';
		
		if($NewPassword == "" || $NewPassword == NULL) {
			$query = "UPDATE users SET username='$NewUsername', email='$NewEmail', phone_num='$NewPhoneNum', carrier='$NewCarrier' WHERE id='$UserID'";
		}
		else
		{
			$query = "UPDATE users SET username='$NewUsername', password='$NewPassword', email='$NewEmail', phone_num='$NewPhoneNum', carrier='$NewCarrier' WHERE id='$UserID'";
		}
		
		
		
		if ($conn->query($query) === TRUE) {
			echo "Record Updated <br />";
		}
		else
		{
			echo "ERROR: <br />" . $query . "<br>" . $conn->error;
		}
	
	}
	$conn->close();
	header ("location: admin.php?f=users&p=view");

	
	

?>