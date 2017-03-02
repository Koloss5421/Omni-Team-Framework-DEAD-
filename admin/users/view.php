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
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../../css/custom.css">
<?php include ("../../include/config.php");?>
<script src="../../js/bootstrap.js"></script>
<script src="../../js/jquery-3.1.1.js"></script>
<script src="../../js/npm.js"></script>
</head>

<body>
<h3 class="heading text-center">All Users</h3>
<form method="POST" action="">
	<div class="panel pull-right">
        
        <button class="btn btn-success" value="1" type="submit" id="addButton" name="addButton" formaction="admin.php?f=users&p=addUser"><span class="glyphicon glyphicon-plus"></span> Add User</button>
        <button class="btn btn-primary" value="1" type="submit" id="editButton" name="editButton" formaction="admin.php?f=users&p=editUser"><span class="glyphicon glyphicon-pencil"></span> Edit User</button>
        <button class="btn btn-warning" value="1" type="submit" id="delButton" name="delButton" formaction="admin.php?f=users&p=delUser"><span class="glyphicon glyphicon-trash"></span> Delete User(s)</button>
        </div>
 <?php  
 
	include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");

	$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

 	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	echo "<table class='ClickableTable table table-bordered table-condensed table-hover text-center'>";
	echo '<thead class="text-center" style="text-transform: uppercase;">';
	echo "<tr>";
	echo "<th style='text-align:center;'><INPUT id='SelectAllBox' type='checkbox' onclick='checkNumBoxes()' onchange='checkAll(this)' name=''> </th>";
	echo "<th style='text-align:center;'>ID</th>";
	echo "<th style='text-align:center;'>Username</th>";
	echo "<th style='text-align:center;'>Email</th>";
	echo "<th style='text-align:center;'>Phone Num</th>";
	echo "<th style='text-align:center;'>Admin?</th>";
	echo "</thead>";
	
	function yesorno($DBRow){
		
		if($DBRow == 1) { return "Yes"; }
		else {return "No";}
		
	}
	
	function EncPhone($DBRow){
		
	$last = substr($DBRow,-4);
	$encrypt = str_repeat ('*', strlen( substr( $DBRow, 0, 6)));
	
	return $encrypt . $last;
		
	}
	if ($_SESSION['group_id'] === "2") {
		
				$getUserID = mysqli_query($conn, "SELECT * FROM users LEFT JOIN groups ON users.id != coach LEFT JOIN usergroups ON usergroups.group_id = 2");
				
				while($res = mysqli_fetch_assoc($getUserID)) {
					
					echo "<tr>";
					echo '<td  style="text-align:center;"><input id="row' . $row['id'] . '" type="checkbox" onclick="checkNumBoxes()" name="chk[]" value="' . $row['id'] . '"></td>';
					echo "<td>" . $row['id'] . "</td>";
					echo "<td>" . $row['username'] . "</td>";
					echo "<td>" . $row['email'] . "</td>";
					echo "<td>" . EncPhone($row['phone_num']) . "</td>";
					echo "<td>" . yesorno($row['admin']) . "</td>";
					echo "</tr>";
					
				}
					
					
	}
	else {
	
		$result = mysqli_query($conn, "SELECT * FROM users LEFT JOIN usergroups ON users.id = usergroups.user_id WHERE usergroups.group_id >=" . $_SESSION['group_id'] ." || usergroups.user_id IS NULL");
		
		while($row = mysqli_fetch_assoc($result)) {
			
			if($row['username'] != $_SESSION['username']) {
				
			
				echo "<tr>";
				echo '<td  style="text-align:center;"><input id="row' . $row['id'] . '" type="checkbox" onclick="checkNumBoxes()" name="chk[]" value="' . $row['id'] . '"></td>';
				echo "<td>" . $row['id'] . "</td>";
				echo "<td>" . $row['username'] . "</td>";
				echo "<td>" . $row['email'] . "</td>";
				echo "<td>" . EncPhone($row['phone_num']) . "</td>";
				echo "<td>" . yesorno($row['admin']) . "</td>";
				echo "</tr>";
			}			
				
		}
	}
	echo "</table>";
	
	mysqli_close($conn);
   
   ?>
 </form>
 <script type="text/javascript">
  $( document ).ready(function() {
        document.getElementById('editButton').disabled = true;
		document.getElementById('delButton').disabled = true;
    });
  
 
 $('.ClickableTable tr').click(function(event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    });
 
 function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
				 checkNumBoxes();
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
				 checkNumBoxes();
             }
         }
     }
 }
  function checkNumBoxes()
      {
       var inputElems = document.getElementsByTagName("input"),
        count = 0;
		var editButton = document.getElementById('editButton');
		var delButton = document.getElementById('delButton');
		var selectAllBox = document.getElementById('SelectAllBox');

        for (var i=0; i<inputElems.length; i++) {       
           if (inputElems[i].type == "checkbox" && inputElems[i].checked == true){
			   if(inputElems[i].id == 'SelectAllBox')
			   {
			   }
			   else
			   {
				   count++;
			   }
              
           }

        }
		if (count >= 1) {
			delButton.setAttribute("class", "btn btn-warning");
			delButton.disabled = false;
		}
		if (count > 1) {
			editButton.setAttribute("class", "btn btn-primary disabled");
			editButton.disabled = true;
		}
		else if (count == 0 && selectAllBox.checked == true || count == 0) {
			editButton.setAttribute("class", "btn btn-primary disabled");
			editButton.disabled = true;
			
			delButton.setAttribute("class", "btn btn-warning disabled");
			delButton.disabled = true;
			
		}
		else
		{
			editButton.setAttribute("class", "btn btn-primary");
			editButton.disabled = false;
			
		}
     }
 </script>
</body>
</html>