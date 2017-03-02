<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
		
		if ($conn->connect_error) {
			die("Connection Failed: " . $conn->connect_error);
		}
		echo "Connected Successfully! <br />";
		
		$getEvents = mysqli_query($conn, "SELECT * FROM events");
		
		while($row = mysqli_fetch_assoc($getEvents)) {
			
			echo " | checking for Events | ";
			
			$eventName = $row['name'];
			$eventTime = str_replace(":", "", $row['starttime']);
			$currentTime = (string)date("Hi");			
			$checkTime = $eventTime - $currentTime;
			$players = array($row['player1'], $row['player2'], $row['player3'], $row['player4'], $row['player5']);
			
			if($checkTime <= 101 && $checkTime > 0) {
				
				echo " | There is an Event | ";
				
				for ($i = 0; $i < count($players); ++$i)
				{
					$getUsers = mysqli_query($conn, "SELECT * FROM users LEFT JOIN carriers ON users.carrier = carriers.id");
					
					while($rs = mysqli_fetch_assoc($getUsers)) {
						
						if ($rs['username'] == $players[$i]) {
							
							$playerNum = $rs['phone_num'] . "@" . $rs['domain'];
							$playerEmail = $rs['email'];
							$subject = "Team Exile Alert";
							
							echo $playerNum;
							
							$body_Message = $rs['username'] . ", You are scheduled for " . $eventName . "\n";
							$body_Message .= "It starts @ " . date("g:i a", strtotime($row['starttime'])) . " EST \n";
							
							$headers = "From: webmaster@poorlyoptimized.com\r\n";
							$headers .= 'Reply-To: '.$playerNum."\r\n";
							echo "Sending Mail!";
							
							$sms_status = mail($playerNum, $subject, $body_Message, $headers);
							
							$headers = "From: webmaster@poorlyoptimized.com\r\n";
							$headers .= 'Reply-To: '.$playerEmail."\r\n";
							
							$mail_status = mail($playerEmail, $subject, $body_Message, $headers);

						}
					}
					
				}
				
			}
			
			
		}
		
		//echo $getEvents;
		


/*
$field_name = "Koloss";
$field_subject = "Meeting @ 7:00pm";
$field_email = "19013194680@tmomail.net";
$field_message = "TEST MESSAGE";

$mail_to = '19013194680@tmomail.net';
$mail_from = 'webmaster@poorlyoptimized.com';
$subject = 'Team Exile Alert: '.$field_subject;

$body_message = 'From: '.$field_name."\n";
$body_message = 'Subject: '.$field_subject."\n";
$body_message .= 'E-mail: '.$field_email."\n";
$body_message .= 'Message: '.$field_message;

$headers = 'From: '. $mail_from ."\r\n";
$headers .= 'Reply-To: '.$field_email."\r\n";
	
$mail_status = mail($mail_to, $subject, $body_message, $headers);
*/
/*
		TODO:
		
		Need to see if there is a way to execute PHP script without
		CronJobs
		
			Check if There is an event soon:
				Need to Fetch data from events table
				Check each row to see if the time is Within 1 hour away
				if there is, Build Array of Players[] with Player 1-5 Fields
				for each index in the array check the 'users' data and pull
				the email, phone_num, carrier, player name
			
			Build and Send Messages:
			
				For Each player in the Players[] Array
				Take New Email phone_num carrier and name and build a message
				with the name of event and time of event that they are scheduled
				
				Send The Messages to Both Email and Via SMS IF Phone_Num !Not Null
				




*/
?>