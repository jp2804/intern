<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Add Equipment</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
		body {
			font-family: Arial, Helvetica, sans-serif;
		}
		@media screen and (max-width: 700px) {
			.row { 
				flex-direction: column;
			}
		}

		@media screen and (max-width: 400px) {
			.navbar a {
				float: none;
				width: 100%;
			}
		}
		</style>
		<link rel="stylesheet" href="../css/menuCSS.css">
	</head>
<body>
	<?php
		session_start();
		$servername="localhost";
		$username="root";
		$serverpassword="";
		$dbname="inventory_management";
		$error="";
		$count=0;
		$equipmentID=$equipmentDescription=$equipmentType="";
		$conn=mysqli_connect($servername,$username,$serverpassword,$dbname);
		if(isset($_SESSION["AdminID"]))
		{
			if(!$conn)
			{
				die("Connection failed:".mysqli_connect_error());
			}
			else
			{			
			if ($_SERVER["REQUEST_METHOD"] == "POST") 
			{
				$equipmentID=$_POST["equipmentID"];
				$equipmentDescription=$_POST["equipmentDescription"];
				$equipmentType=$_POST["equipmentType"];
				$count=0;
				
				$pattern="/^[A-Za-z0-9_-]+$/";
				
				if(!preg_match($pattern,$equipmentID)) 
				{
				   $error="*Spaces are not allowed. Use underscore.";
				   $equipmentID="";
				   $count++;
				}
				else if(!preg_match($pattern,$equipmentDescription))
				{
				   $error="*Spaces are not allowed. Use underscore.";
				   $equipmentDescription="";
				   $count++;
				}
				else if(!preg_match($pattern,$equipmentType))
				{
				   $error="*Spaces are not allowed. Use underscore.";
				   $equipmentType="";
				   $count++;
				}
				
				if (isset($_POST['addEquipment']) && $count==0)
				{
					$sql1="INSERT INTO components(Equipment_Name,Equipment_Description,Equipment_ID) VALUES ('".$equipmentType."', '".$equipmentDescription."', '".$equipmentID."')";
					$sql2="INSERT INTO availability(Equipment_Name,Equipment_Description,Equipment_ID) VALUES ('".$equipmentType."', '".$equipmentDescription."', '".$equipmentID."')";
				    if(mysqli_query($conn,$sql1) && mysqli_query($conn,$sql2))
					{
					   $error="* Equipment added successfully";
					   $equipmentID=$equipmentDescription=$equipmentType="";
					}
					else
					{
					   $error="* Equipment not added. It may already exists";
					}
				}
			}
			}
		}
		if(!isset($_SESSION["AdminID"]))
		{
			$error="* Unauthorized Access. Admin not found";
		}
	?>

	<div class="header" style="background-color: black;color:orange;height:120px;text-align:center">
     	<div style="background-color: black;height:90px;width:180px;">
		 <img src="resources/logo.png" />
		</div>
	
		<h3 style="margin-top:-40px">Gateway Software Solutions </h3>
	</div>

	<div class="tab" style="height:410px">
	  <a href="statusPage.php"><button class="tablinks">Status</button></a>
	  <a href="addComponent.php"><button class="tablinks" style="background-color:#ccc">Add Equipment</button></a>
	  <a href="modifyComponent.php"><button class="tablinks">Modify Equipment</button></a>
	  <a href="reportGenaration.php"><button class="tablinks">Report Generation</button></a>
	  <a href="viewemployees.php"><button class="tablinks">Employee Details</button></a>
	  <a href="Logout.php"><button class="tablinks">Log Out</button></a>
	</div>

	<div class="requestContainer" style="background-color:#696969;height:410px;margin-top:-20px;">
	    <h2><br></h2>
		<h2 style="margin-left:430px;">Add Equipment</h2>
		<center><form method="POST">
			<input type="text" style="margin-left:-60px;" name="equipmentID" placeholder="Equipment ID" value="<?php echo $equipmentID;?>" required><br><br>
			<input type="text" style="margin-left:-60px;"name="equipmentDescription" placeholder="Equipment Description" value="<?php echo $equipmentDescription;?>" required><br><br>
			<input type="text" style="margin-left:-60px;"name="equipmentType" placeholder="Equipment Type" value="<?php echo $equipmentType;?>" required><br><br>
			<input type="submit" style="background-color:black;margin-left:-60px;" value="Add" name="addEquipment"><br><br>
			<span style="color:red"> <?php echo $error;?></span>
		</form></center>
	</div>
	<div style="margin-left:-50px;background-color:black;height:113px;margin-top:0px;color:orange;text-align:center;">
	     <br>
		<p >Gateway Software Solutions, Coimbatore</p>
	</div>
     
</body>
</html>