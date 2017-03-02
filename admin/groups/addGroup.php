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

<?php  
 
include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

 	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
   
   ?>

<div class="container">
	<div class="center-block" style="max-width:700px">
    	<h3 class="heading text-center display-4">Add Group</h3><br />
		<form class="form-horizontal" name="addUserForm" id="addUserForm" action="admin.php?f=groups&p=save" method="post">
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_GroupName">Group Name: </label>
                	<div class="col-sm-3">
            			<input type="text" class="form-control" name="F_GroupName" id="F_GroupName" placeholder="Username" value="" required> 
                   	</div>
					<label class="col-sm-3 control-label" for="F_GroupType">Group Type: </label>
                	<div class="col-sm-3">
            			
						<select type="text" class="form-control" name="F_GroupType" id="F_GroupType" required>
							<option value="0">Group</option>
							<option value="1">Team</option>
						</select>
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_Desc">Group Description: </label>
                	<div class="col-sm-9">
            			<textarea type="text" class="form-control" name="F_Desc" id="F_Desc" placeholder="Just a simple description to describe this group. (Max 150 Chars)" rows="4" maxlength="150" required></textarea> 
                   	</div>
        	</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="F_users">Assign Users: </label>
					<div class="col-sm-3">
					<label class="control-label" for="F_users">Groupless: </label>
						<?php
						
							$getUsers = mysqli_query($conn, "SELECT * FROM users LEFT JOIN usergroups ON users.id = usergroups.user_id WHERE usergroups.user_id IS NULL");
				
							$select='<select class="form-control" name="F_users" size="8" style="width:150px" id="F_users" multiple="multiple">';
							
							while($rs = mysqli_fetch_assoc($getUsers)) {
								
								$select.='<option value="' . $rs['id'] . '">' . $rs['username'] . '</option>';
								
							}
				
							$select.='</select>';
							echo $select;
							
							mysqli_close($conn);
						
						?>
						<input class="btn pull-left" type="button" name="toGroup" id="toGroup" value="+ Group" />
						<input class="btn pull-right" type="button" name="toUsers" id="toUsers" value="- Group" />
						
					</div>
					<div class="col-sm-3">
					<label class="control-label" for="F_group">In Group: </label>
						<select class="form-control" name="F_group" size="8" style="width:150px" id="F_group" multiple="multiple"></select>
						<input class="btn pull-left" type="button" name="toSubs" id="toSubs" value="+ Sub" />
						<input class="btn pull-right" type="button" name="toPlayers" id="toPlayers" value="- Sub" />
						
					</div>
					<div class="col-sm-3">
					<label class="control-label" for="F_subs">Subs: </label>
						<select class="form-control" name="F_subs" size="8" style="width:150px" id="F_subs" multiple="multiple"></select>
						
					</div>
			</div>
			<div class="text-center">
				<div class="btn-group">
							<button class="btn btn-success" name="addGroupFormButton" id="addGroupFormButton" type="submit" value="addNew"><span class="glyphicon glyphicon-floppy-save"></span> Save Group</button>
							<button class="btn btn-danger" name="editGroupForm" id="editGroupForm" type="button" onclick="location.href='admin.php?f=groups&p=view'"><span class="glyphicon glyphicon-floppy-remove"></span> Cancel</button>
				</div>
			</div>
		</form>	
	</div>
</div>
<script type="text/javascript">
 $(function() {
    
    function cutAndPaste(from, to) {
        $(to).append(function() {
            return $(from + " option:selected").each(function() {
                this.outerHTML;
            }).remove();
        });
    }
    
    $("#toGroup").off("click").on("click", function() {
        cutAndPaste("#F_users", "#F_group");
    });
    
    $("#toUsers").off("click").on("click", function() {
        cutAndPaste("#F_group", "#F_users");
    });
    $("#toSubs").off("click").on("click", function() {
        cutAndPaste("#F_group", "#F_subs");
    });
    
    $("#toPlayers").off("click").on("click", function() {
        cutAndPaste("#F_subs", "#F_group");
    });
    
});

function selectAll() 
    { 
        usersBox = document.getElementById("F_users");
		
		groupBox = document.getElementById("F_group");
		
		subsBox = document.getElementById("F_subs");

        for (var i = 0; i < usersBox.options.length; i++) 
        { 
             usersBox.options[i].selected = false; 
        }
		
		for (var i = 0; i < groupBox.options.length; i++) 
        { 
             groupBox.options[i].selected = true; 
        }
		
		for (var i = 0; i < subsBox.options.length; i++) 
        { 
             subsBox.options[i].selected = true; 
        }		
    }
</script>
</body>
</html>