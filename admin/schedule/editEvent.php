<?php
session_start();

if(!isset($_SESSION['username']))
	{
		header('location: login.php');
	}
?>
<!doctype html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="../../js/bootstrap.js"></script>
<script src="../../js/jscolor.js"></script>

<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../../css/custom.css">



<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
	include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");


	$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	$EventID = "";
	$EventName = "";
	$EventStartDate = "";
	$EventEndDate = "";
	$EventStartTime = "";
	$EventEndTime = "";
	$EventColor = "";
	$EventURL = "";
	$EventGroup = "";
	$EventPlayers = array();


	
	if(!empty($_REQUEST['chk'])) {
		foreach($_REQUEST['chk'] as $check) {
			$getEventID = $check;
			unset($_REQUEST['chk']);
		}
	}
	else
	{
		if ($_SERVER['HTTP_REFERER'] == "http://cal.teamexile.net/admin.php?f=schedule&p=editEvent" && !$_POST['editEventForm']) {
			//header('location: admin.php?f=schedule&p=view');
		}
		else
		{
			//header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}

	if(isset($getEventID)) {
		
		
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
	
		$result = mysqli_query($conn, "SELECT * FROM events WHERE id=$getEventID");
		}
		while($row = mysqli_fetch_array($result))
		{
			$EventID = $row['id'];
			$EventName = $row['name'];
			$EventStartDate = $row['startdate'];
			$EventEndDate = $row['enddate'];
			$EventStartTime = $row['starttime'];
			$EventEndTime = $row['endtime'];
			$EventColor = $row['color'];
			$EventURL = $row['url'];
			$EventGroup = $row['groupname'];
			array_push($EventPlayers, $row['player1']);
			array_push($EventPlayers, $row['player2']);
			array_push($EventPlayers, $row['player3']);
			array_push($EventPlayers, $row['player4']);
			array_push($EventPlayers, $row['player5']);
			
			$GroupID = "";

		}

?>
<div class="container">
	<div class="center-block" style="max-width:700px">
    	<h3 class="heading text-center">Edit Event</h3><br />
		<form class="form-horizontal" name="editEventForm" id="editEventForm" action="admin.php?f=schedule&p=save" method="post">
    		<div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventID">Event ID: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_EventID" id="F_EventID" readonly placeholder="<?php echo $EventID; ?>" value="<?php echo $EventID; ?>"> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventName">Event Name: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_EventName" id="F_EventName" placeholder="<?php echo $EventName; ?>" value="<?php echo $EventName; ?>" required> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventStartDate">Event Start Date: </label>
                	<div class="col-sm-9">
            			<input type="date" class="form-control" name="F_EventStartDate" id="F_EventStartDate" placeholder="<?php echo $EventStartDate; ?>" value="<?php echo $EventStartDate; ?>" required> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventEndDate">Event End Date: </label>
                	<div class="col-sm-9">
            			<input type="Date" class="form-control" name="F_EventEndDate" id="F_EventEndDate" placeholder="<?php echo $EventEndDate; ?>" value="<?php echo $EventEndDate; ?>" > 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventStartTime">Event Start Time: </label>
                	<div class="col-sm-9">
            			<input type="time" class="form-control" name="F_EventStartTime" id="F_EventStartTime" placeholder="<?php echo $EventStartTime; ?>" value="<?php echo $EventStartTime; ?>" required> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventEndTime">Event End Time: </label>
                	<div class="col-sm-9">
            			<input type="time" class="form-control" name="F_EventEndTime" id="F_EventEndTime" placeholder="<?php echo $EventEndTime; ?>" value="<?php echo $EventEndTime; ?>" > 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventColor">Event Color: </label>
                	<div class="col-sm-9">
            			<input class="form-control jscolor" name="F_EventColor" id="F_EventColor" value="<?php echo $EventColor; ?>" required> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventURL">Event URL: </label>
                	<div class="col-sm-9">
            			<input type="url" class="form-control" name="F_EventURL" id="F_EventURL" placeholder="<?php echo $EventURL; ?>" value="<?php echo $EventURL; ?>" > 
                   	</div>
        	</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="F_Group">Assign Players: </label>
					<div class="col-sm-3">
					<label class="control-label" for="F_Group">Choose Group: </label>
					<?php
					
						$result = mysqli_query($conn, "SELECT * FROM groups");
						
						$select='<select class="form-control" name="F_Group" style="width:150px" id="F_Group" onchange="showUsers(this.value)">';
									
						while($rs = mysqli_fetch_assoc($result)) {
							
							if ($rs['name'] == $EventGroup) {
								
								$select.='<option selected value="' . $rs['group_id'] . '">' . $rs['name'] . '</option>';
								$GroupID = $rs['group_id'];
								
							}
							else
							{
							$select.='<option value="' . $rs['group_id'] . '">' . $rs['name'] . '</option>';
							}
							
						}
			
						$select.='</select>';
						echo $select;
					?>
					</div>
					<div class="col-sm-3">
						<label class="control-label" for="F_playing">Playing: </label>
						<?php
						
							$select = '<select class="form-control" name="F_Playing[]" size="8" style="width:150px" id="F_Playing" multiple>';
							
						
							foreach($EventPlayers as $member) {
								
								if($member != NULL || $member != "") {
								
									$getUserID = mysqli_query($conn, "SELECT * FROM users WHERE username=$member");
				
									while($rs = mysqli_fetch_assoc($getUserID)) {
										
									$UserID = $rs['id'];

									}
									
									$select .= '<option value="' . $UserID . '">' . $member . '</option>';
								}
								
							}
							$select .= '</select>';
							echo $select;
						
						?>
						<input class="btn pull-left" type="button" name="toSubs" id="toSubs" value="+ Sub" />
						<input class="btn pull-right" type="button" name="toPlayers" id="toPlayers" value="- Sub" />
					</div>
					<div class="col-sm-3">
						<label class="control-label" for="F_subs">Subs: </label>
						<?php
						
							$select = '<select class="form-control" name="F_Subs[]" size="8" style="width:150px" id="F_Subs" multiple>';
							
									
									$getUserAssoc = mysqli_query($conn, "SELECT * FROM users LEFT JOIN usergroups ON users.id = usergroups.user_id WHERE usergroups.group_id = $GroupID");
									
									while($rs = mysqli_fetch_assoc($getUserAssoc)) {
										
										if(!in_array($rs['username'], $EventPlayers)) {
											
											$select .= '<option value="' . $rs['username'] . '">' . $rs['username'] . '</option>';
										 
										}

									}
									
							
							$select .= '</select>';
							echo $select;
						
						?>
					</div>
			</div>
            <div class="form-group">
            			<button class="btn btn-success center-block" name="editEventFormButton" id="editEventFormButton" onclick="selectAll()" type="submit" value="1"><span class="glyphicon glyphicon-floppy-save"></span> Save Event</button>
        	</div>
		</form>	
	</div>
</div>
<script type="text/javascript">

	function showUsers(str) {
		
		console.log("INSIDE ShowUsers("+ str +") FUNCTION");

        $.ajax({
            type: 'GET',
            url: 'admin/schedule/getPlayers.php',
			data: 'q=' + str,
            dataType: 'json',
            cache: false,
            success: function(result) {
			
				console.log("INSIDE SUCCESS FUNCTION");
			
				
				console.log(result);
				var allPlayers = jQuery.parseJSON(JSON.stringify(result));
				var players = allPlayers.players;
				var subs = allPlayers.subs;
				
				var playersBox = document.getElementById('F_Playing');
				var subsBox = document.getElementById('F_Subs');
				
				document.getElementById('F_Playing').options.length = 0;
				document.getElementById('F_Subs').options.length = 0;
				
				for (i = 0; i < players.length; ++i) {
					
					$(playersBox).append('<option value="' + players[i] +'">' + players[i] + '</option>');
					
				}
				
				for (i = 0; i < subs.length; ++i) {
					
					$(subsBox).append('<option value="' + subs[i] +'">' + subs[i] + '</option>');
					
				}
			}
            
        });
    }

function selectAll() 
    { 
        playingBox = document.getElementById("F_Playing");
		
		
		for (var i = 0; i < playingBox.options.length; i++) 
        { 
             playingBox.options[i].selected = true; 
        }
		
    }
	$(function() {
    
    function cutAndPaste(from, to) {
        $(to).append(function() {
            return $(from + " option:selected").each(function() {
                this.outerHTML;
            }).remove();
        });
    }
    
    $("#toSubs").off("click").on("click", function() {
        cutAndPaste("#F_Playing", "#F_Subs");
    });
    
    $("#toPlayers").off("click").on("click", function() {
        cutAndPaste("#F_Subs", "#F_Playing");
    });
    
});
</script>
</body>
</html>