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

 	if ($conn->connect_error) {
		die("Connection Failed: " . $conn->connect_error);
	}
	 echo "Connected Successfully! <br />";


if(!empty($_REQUEST['chk'])) {
	$GroupID = array();
	
	foreach($_REQUEST['chk'] as $check) {
		
		array_push($GroupID ,$check);
		print_r($GroupID);
		
	}
}
if(isset($GroupID)) {
	
	foreach ($GroupID as $id) {
		
		if ($id === "1" || $id === "2") {
			
			echo '<script type="text/javascript">'; 
			echo 'alert("ERROR: Admin and Coach Groups cannot be deleted!");'; 
			echo 'window.location.href = "admin.php?f=groups&p=view";';
			echo '</script>';
			
		}
		else {
		
			$query = "DELETE FROM groups WHERE group_id='$id'";
			
			if ($conn->query($query) === TRUE) {
				echo "Record Deleted! <br />";
				
				$query = "DELETE FROM usergroups WHERE group_id='$id'";
				
					if ($conn->query($query) === TRUE) {
					echo "Record Deleted! <br />";
					header ("location: admin.php?f=groups&p=view");
				}
			}
			else
			{
				echo "ERROR: <br />" . $query . "<br>" . $conn->error;
			}
				
				
				
		}
	}	
}

$conn->close();
?>