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
	<div class="center-block" style="max-width:500px">
    	<h3 class="heading text-center display-4">Add User</h3><br />
		<form class="form-horizontal" name="addUserForm" id="addUserForm" action="admin.php?f=users&p=save" method="post">
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_Username">Username: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_Username" id="F_Username" placeholder="Username" value="" required> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_Password">Password: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_Password" id="F_Password" placeholder="Not necessary for non-admin" value=""> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_Email">Email: </label>
                	<div class="col-sm-9">
            			<input type="email" class="form-control" name="F_Email" id="F_Email" placeholder="username@gmail.com" value="" required> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_PhoneNum">Phone Number: </label>
                	<div class="col-sm-9">
            			<input type="number" class="form-control" name="F_PhoneNum" id="F_PhoneNum" placeholder="1234567890 Format" value=""> 
                   	</div>
        	</div>
            <div class="form-group">
            	<label class="col-sm-3 control-label" for="F_Carrier">Carrier: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_Carrier" id="F_Carrier" placeholder="Such as att, verizon, cricket etc."  value="" > 
                   	</div>
        	</div>
            <div class="form-group">
                <div class="btn-group" role="group">
            			<button class="btn btn-success btn-block pull-right" name="addUserFormButton" id="addUserFormButton" type="submit" value="addNew"><span class="glyphicon glyphicon-floppy-save"></span> Save User</button>
                        <a href="admin.php?f=schedule&p=view" class="btn btn-danger btn-block pull-right" name="editUserForm" id="editUserForm" type="button"><span class="glyphicon glyphicon-floppy-remove"></span> Cancel</a>
                        </div>
        	</div>
		</form>	
	</div>
</div>
</body>
</html>