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
<h3 class="heading text-center">All Groups</h3>
<form method="POST" action="">
	<div class="panel pull-right">
        
        <button class="btn btn-success" value="1" type="submit" id="addButton" name="addButton" formaction="admin.php?f=groups&p=addGroup"><span class="glyphicon glyphicon-plus"></span> Add Group</button>
        <button class="btn btn-primary" value="1" type="submit" id="editButton" name="editButton" formaction="admin.php?f=groups&p=editGroup"><span class="glyphicon glyphicon-pencil"></span> Edit Group</button>
        <button class="btn btn-warning" value="1" type="submit" id="delButton" name="delButton" formaction="admin.php?f=groups&p=delGroup"><span class="glyphicon glyphicon-trash"></span> Delete Group(s)</button>
        </div>
 <?php  
 
	include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");

	$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

 	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$result = mysqli_query($conn, "SELECT * FROM groups");
	
	echo "<table class='ClickableTable table table-bordered table-condensed table-hover text-center'>";
	echo '<thead class="text-center" style="text-transform: uppercase;">';
	echo "<tr>";
	echo "<th style='text-align:center;'><INPUT id='SelectAllBox' type='checkbox' onclick='checkNumBoxes()' onchange='checkAll(this)' name=''> </th>";
	echo "<th style='text-align:center;'>ID</th>";
	echo "<th style='text-align:center;'>Name</th>";
	echo "<th style='text-align:center;'>Description</th>";
	echo "</thead>";
	
	while($row = mysqli_fetch_array($result))
	{
		
		if ($_SESSION['group_id'] != "1") {
			
			if ($row['group_id'] == "1" || $row['group_id'] == "2") {
				
			}
			else
			{
			echo "<tr>";
			echo '<td  style="text-align:center;"><input id="row' . $row['group_id'] . '" type="checkbox" onclick="checkNumBoxes()" name="chk[]" value="' . $row['group_id'] . '"></td>';
			echo "<td>" . $row['group_id'] . "</td>";
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['description'] . "</td>";
			echo "</tr>";
			}
		
		}
		else
		{
			echo "<tr>";
			echo '<td  style="text-align:center;"><input id="row' . $row['group_id'] . '" type="checkbox" onclick="checkNumBoxes()" name="chk[]" value="' . $row['group_id'] . '"></td>';
			echo "<td>" . $row['group_id'] . "</td>";
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['description'] . "</td>";
			echo "</tr>";
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