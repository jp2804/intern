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
	  <a href="RequestPage.php"><button class="tablinks" style="background-color:#ccc;">Request</button></a>
	  <a href="statusPage.php"><button class="tablinks">Status</button></a>
	  <a href="changePassword.php"><button class="tablinks">Change Password</button></a>
	  <a href="Logout.php"><button class="tablinks">Log Out</button></a>
	</div>
	
	<div class="requestContainer" style="background-color:#696969;height:410px;margin-top:-20px;">
		<?php
			$message="";
			$servername="localhost";
			$username="root";
			$serverpassword="";
			$dbname="inventory_management";
			$conn=mysqli_connect($servername,$username,$serverpassword,$dbname);
			if(isset($_SESSION["StudentID"]))
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
						$message ="No equipments available<br>";
						echo "MySQL Error: " . mysqli_error($conn);
						exit;
					}
				}
			}
			if(!isset($_SESSION["StudentID"]))
			{
				$message="* Unauthorized Access. Student not found";
			}
		?> 
		<?php
		   echo "<center><h2 style = 'margin-left:150px'>List of Components</h2></center>";
		   echo "<br>";
		   echo "<form method='POST'>";
		   echo "<center><select name='componentName'>"; // Open your drop down box 
		   while ($row = mysqli_fetch_array($result)) 
		   {
				echo '<option value="'.$row[0].'">'.$row[0].'</option>';
		   }
			echo '</select></center>';
			echo '<br>';
			echo "<center><input type='submit' value='View' name='View'></center>";
			echo "<br><br>";
		?>
		<?php
			if($conn && isset($_SESSION["StudentID"]))
			{
				if ($_SERVER["REQUEST_METHOD"] == "POST") 
				{
					if(isset($_POST['View']))
					{
						$_SESSION["chosenComponent"]=$_POST["componentName"];
						$sqlQuery="SELECT Equipment_Name, count(Equipment_Name) from availability where Equipment_Description='{$_POST["componentName"]}' group by Equipment_Name ORDER BY Equipment_Name ASC";
						$result2=mysqli_query($conn, $sqlQuery);
						echo "<center><table>";
						$noOfRows=mysqli_num_rows($result2);
						if($noOfRows>0)
						{
						echo "<tr><th>Equipment Description</th><th>Equipment Model</th><th>Availability</th><th>Submit</th></tr>";
						while ($row2 = mysqli_fetch_array($result2)) 
					    {
							echo "<tr>";
							echo "<td>".$_POST["componentName"]."</td>";
							echo "<td>".$row2[0]."</td>";
							echo "<td>";
						    echo "<form method='POST'>";
							echo "<center><select name='requestedComponent' style='width:60px'>"; // Open your drop down box 
							for($i=1;$i<=$row2[1];$i++)
							{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
							echo '</select></center>';
							echo "</td>";
							echo "<td>";
							echo "<center><button name='Apply' value=".$row2[0]." style='width:80px'>Apply</button></center>";
							echo "</td></form>";
							echo "</tr>";
						}
						echo "</table></center>";
						}
						else
						{
							$message="* Equipment not available";
						}
					}
				}
			}
		?>
		<?php
		  if ($_SERVER["REQUEST_METHOD"] == "POST") 
		  {
			if(isset($_POST['Apply']))
			{
				$message="";
				
				$RegNo=$StudentName=$ComponentID=$ComponentDesc=$ComponentName=$Date=$Time=$Status="";
				$RegNo=$_SESSION["StudentID"];
				
				$sql1="SELECT Name from employees WHERE Emp_ID='{$_SESSION["StudentID"]}'";
				$res1=mysqli_query($conn, $sql1);
				$rw1=mysqli_fetch_array($res1);
				$StudentName=$rw1[0];
				
				$ComponentName=$_POST['Apply'];
				$ComponentDesc=$_SESSION["chosenComponent"];
				
				$sql2="SELECT Equipment_ID from availability WHERE Equipment_Description='{$_SESSION["chosenComponent"]}' AND Equipment_Name='{$ComponentName}'";
				$res2=mysqli_query($conn, $sql2);
				//$rw2=mysqli_fetch_array($res2);
	
				$Quantity=$_POST["requestedComponent"];
				
				date_default_timezone_set("Asia/Calcutta");
				$Date=date("Y-m-d");
				$Time=date("h:i:sa");
				$Status="APPLIED";
				$i=0;
				$err=0;
			  while ($rw2 = mysqli_fetch_array($res2)) 
			  {
				  if($i<$Quantity)
				  {
					$ComponentID=$rw2[0];
					$sql3="INSERT INTO Status(EmpID,EmployeeName,EquipmentID,EquipmentDescription,EquipmentName,Date,Time,Status) VALUES ('".$RegNo."', '".$StudentName."', '".$ComponentID."', '".$ComponentDesc."', '".$ComponentName."', '".$Date."', '".$Time."', '".$Status."')";	
					$sql4="INSERT INTO log(EmpID,EmployeetName,EquipmentID,EquipmentDescription,EquipmentName,Date,Time,Status) VALUES ('".$RegNo."', '".$StudentName."', '".$ComponentID."', '".$ComponentDesc."', '".$ComponentName."', '".$Date."', '".$Time."', '".$Status."')";	
					if(mysqli_query($conn,$sql3) && mysqli_query($conn,$sql4))
					{
						$sql5="DELETE FROM availability WHERE Equipment_ID='{$ComponentID}'";
						mysqli_query($conn,$sql5);
					}
					else
					{
						$err++;
						echo "Error:".$sql3."<br>".mysqli_error();
					}
					$i++;
				  }
			  }
				if($err==0)
				{
					$message="*Components Applied Successfully";
				}
				else
				{
					$message="*Components not Applied Successfully";
				}
			}
		  }
		?>
		
		<?php
		    if(isset($_SESSION["StudentID"]))
			{	
				if(!$conn)
				{
					die("Connection failed:".mysqli_connect_error());
				}
				else
				{
					$getLists = "SELECT EquipmentID, EquipmentDescription, EquipmentName, Status from Status WHERE EmpID='{$_SESSION["StudentID"]}' AND Status='APPLIED' ORDER BY EquipmentID ASC";
					$result = mysqli_query($conn,$getLists);
					if (!$result) 
					{
						$message ="No components you applied<br>";
						echo "MySQL Error: " . mysqli_error($conn);
						exit;
					}
					else
					{
						$noOfRows2=mysqli_num_rows($result);
						if($noOfRows2>0)
						{
						echo "<center><h3>Applied Equipment List</h3></center>";
						echo "<center><table>";
						echo "<tr><th>Equipment ID</th><th>Equipment Description</th><th>Equipment Name</th><th>Status</th></tr>";
						while($row = mysqli_fetch_array($result)) 
						{
							echo "<tr>";
							echo "<td>".$row[0]."</td>";
							echo "<td>".$row[1]."</td>";
							echo "<td>".$row[2]."</td>";
							echo "<td>".$row[3]."</td>";
							echo "</tr>";
						}
						echo "</center></table>";
						}
					}
				}
				mysqli_close($conn);
			}
		?>
	<br>
    <center><span style="color:red"><?php echo $message;?></span></center></div>
	 <div style="margin-left:-50px;background-color:black;height:113px;margin-top:0px;color:orange;text-align:center;">
	     <br>
		<p >Gateway Software Solutions, Coimbatore</p>
	</div>
     
</body>
</html>