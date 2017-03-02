<?php

include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");

	$q = intval($_GET['q']);

	$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
	
	$players = array();
	$subs = array();
	
	$allPlayers = array();
	
	
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$getUsers = mysqli_query($conn, "SELECT * FROM users LEFT JOIN usergroups ON users.id = usergroups.user_id WHERE usergroups.sub != '1' && usergroups.group_id = $q");
	
	while($rs = mysqli_fetch_assoc($getUsers)) {
		
		array_push($players, $rs['username']);
		
	}
	
	$getSubs = mysqli_query($conn, "SELECT * FROM users LEFT JOIN usergroups ON users.id = usergroups.user_id WHERE usergroups.sub = '1' && usergroups.group_id = $q");
	
	while($rs = mysqli_fetch_assoc($getSubs)) {
		
		array_push($subs, $rs['username']);
		
	}
	
	mysqli_close($conn);
	$allPlayers['players'] = $players;
	$allPlayers['subs'] = $subs;
	echo json_encode($allPlayers);
	
?>