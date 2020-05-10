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
	  <div class="header2">
	     <?php
		 session_start();
		if(isset($_SESSION["StudentID"]))
		{			
			echo $_SESSION['StudentID']."(Employee)";
		}
		else
		{
			echo "Not authorized";
		}
		?>
		<br>
	  </div>
	</div>

	<div class="tab" style="height:410px">
	  <a href="RequestPage.php"><button class="tablinks">Request</button></a>
	  <a href="statusPage.php"><button class="tablinks" style="background-color:#ccc">Status</button></a>
	  <a href="changePassword.php"><button class="tablinks">Change Password</button></a>
	  <a href="Logout.php"><button class="tablinks">Log Out</button></a>
	

	<div class="requestContainer" style="background-color:#696969;margin-top:-257px;height:410px;width:1075px;margin-left:190px;overflow-y: auto;"">
	<br>
	   <?php
			$servername="localhost";
			$username="root";
			$serverpassword="";
			$dbname="inventory_management";
			$message="";
			$conn=mysqli_connect($servername,$username,$serverpassword,$dbname);
			if(isset($_SESSION["StudentID"]))
			{	
				if(!$conn)
				{
					die("Connection failed:".mysqli_connect_error());
				}
				else
				{
					$getLists = "SELECT EquipmentID, EquipmentDescription, EquipmentName, Date, Time, Status from Status WHERE EmpID='{$_SESSION["StudentID"]}' AND Status!='CANCELLED' AND Status!='RETURNED' ORDER BY Status ASC";
					$result = mysqli_query($conn,$getLists);
					if (!$result) 
					{
						$message ="No components you applied<br>";
						echo "MySQL Error: " . mysqli_error($conn);
						exit;
					}
					else
					{
					$noOfRows=mysqli_num_rows($result);
					if($noOfRows>0)
					{
						echo "<center><table>";
						echo "<tr><th style = 'background-color:skyblue'>Equipment ID</th>
						<th style = 'background-color:skyblue'>Equipment Description</th>
						<th style = 'background-color:skyblue'>Equipment Name</th>
						<th style = 'background-color:skyblue'>Date</th>
						<th style = 'background-color:skyblue'>Time</th>
						<th style = 'background-color:skyblue'>Status</th>
						<th style = 'background-color:skyblue'>Cancel</th></tr>";
						while($row = mysqli_fetch_array($result)) 
						{
							echo "<tr>";
							echo "<td>".$row[0]."</td>";
							echo "<td>".$row[1]."</td>";
							echo "<td>".$row[2]."</td>";
							echo "<td>".$row[3]."</td>";
							echo "<td>".$row[4]."</td>";
							echo "<td>".$row[5]."</td>";
							if($row[5]=="APPLIED")
							{
							echo "<form method='POST'>";
							echo "<td><button name='Cancel' value=".$row[0]." style='width:80px;background-color:skyblue;color:white;'>Cancel</button></td>";
							echo "</form>";
							}
							else
							{
								echo "<td></td>";
							}
							echo "</tr>";
						}
						echo "</center></table>";
					}
					else
					{
						$message="You didn't applied for any equipments";
					}
					}
				}
			}
			if(!isset($_SESSION["StudentID"]))
			{
				$message="* Unauthorized Access. Student not found";
			}
		?>
		<?php
		    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["StudentID"])) 
			{
				if(isset($_POST['Cancel']))
				{
					$componentID=$_POST['Cancel'];
					$sql1="SELECT Equipment_Name, Equipment_Description FROM components WHERE Equipment_ID='{$componentID}'";
					$result1= mysqli_query($conn,$sql1);
					if (!$result) 
					{
						echo "MySQL Error: " . mysqli_error($conn);
						exit;
					}
					else
					{
					  $row1 = mysqli_fetch_array($result1);
					  $sql2="INSERT INTO availability(Equipment_Name,Equipment_Description,Equipment_ID) VALUES ('".$row1[0]."','".$row1[1]."','".$componentID."')";	
					  if(mysqli_query($conn,$sql2))
						{
							$status="CANCELLED";
							$sql4="UPDATE Status set Status='$status' WHERE EquipmentID='{$componentID}'";
							if(mysqli_query($conn,$sql4))
							{
								$RegNo=$_SESSION["StudentID"];
								
								$sql5="SELECT Name from employees WHERE Emp_ID='{$_SESSION["StudentID"]}'";
								$res5=mysqli_query($conn, $sql5);
								$rw5=mysqli_fetch_array($res5);
								$StudentName=$rw5[0];
								
								$sql6="SELECT Equipment_Description, Equipment_Name from components WHERE Equipment_ID='{$componentID}'";
								$res6=mysqli_query($conn, $sql6);
								$rw6=mysqli_fetch_array($res6);
								$ComponentDesc=$rw6[0];
								$ComponentName=$rw6[1];
								
								date_default_timezone_set("Asia/Calcutta");
								$Date=date("Y-m-d");
								$Time=date("h:i:sa");
				
								$sql7="INSERT INTO log(EmpID,EmployeeName,EquipmentID,EquipmentDescription,EquipmentName,Date,Time,Status) VALUES ('".$RegNo."', '".$StudentName."', '".$componentID."', '".$ComponentDesc."', '".$ComponentName."', '".$Date."', '".$Time."', '".$status."')";	
								mysqli_query($conn, $sql7);
								header("Location:statusPage.php");
							}
							else
							{
								echo "Error:".$sql4."<br>".mysqli_error();
							}
						}
						else
						{
							echo "Error:".$sql2."<br>".mysqli_error();
						}
					}
				}
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