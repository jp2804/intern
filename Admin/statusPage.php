<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Status Page</title>
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
	  <a href="statusPage.php"><button class="tablinks" style="background-color:#ccc">Status</button></a>
	  <a href="addComponent.php"><button class="tablinks">Add Equipment</button></a>
	  <a href="modifyComponent.php"><button class="tablinks">Modify Equipment</button></a>
	  <a href="reportGenaration.php"><button class="tablinks">Report Generation</button></a>
	  <a href="viewemployees.php"><button class="tablinks">Employee Details</button></a>
	  <a href="Logout.php"><button class="tablinks">Log Out</button></a>
	</div>

	<div class="requestContainer" style="background-color:#696969;height:410px;margin-top:0px;">
	<br>
	   <?php
			session_start();
			if(isset($_SESSION["AdminID"]))
			{
				$servername="localhost";
				$username="root";
				$serverpassword="";
				$dbname="inventory_management";
				$message="";
				$conn=mysqli_connect($servername,$username,$serverpassword,$dbname);
				
				if(!$conn)
				{
					die("Connection failed:".mysqli_connect_error());
				}
				else
				{
					$getStudentsList = "SELECT DISTINCT EmpID, EmployeeName from Status WHERE Status!='CANCELLED' AND Status!='REJECTED' AND Status!='RETURNED' ORDER BY EmpID ASC";
					$result = mysqli_query($conn,$getStudentsList);
					if (!$result) 
					{
						$message ="No students applied<br>";
						echo "MySQL Error: " . mysqli_error($conn);
						exit;
					}
					else
					{
						$noOfRows1=mysqli_num_rows($result);
						if($noOfRows1>0)
						{
						echo "<center><table>";
						echo "<tr><th style='background-color:skyblue'>Emp_ID</th><th style='background-color:skyblue'>Emp_Name</th>
						<th style='background-color:skyblue'>Process</th></tr>";
						while($row = mysqli_fetch_array($result)) 
						{
							echo "<tr>";
							echo "<td>".$row[0]."</td>";
							echo "<td>".$row[1]."</td>";
							echo "<form method='POST'>";
							echo "<td><button name='Process' value=".$row[0]." style='width:80px'>Process</button></td>";
							echo "</form>";
							echo "</tr>";
						}
						echo "</center></table>";
						}
						else
						{
							$message="* No Employees Applied for Equipments";
						}
					}
				}
			}
			if(!isset($_SESSION["AdminID"]))
			{
				$message="* Unauthorized Access. Admin not found";
			}
		?>
		<?php
		    if ($_SERVER["REQUEST_METHOD"] == "POST") 
			{
				if(isset($_POST['Process']))
				{
					$_SESSION["chosenRegNo"] =$_POST['Process'] ;
					header("location: statusPage2.php");
				}
			}
		?>
	
    <center><span style="color:red"><?php echo $message;?></span></center></div>
     <div style="margin-left:-50px;background-color:black;height:113px;margin-top:0px;color:orange;text-align:center;">
	     <br>
		<p >Gateway Software Solutions, Coimbatore</p>
	</div>
     
</body>
</html>