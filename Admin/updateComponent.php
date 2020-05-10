<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Update Equipment</title>
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
		if(isset($_SESSION["AdminID"]))
		{
			$servername="localhost";
			$username="root";
			$serverpassword="";
			$dbname="inventory_management";
			$error="";
			$count=0;
			$equipmentID=$equipmentDescription=$equipmentType="";
			$conn=mysqli_connect($servername,$username,$serverpassword,$dbname);
	
			if(!$conn)
			{
				die("Connection failed:".mysqli_connect_error());
			}
			else
			{		
		       $equipmentID=$_SESSION["chosenEquipmentID"];
			   $sqlQuery = "SELECT Equipment_Name,Equipment_Description FROM components WHERE Equipment_ID='{$equipmentID}'";
			   $result=mysqli_query($conn, $sqlQuery);
			   
			   while($row=mysqli_fetch_array($result))
			   {
			    $equipmentDescription=$row[1];
			    $equipmentType=$row[0];   
			   }
			   
			   if ($_SERVER["REQUEST_METHOD"] == "POST") 
			   {
				if(isset($_POST['updateEquipment']))
				{
					$equipmentDescription=$_POST["equipmentDescription"];
					$equipmentType=$_POST["equipmentType"];
					$sql1 = "UPDATE components SET Equipment_Name='{$equipmentType}',Equipment_Description='{$equipmentDescription}' WHERE Equipment_ID='{$equipmentID}'";
					$sql2 = "UPDATE availability SET Equipment_Name='{$equipmentType}',Equipment_Description='{$equipmentDescription}' WHERE Equipment_ID='{$equipmentID}'";
					$sql3 = "UPDATE status SET EquipmentName='{$equipmentType}',EquipmentDescription='{$equipmentDescription}' WHERE EquipmentID='{$equipmentID}'";
					$sql4 = "UPDATE log SET EquipmentName='{$equipmentType}',EquipmentDescription='{$equipmentDescription}' WHERE EquipmentID='{$equipmentID}'";
					
					if(mysqli_query($conn,$sql4))
					{
						if(mysqli_query($conn,$sql3))
						{
							if(mysqli_query($conn,$sql2))
							{
								if(mysqli_query($conn,$sql1))
								{
									$error ="* Component Details Updated Successfully !";
								}
								else
								{
									$error="* Component Details Not Updated !";
								}
							}
							else
							{
								$error="* Component Details Not Updated !";
							}
						}
						else
						{
							$error="* Component Details Not Updated !";
						}
					}
					else
					{
						$error="* Component Details Not Updated !";
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
	  <a href="statusPage.php"><button class="tablinks">status</button></a>
	  <a href="addComponent.php"><button class="tablinks">Add Equipment</button></a>
	  <a href="modifyComponent.php"><button class="tablinks" style="background-color:#ccc">Modify Equipment</button></a>
	  <a href="reportGenaration.php"><button class="tablinks">Report Generation</button></a>
	  <a href="viewemployees.php"><button class="tablinks">Employees Details</button></a>
	  <a href="Logout.php"><button class="tablinks">Log Out</button></a>
	</div>

	<div class="requestContainer"  style="background-color:#696969;height:410px;margin-top:-20px">
		<center><h2>Update Equipment</h2></center>
		<center><form method="POST">
			<input type="text" name="equipmentID" placeholder="Equipment ID" value="<?php echo $equipmentID;?>" disabled><br><br>
			<input type="text" name="equipmentDescription" placeholder="Equipment Description" value="<?php echo $equipmentDescription;?>" required><br><br>
			<input type="text" name="equipmentType" placeholder="Equipment Type" value="<?php echo $equipmentType;?>" required><br><br>
			<input type="submit" style = "background-color:black;" value="Update" name="updateEquipment"><br><br>
			<span style="color:red"> <?php echo $error;?></span>
		</form></center>
	</div>
	 <div style="margin-left:-50px;background-color:black;height:113px;margin-top:0px;color:orange;text-align:center;">
	     <br>
		<p >Gateway Software Solutions, Coimbatore</p>
	</div>
     
</body>
</html>