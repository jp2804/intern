<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Request Page</title>
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
		table
		{
			border-collapse: collapse;
			width:auto;
		}
		table td, table th 
		{
			border: 1px solid #ddd;
			padding: 8px;
		}
		table th
		{
			background-color:#4CAF50;
			color:white;
			padding-top: 12px;
			padding-bottom: 12px;
			text-align: center;
		}
		table tr:nth-child(even){background-color: #f2f2f2;}
		table tr:hover {background-color: #ddd;}
		button {
			background-color: #4CAF50;
			color: white;
			cursor: pointer;
			border: 1px solid #ddd;
			width: 25%;
			padding: 3px;
			border-radius: 4px;
			margin: 5px 0px 5px 0px;
			opacity: 0.85;
			font-size: 17px;
			line-height: 20px;
			text-decoration: none; 
		}

		button:hover {
			background-color: #21B9F8;
		}
		</style>
		<link rel="stylesheet" href="../css/menuCSS.css">
	</head>
<body>

	<div class="header" style="background-color: black;color:orange;height:120px;text-align:center">
     	<div style="background-color: black;height:90px;width:180px;">
		 <img src="resources/logo.png" />
		</div>
	
		<h3 style="margin-top:-40px">Gateway Software Solutions </h3>
	</div>

	<div class="tab" style="height:410px">
	  <a href="statusPage.php"><button class="tablinks">Status</button></a>
	  <a href="addComponent.php"><button class="tablinks">Add Equipment</button></a>
	  <a href="modifyComponent.php"><button class="tablinks" style="background-color:#ccc">Modify Equipment</button></a>
	  <a href="reportGenaration.php"><button class="tablinks">Report Generation</button></a>
	  <a href="viewemployees.php"><button class="tablinks">Employee Details</button></a>
	  <a href="Logout.php"><button class="tablinks">Log Out</button></a>
	
	
	<div class="requestContainer" style="background-color:#696969;margin-top:-385px;height:410px;width:1075px;margin-left:190px;overflow-y: auto;">
		<?php
		    session_start();
			$servername="localhost";
			$username="root";
			$serverpassword="";
			$dbname="inventory_management";
			$error ="";
			$message="";
			$conn=mysqli_connect($servername,$username,$serverpassword,$dbname);
			if(isset($_SESSION["AdminID"]))
			{	
				if(!$conn)
				{
					die("Connection failed:".mysqli_connect_error());
				}
				else
				{
					$getComponents = "SELECT distinct(Equipment_Description) from availability ORDER BY Equipment_Description ASC";
					$result = mysqli_query($conn,$getComponents);
					if (!$result) 
					{
						$error ="No equipments available<br>";
						echo "MySQL Error: " . mysqli_error($conn);
						exit;
					}
				}
			}
			if(!isset($_SESSION["AdminID"]))
			{
				$message="* Unauthorized Access. Admin not found";
			}
		?> 
		<?php
		   echo "<h2><br></h2>";
		   echo "<center><h2>List of Lab Components</h2></center>";
		   echo "<br>";
		   echo "<form method='POST'>";
		   echo "<center><select name='componentName'>"; // Open your drop down box 
		   while ($row = mysqli_fetch_array($result)) 
		   {
				echo '<option value="'.$row[0].'">'.$row[0].'</option>';
		   }
			echo '</select></center>';
			echo '<br>';
			
			echo "<center><input type='submit' style='background-color:black;' value='Modify' name='Modify'></center>";
			echo "<br><br>";
		?>
		<?php
			if($conn && isset($_SESSION["AdminID"]))
			{
				if ($_SERVER["REQUEST_METHOD"] == "POST") 
				{
					if(isset($_POST['Modify']))
					{
						$_SESSION["chosenComponent"]=$_POST["componentName"];
						$sqlQuery="SELECT Equipment_ID, Equipment_Name from components where Equipment_Description='{$_POST["componentName"]}' ORDER BY Equipment_ID ASC";
						$result2=mysqli_query($conn, $sqlQuery);
						echo "<center><table>";
						echo "<tr><th style='background-color:skyblue'>Equipment ID</th>
						<th style='background-color:skyblue'>Equipment Description</th>
						<th style='background-color:skyblue'>Equipment Model</th>
						<th style='background-color:skyblue'>Modify</th></tr>";
						while ($row2 = mysqli_fetch_array($result2)) 
					    {
							echo "<tr>";
							echo "<td>".$row2[0]."</td>";
							echo "<td>".$_POST["componentName"]."</td>";
							echo "<td>".$row2[1]."</td>";
							echo "<td>";
							echo "<center><button name='Update' value=".$row2[0]." style='text-align:center;height:5px;color:white;width:80px;background-color:skyblue;'>Update</button>";
							echo "<br>";
							echo "<button name='Delete' value=".$row2[0]." style='text-align:center;height:5px;color:white;width:80px;background-color:skyblue;'>Delete</button></center>";
							echo "</td></form>";
							echo "</tr>";
						}
						echo "</table></center>";
						echo "<br><br>";
					}
				}
			}
		?>
		<?php
		    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["AdminID"])) 
			{
				if(isset($_POST['Update']))
				{
					$_SESSION["chosenEquipmentID"] =$_POST['Update'] ;
					header("location: updateComponent.php");
				}
			}
		?>
		<?php
		  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["AdminID"])) 
		  {
			if(isset($_POST['Delete']))
			{
				$AdminID=$AdminName=$componentID=$ComponentDesc=$ComponentName=$Date=$Time=$Status="";
				$message="";
				
				$AdminID=$_SESSION["AdminID"];
				$AdminName="ADMIN";
				$componentID=$_POST['Delete'];
				
				$sql1="SELECT Equipment_Description, Equipment_Name FROM components WHERE Equipment_ID='{$componentID}'";
				$res1=mysqli_query($conn, $sql1);
				$rw1=mysqli_fetch_array($res1);
				$ComponentDesc=$rw1[0];
				$ComponentName=$rw1[1];
				
				date_default_timezone_set("Asia/Calcutta");
				$Date=date("Y-m-d");
				$Time=date("h:i:sa");
				$Status="REMOVED";
				
				$sql2="DELETE FROM Status WHERE EquipmentID='{$componentID}'";
				$sql3="DELETE FROM availability WHERE Equipment_ID='{$componentID}'";
				$sql4="DELETE FROM components WHERE Equipment_ID='{$componentID}'";
				$sql5="INSERT INTO log(EmpID,EmployeeName,EquipmentID,EquipmentDescription,EquipmentName,Date,Time,Status) VALUES ('".$AdminID."', '".$AdminName."', '".$componentID."', '".$ComponentDesc."', '".$ComponentName."', '".$Date."', '".$Time."', '".$Status."')";	

				if(mysqli_query($conn,$sql2))
				{
					if(mysqli_query($conn,$sql3))
					{
						if(mysqli_query($conn,$sql4))
						{
							if(mysqli_query($conn,$sql5))
							{
								$message="Equipments Removed Successfully!";
							}
							else
						    {
								$message="Equipments Not Removed";
							}
						}
						else
						{
							$message="Equipments Not Removed";
						}
					}
					else
					{
							$message="Equipments Not Removed";
					}
				}
				else
				{
					$message="Equipments Not Removed";
				}
			}
			mysqli_close($conn);
		  }
		?>

    <center><span style="color:red"><?php echo $message;?></span></center>
	</div></div>
	
     <div style="margin-left:-50px;background-color:black;height:113px;margin-top:400px;color:orange;text-align:center;">
	     <br>
		<p >Gateway Software Solutions, Coimbatore</p>
	</div>
</body>
</html>