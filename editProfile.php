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
<title>Untitled Document</title>
</head>

<body>
<?php

$UserID = "";
$Username = "";
$CurrentPassword = "";
$NewPassword = "";
$Email = "";
$PhoneNum = "";

	
	if(isset($_SESSION['username'])) {
		$DBhost="localhost";
 		$DBuser="jofrud_caluser";
 		$DBpass="bEeiLFSk5wbM";
 		$DB="jofrud_texcal";
		
		$conn = mysqli_connect($DBhost, $DBuser, $DBpass, $DB);
		
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
	
		$result = mysqli_query($conn, "SELECT * FROM users WHERE username='" . $_SESSION['username'] ."'");
		
		}
		while($row = mysqli_fetch_assoc($result))
		{
			$UserID = $row['id'];
			$Username = $row['username'];
			$Email = $row['email'];
			$PhoneNum = $row['phone_num'];
			$Carrier = $row['carrier'];
		}

?>
<div class="container">
	<div class="center-block" style="max-width:700px">
    	<h3 class="text-center"><u>Edit User</u></h3>
		<form class="form-horizontal" name="editUserForm" id="editUserForm" action="admin.php?f=settings&p=saveProfile" method="post">
    		<div class="form-group">
            	<label class="col-sm-3 control-label" for="F_UserID">User ID: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_UserID" id="F_UserID" readonly placeholder="<?php echo $UserID; ?>" value="<?php echo $UserID; ?>"> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_Username">Username: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_Username" id="F_Username" placeholder="<?php echo $Username; ?>" value="<?php echo $Username; ?>" required> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_Password">Change Password: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_Password" id="F_Password" placeholder="Set new password value here..." value=""> 
                   	</div>
        	</div>
			<!--
			<div class="form-group">

				<label class="col-sm-3 control-label" for="F_Password">Current Password: </label>
				<div class="col-sm-9">
					<input type="password" class="form-control" name="F_curPassword" id="F_curPassword" placeholder="" value=""> 
				</div>

        	</div>
			-->
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_Email">Email: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_Email" id="F_Email" placeholder="<?php echo $Email; ?>" value="<?php echo $Email; ?>" required> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_PhoneNum">Phone Number: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_PhoneNum" id="F_PhoneNum" placeholder="<?php echo $PhoneNum; ?>" value="<?php echo $PhoneNum; ?>" > 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_Carrier">Carrier: </label>
                	<div class="col-sm-9">
					<?php
						
							$getCarriers= mysqli_query($conn, "SELECT * FROM carriers");
							
				
							$select='<select class="form-control" name="F_Carrier" style="width:150px" id="F_Carrier">';
							$select.='<option hidden value="">Select a Carrier...</option>';
							
							while($rs = mysqli_fetch_assoc($getCarriers)) {
								
								echo $rs['domain'];
								
								if($rs['domain'] == $Carrier) {
									
									$select.='<option selected value="' . $rs['domain'] . '">' . $rs['name'] . '</option>';
									
								}
								else
								{
									
									$select.='<option value="' . $rs['domain'] . '">' . $rs['name'] . '</option>';
									
								}
								
							}
				
							$select.='</select>';
							echo $select;
							
						mysqli_close($conn);
						?>
					</div>
        	</div>
            <div class="form-group">
            			<button class="btn btn-success center-block" name="editUserFormButton" id="editUserFormButton" type="submit" value="editUser"><span class="glyphicon glyphicon-floppy-save"></span> Save Event</button>
        	</div>
		</form>	
	</div>
</div>
</body>
</html>