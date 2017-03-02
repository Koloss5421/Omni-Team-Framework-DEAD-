<?php
session_start();

if(!isset($_SESSION['username']))
	{
		header('location: ../../login.php');
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

</head>

<body>

<div class="container">
	<div class="center-block" style="max-width:700px">
    	<h3 class="heading text-center display-4">Add Event</h3><br />
		<form class="form-horizontal" name="addEventForm" id="addEventForm" action="admin.php?f=schedule&p=save" method="post">
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventName">Event Name: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_EventName" id="F_EventName" placeholder="A Descriptive Name (ie. Team Green Practice)" value="" required> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventStartDate">Event Start Date: </label>
                	<div class="col-sm-9">
            			<input type="date" class="form-control" name="F_EventStartDate" id="F_EventStartDate" placeholder="" value="" required> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventEndDate">Event End Date: </label>
                	<div class="col-sm-9">
            			<input type="Date" class="form-control" name="F_EventEndDate" id="F_EventEndDate" placeholder="" value="" > 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventStartTime">Event Start Time: </label>
                	<div class="col-sm-9">
            			<input type="time" class="form-control" name="F_EventStartTime" id="F_EventStartTime" placeholder="" value="" required> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventEndTime">Event End Time: </label>
                	<div class="col-sm-9">
            			<input type="time" class="form-control" name="F_EventEndTime" id="F_EventEndTime" placeholder="" value="" > 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventColor">Event Color: </label>
                	<div class="col-sm-9">
            			<input class="form-control jscolor" name="F_EventColor" id="F_EventColor" value="" required> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_EventURL">Event URL: </label>
                	<div class="col-sm-9">
            			<input type="url" class="form-control" name="F_EventURL" id="F_EventURL" placeholder="Set a URL such as a ts3server://wr143.teamspeak3.com" value="" > 
                   	</div>
        	</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="F_Group">Assign Players: </label>
					<div class="col-sm-3">
					<label class="control-label" for="F_Group">Choose Group: </label>
					<?php
						$DBhost="localhost";
						$DBuser="jofrud_caluser";
						$DBpass="bEeiLFSk5wbM";
						$DB="jofrud_texcal";
				
						$con = mysqli_connect($DBhost, $DBuser, $DBpass, $DB);
				
						if (mysqli_connect_errno())
						{
							echo "Failed to connect to MySQL: " . mysqli_connect_error();
						}
					
						$result = mysqli_query($con, "SELECT * FROM groups");
						
						$select='<select class="form-control" name="F_Group" style="width:150px" id="F_Group" onchange="showUsers(this.value)">';
						$select.='<option selected disabled hidden>Select...</option>';
									
						while($rs = mysqli_fetch_assoc($result)) {
							
							$select.='<option value="' . $rs['group_id'] . '">' . $rs['name'] . '</option>';
							
						}
			
						$select.='</select>';
						echo $select;
					?>
					</div>
					<div class="col-sm-3">
						<label class="control-label" for="F_playing">Playing: </label>
						<select class="form-control" name="F_Playing[]" size="8" style="width:150px" id="F_Playing" multiple>
						
						</select>
						<input class="btn pull-left" type="button" name="toSubs" id="toSubs" value="+ Sub" />
						<input class="btn pull-right" type="button" name="toPlayers" id="toPlayers" value="- Sub" />
					</div>
					<div class="col-sm-3">
						<label class="control-label" for="F_subs">Subs: </label>
						<select class="form-control" name="F_Subs[]" size="8" style="width:150px" id="F_Subs" multiple>
							
						</select>
					</div>
			</div>
			
			<div class="text-center">
				<div class="btn-group">
							<button class="btn btn-success" name="addEventFormButton" id="addEventFormButton" type="submit" onclick="selectAll()" value="addNew"><span class="glyphicon glyphicon-floppy-save"></span> Save Event</button>
							<button class="btn btn-danger" name="addEventFormCancel" id="addEventFormCancel" type="button" onclick="location.href='admin.php?f=schedule&p=view'"><span class="glyphicon glyphicon-floppy-remove"></span> Cancel</button>
				</div>
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