<?php
session_start();

if(!isset($_SESSION['username']))
	{
		header('location: ../../login.php');
	}

 include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");

 $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

 	if ($conn->connect_error) {
		die("Connection Failed: " . $conn->connect_error);
	}
	 echo "Connected Successfully! <br />";


if(!empty($_REQUEST['chk'])) {
		$UserID = array();
		foreach($_REQUEST['chk'] as $check) {
			array_push($UserID ,$check);
			print_r($UserID);
		}
	}
if(isset($UserID)) {
		$monthly = simplexml_load_file('admin/schedule/events.xml');
		foreach ($UserID as $id) {
			
		$query = "DELETE FROM users WHERE id='$id'";
		
		if ($conn->query($query) === TRUE) {
			echo "Record Deleted! <br />";
			$query = "DELETE FROM usergroups WHERE id='$id'";
		}
		else
		{
			echo "ERROR: <br />" . $query . "<br>" . $conn->error;
		}
			
			
			
		}
		
	}

	$conn->close();
	header ("location: admin.php?f=users&p=view");

	
	

?>