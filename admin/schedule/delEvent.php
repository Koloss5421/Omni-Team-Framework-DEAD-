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
		$EventID = array();
		foreach($_REQUEST['chk'] as $check) {
			array_push($EventID ,$check);
			print_r($EventID);
		}
	}
if(isset($EventID)) {
	
		foreach ($EventID as $id) {
			
		$query = "DELETE FROM events WHERE id='$id'";
		
		if ($conn->query($query) === TRUE) {
			echo "Record Deleted! <br />";
			
			
				if ($conn->query($query) === TRUE) {
				echo "Record Deleted! <br />";
			}
		}
		else
		{
			echo "ERROR: <br />" . $query . "<br>" . $conn->error;
		}
			
			
			
		}
		
	}
	$updateXML = mysqli_query($conn, "SELECT * FROM events");
		
		$writer = new XMLWriter();

		$writer->openUri('admin/schedule/events.xml');
		$writer->startDocument();
		$writer->setIndent(true);
		$writer->startElement('monthly');

		foreach($updateXML as $row)
		{
			$writer->startElement('event');
			$writer->setIndent(true);

			foreach($row as $name => $value) {
				
					$writer->startElement($name);
					$writer->text($value);
					$writer->endElement();
					
			}

			$writer->endElement();
		}
		
		$writer->endElement();

		$writer->endDocument();

	$conn->close();
	header ("location: admin.php?f=schedule&p=view");

	
	

?>