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
	  <a href="viewemployees.php"><button class="tablinks">Student Details</button></a>
	  <a href="Logout.php"><button class="tablinks">Log Out</button></a>
	</div>

	<div class="requestContainer" style="background-color:#696969;height:410px;width:1200px;margin-top:00px;margin-left:190px;">
	<br>
	   <?php
			session_start();
			$servername="localhost";
			$username="root";
			$serverpassword="";
			$dbname="inventory_management";
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
					if (isset($_SESSION["chosenRegNo"])) 
					{
						$sql1="SELECT * FROM Status WHERE EmpID='{$_SESSION['chosenRegNo']}' AND Status!='CANCELLED' AND Status!='REJECTED' AND Status!='RETURNED' ORDER BY Status ASC";
						$result1= mysqli_query($conn,$sql1);
						if (!$result1) 
						{
							echo "MySQL Error: " . mysqli_error($conn);
							exit;
						}
						else
						{
							$sql2="SELECT Emp_ID, Name FROM employees WHERE  Emp_ID='{$_SESSION['chosenRegNo']}'";
							$result2= mysqli_query($conn,$sql2);
							$row2= mysqli_fetch_array($result2);
							echo "<center><h3 >Name:".$row2[1]."</h3></center>";
							echo "<center><h3>Emp_ID:".$row2[0]."</h3></center>";
							echo "<center><table>";
							echo "<tr><th style='background-color:skyblue'>Equipment ID</th>
							<th style='background-color:skyblue'>Equipment Description</th>
							<th style='background-color:skyblue'>Equipment Name</th>
							<th style='background-color:skyblue'>Date</th>
							<th style='background-color:skyblue'>Time</th>
							<th style='background-color:skyblue'>Status</th>
							<th style='background-color:skyblue'>Process</th></tr>";
							while($row1 = mysqli_fetch_array($result1)) 
							{
								echo "<tr>";
								echo "<td>".$row1[2]."</td>";
								echo "<td>".$row1[1]."</td>";
								echo "<td>".$row1[3]."</td>";
								echo "<td>".$row1[0]."</td>";
								echo "<td>".$row1[7]."</td>";
								echo "<td>".$row1[5]."</td>";
								$status=$row1[5];
								if($status=="APPLIED")
								{
									echo "<form method='POST'>";
									echo "<td><button name='Approve' value=".$row1[2]." style='width:80px'>Approve</button><button name='Reject' value=".$row1[2]." style='width:80px'>Reject</button></td>";
									echo "</form>";
								}
								else if($status=="APPROVED")
								{
									echo "<form method='POST'>";
									echo "<td><center><button name='Receive' value=".$row1[2]." style='width:80px'>Receive</button></center></td>";
									echo "</form>";
								}
								else if($status=="RECEIVED")
								{
									echo "<form method='POST'>";
									echo "<td><center><button name='Return' value=".$row1[2]." style='width:80px'>Return</button></center></td>";
									echo "</form>";
								}
								echo "</tr>";
							}
							echo "</center></table>";
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
		    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["AdminID"])) 
			{
				if(isset($_POST['Approve']))
				{
					$equipementId=$_POST['Approve'];
					$sql3="SELECT * FROM Status WHERE Status='APPLIED' AND EquipmentID='{$equipementId}'";
					$result3= mysqli_query($conn,$sql3);
					if (!$result3) 
					{
						echo "MySQL Error: " . mysqli_error($conn);
						exit;
					}
					else
					{
					  $row3 = mysqli_fetch_array($result3);
					  $RegNo=$row3[4];
					  $StudentName=$row3[6];
					  $componentID=$row3[2];
					  $ComponentDesc=$row3[1];
					  $ComponentName=$row3[3];
					  date_default_timezone_set("Asia/Calcutta");
					  $Date=date("Y-m-d");
					  $Time=date("h:i:sa");
					  $status="APPROVED";
					  
					 
					  
					  $sql4="UPDATE Status set Status='$status', Date='$Date', Time='$Time' WHERE Status='APPLIED' AND EquipmentID='{$componentID}'";
					  if(mysqli_query($conn,$sql4))
					  {
						  $sql5="INSERT INTO log(EmpID,StudentName,EquipmentID,EquipmentDescription,EquipmentName,Date,Time,Status) VALUES ('".$RegNo."', '".$StudentName."', '".$componentID."', '".$ComponentDesc."', '".$ComponentName."', '".$Date."', '".$Time."', '".$status."')";	
                          mysqli_query($conn, $sql5);
						  header("Location:statusPage2.php");
					  }
					  else
					  {
						 echo "Error:".$sql4."<br>".mysqli_error();
					  }
					}
				}
				else if(isset($_POST['Reject']))
				{
					$componentID=$_POST['Reject'];
					$sql1="SELECT * FROM Status WHERE Status='APPLIED' AND EquipmentID='{$componentID}'";
					$result1= mysqli_query($conn,$sql1);
					if (!$result1) 
					{
						echo "MySQL Error: " . mysqli_error($conn);
						exit;
					}
					else
					{
					  $row1=mysqli_fetch_array($result1);
					  $RegNo=$row1[4];
					  $StudentName=$row1[6];
					  $componentID=$row1[2];
					  $ComponentDesc=$row1[1];
					  $ComponentName=$row1[3];
					  date_default_timezone_set("Asia/Calcutta");
					  $Date=date("Y-m-d");
					  $Time=date("h:i:sa");
					  $status="REJECTED";
					  
					  $sql2="INSERT INTO availability(Equipment_Name,Equipment_Description,Equipment_ID) VALUES ('".$ComponentName."','".$ComponentDesc."','".$componentID."')";	
					  if(mysqli_query($conn,$sql2))
						{
							$sql3="UPDATE Status set Status='$status', Date='$Date', Time='$Time' WHERE Status='APPLIED' AND EquipmentID='{$componentID}'";
							if(mysqli_query($conn,$sql3))
							{	
								$sql4="INSERT INTO log(EmpID,StudentName,EquipmentID,EquipmentDescription,EquipmentName,Date,Time,Status) VALUES ('".$RegNo."', '".$StudentName."', '".$componentID."', '".$ComponentDesc."', '".$ComponentName."', '".$Date."', '".$Time."', '".$status."')";	
								mysqli_query($conn, $sql4);
								header("Location:statusPage2.php");
							}
							else
							{
								echo "Error:".$sql3."<br>".mysqli_error();
							}
						}
						else
						{
							echo "Error:".$sql2."<br>".mysqli_error();
						}
					}
				}
				else if(isset($_POST['Receive']))
				{
					$componentID=$_POST['Receive'];
					$sql1="SELECT * FROM Status WHERE Status='APPROVED' AND EquipmentID='{$componentID}'";
					$result1= mysqli_query($conn,$sql1);
					if (!$result1) 
					{
						echo "MySQL Error: " . mysqli_error($conn);
						exit;
					}
					else
					{
					  $row1=mysqli_fetch_array($result1);
					  $RegNo=$row1[4];
					  $StudentName=$row1[6];
					  $componentID=$row1[2];
					  $ComponentDesc=$row1[1];
					  $ComponentName=$row1[3];
					  date_default_timezone_set("Asia/Calcutta");
					  $Date=date("Y-m-d");
					  $Time=date("h:i:sa");
					  $status="RECEIVED";
					  
					  $sql2="UPDATE Status set Status='$status', Date='$Date', Time='$Time' WHERE Status='APPROVED' AND EquipmentID='{$componentID}'";
					  if(mysqli_query($conn,$sql2))
					  {	
						$sql3="INSERT INTO log(EmpID,StudentName,EquipmentID,EquipmentDescription,EquipmentName,Date,Time,Status) VALUES ('".$RegNo."', '".$StudentName."', '".$componentID."', '".$ComponentDesc."', '".$ComponentName."', '".$Date."', '".$Time."', '".$status."')";	
						mysqli_query($conn, $sql3);
						header("Location:statusPage2.php");
					  }
					  else
					  {
					 	echo "Error:".$sql2."<br>".mysqli_error();
					  }
					}
				}
				
				else if(isset($_POST['Return']))
				{
					$componentID=$_POST['Return'];
					$sql1="SELECT * FROM Status WHERE Status='RECEIVED' AND EquipmentID='{$componentID}'";
					$result1= mysqli_query($conn,$sql1);
					if (!$result1) 
					{
						echo "MySQL Error: " . mysqli_error($conn);
						exit;
					}
					else
					{
					  $row1=mysqli_fetch_array($result1);
					  $RegNo=$row1[4];
					  $StudentName=$row1[6];
					  $componentID=$row1[2];
					  $ComponentDesc=$row1[1];
					  $ComponentName=$row1[3];
					  date_default_timezone_set("Asia/Calcutta");
					  $Date=date("Y-m-d");
					  $Time=date("h:i:sa");
					  $status="RETURNED";
					  
					  $sql2="INSERT INTO availability(Equipment_Name,Equipment_Description,Equipment_ID) VALUES ('".$ComponentName."','".$ComponentDesc."','".$componentID."')";	
					  if(mysqli_query($conn,$sql2))
						{
							$sql3="UPDATE Status set Status='$status', Date='$Date', Time='$Time' WHERE Status='RECEIVED' AND EquipmentID='{$componentID}'";
							if(mysqli_query($conn,$sql3))
							{	
								$sql4="INSERT INTO log(EmpID,StudentName,EquipmentID,EquipmentDescription,EquipmentName,Date,Time,Status) VALUES ('".$RegNo."', '".$StudentName."', '".$componentID."', '".$ComponentDesc."', '".$ComponentName."', '".$Date."', '".$Time."', '".$status."')";	
								mysqli_query($conn, $sql4);
								header("Location:statusPage2.php");
							}
							else
							{
								echo "Error:".$sql3."<br>".mysqli_error();
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
	</div>
    <center><span style="color:red"><?php echo $message;?></span></center>
	 <div style="margin-left:-50px;background-color:black;height:113px;margin-top:0px;color:orange;text-align:center;">
	     <br>
		<p >Gateway Software Solutions, Coimbatore</p>
	</div>
     
</body>
</html>