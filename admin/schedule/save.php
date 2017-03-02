<?php
session_start();

if(!isset($_SESSION['username']))
	{
		header('location: ../../login.php');
	}

include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
	
		$NewID = $_REQUEST['F_EventID'];
		$NewName = $_REQUEST['F_EventName'];
		$NewStartDate = $_REQUEST['F_EventStartDate'];
		$NewEndDate = $_REQUEST['F_EventEndDate'];
		$NewStartTime = $_REQUEST['F_EventStartTime'];
		$NewEndTime = $_REQUEST['F_EventEndTime'];
		$NewColor = '#' . $_REQUEST['F_EventColor'];
		$NewURL = $_REQUEST['F_EventURL'];
		$NewGroup = $_REQUEST['F_Group'];
		$NewPlaying = $_REQUEST['F_Playing'];
		
		echo $NewGroup;
		
		
		if ($conn->connect_error) {
			die("Connection Failed: " . $conn->connect_error);
		}
		echo "Connected Successfully! <br />";
		
			
			$getGroup = mysqli_query($conn, "SELECT * FROM groups WHERE group_id=$NewGroup");
			
			
			while($rs = mysqli_fetch_assoc($getGroup)) {
				
			$NewGroupName = $rs['name'];

			}


		
		
		if($_POST['addEventFormButton']) {
			
			
			
			$query = "INSERT INTO events (name, startdate, enddate, starttime, endtime, color, url, groupname, player1, player2, player3, player4, player5) VALUES ('$NewName', '$NewStartDate', '$NewEndDate', '$NewStartTime', '$NewEndTime', '$NewColor', '$NewURL', '$NewGroupName', '$NewPlaying[0]', '$NewPlaying[1]', '$NewPlaying[2]', '$NewPlaying[3]', '$NewPlaying[4]')";
			
			if ($conn->query($query) === TRUE) {
			
					echo "New Record Created! <br />";
				}
				else
				{
					echo "ERROR: <br />" . $query . "<br>" . $conn->error;
				}
			
			
		}
		elseif($_POST['editEventFormButton']) {
			echo "INSIDE EDIT! <br />";
			
			$query = "UPDATE events SET name='$NewName', startdate='$NewStartDate', enddate='$NewEndDate', starttime='$NewStartTime', endtime='$NewEndTime', color='$NewColor', url='$NewURL', groupname='$NewGroupName', player1='$NewPlaying[0]', player2='$NewPlaying[1]', player3='$NewPlaying[2]', player4='$NewPlaying[3]', player5='$NewPlaying[4]' WHERE id='$NewID'";
		
			if ($conn->query($query) === TRUE) {
				echo "Record Updated Successfully!";
			}
			else
			{
				echo "ERROR: <br />" . $query . "<br>" . $conn->error;
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
		
		header('location: admin.php?f=schedule&p=view');
			
		
	?>