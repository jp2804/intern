<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Report Generation</title>
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
		select
		{
			width: auto;
		}
		table
		{
			width: 50%;
			margin-left:1.5em;
			font-size: 15px;
		}
		table tr td
		{
			width: auto;
		}
		input[type=date]
		{
		  width: auto;
		  padding: 12px;
		  border: none;
		  border-radius: 4px;
		  margin: 5px 0px 5px 0px;
		  opacity: 0.85;
		  font-size: 17px;
		  line-height: 20px;
		  text-decoration: none; 
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
	  <a href="modifyComponent.php"><button class="tablinks">Modify Equipment</button></a>
	  <a href="reportGenaration.php"><button class="tablinks" style="background-color:#ccc">Report Generation</button></a>
	  <a href="viewemployees.php"><button class="tablinks">Employee Details</button></a>
	  <a href="Logout.php"><button class="tablinks">Log Out</button></a>
	</div>
	
	<div class="requestContainer" style="background-color:#696969;margin-top:-20px;height:410px;">
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
					$getStudentsRegNo = "SELECT Emp_ID FROM  employees ORDER BY Emp_ID ASC";
					$getStudentsName = "SELECT Name FROM employees ORDER BY Name ASC";
					$getComponentDesc="SELECT DISTINCT Equipment_Description FROM components ORDER BY Equipment_Description ASC";
					$getComponentName="SELECT DISTINCT Equipment_Name FROM components ORDER BY Equipment_Name ASC";
					$getComponentID="SELECT DISTINCT Equipment_ID FROM components ORDER BY Equipment_ID ASC";
					$getStatus="SELECT DISTINCT Status FROM log ORDER BY Status ASC";
					$result1 = mysqli_query($conn,$getStudentsRegNo);
					$result2 = mysqli_query($conn,$getStudentsName);
					$result3 = mysqli_query($conn,$getComponentDesc);
					$result4 = mysqli_query($conn,$getComponentName);
					$result5 = mysqli_query($conn,$getComponentID);
					$result6 = mysqli_query($conn,$getStatus);
					if (!$result1) 
					{
						$error ="No students available<br>";
						echo "MySQL Error: " . mysqli_error($conn);
						exit;
					}
					if (!$result2) 
					{
						$error ="No students available<br>";
						echo "MySQL Error: " . mysqli_error($conn);
						exit;
					}
					if (!$result3) 
					{
						$error ="No component description available<br>";
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
		   
		   echo "<center><h2>Report Generation</h2></center>";
		   echo "<center><form method='POST'><table>";
		   echo "<tr><th style = 'background-color:skyblue'>Emp_ID</th><th style = 'background-color:skyblue'>Name</th>
		   <th style = 'background-color:skyblue'>Equipment Description</th><th style = 'background-color:skyblue'>Equipment Name</th>
		   <th  style = 'background-color:skyblue'>Equipment ID</th><th style = 'background-color:skyblue'>Status</th></tr>";
		   echo "<tr>";
		   
		   echo "<td>";
		   echo "<select name='studentRegNo' style='width:auto;font-size:12px'>"; 
		   echo "<option value=''>select</option>";
		   while ($row1 = mysqli_fetch_array($result1)) 
		   {
				echo '<option value="'.$row1[0].'">'.$row1[0].'</option>';
		   }
		   echo '</select>';
		   echo "</td>";
		   
		   echo "<td>";
		   echo "<select name='studentName' style='width:auto;font-size:12px'>"; 
		   echo "<option value=''>select</option>";
		   while ($row2 = mysqli_fetch_array($result2)) 
		   {
				echo '<option value="'.$row2[0].'">'.$row2[0].'</option>';
		   }
			echo '</select>';
		   echo "</td>";
		   
		   echo "<td>";
		   echo "<select name='componentDescription' style='width:auto;font-size:12px'>"; 
		   echo "<option value=''>select</option>";
		   while ($row3 = mysqli_fetch_array($result3)) 
		   {
				echo '<option value="'.$row3[0].'">'.$row3[0].'</option>';
		   }
		   
		   echo "<td>";
		   echo "<select name='componentType' style='width:auto;font-size:12px'>"; 
		   echo "<option value=''>select</option>";
		   while ($row4 = mysqli_fetch_array($result4)) 
		   {
				echo '<option value="'.$row4[0].'">'.$row4[0].'</option>';
		   }
		   echo '</select>';
		   echo "</td>";
		   
		   echo "<td>";
		   echo "<select name='componentID' style='width:auto;font-size:12px'>"; 
		   echo "<option value=''>select</option>";
		   while ($row5 = mysqli_fetch_array($result5)) 
		   {
				echo '<option value="'.$row5[0].'">'.$row5[0].'</option>';
		   }
			echo '</select>';
		   echo "</td>";
		   
		   echo "<td>";
		   echo "<select name='status' style='width:auto;font-size:12px'>"; 
		   echo "<option value=''>select</option>";
		   while ($row6 = mysqli_fetch_array($result6)) 
		   {
				echo '<option value="'.$row6[0].'">'.$row6[0].'</option>';
		   }
			echo '</select>';
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			echo '<br>';
			echo "<table>";
			echo "<tr><th  style = 'background-color:skyblue'>From Date</th>
			<th  style = 'background-color:skyblue'>To Date</th></tr>";
			echo "<tr>";
			echo "<td><input type='date' name='fromDate'></td>";
			echo "<td><input type='date' name='toDate'></td>";
			echo "</tr>";
			echo "</table>";
			echo "<center><input type='submit' value='Generate' name='Generate' style='width:auto;background-color:black'>";
			//echo "<a href='ReportGeneration/reportGenaration2.php'><input type='submit' value='Download Excel' name='GenerateExcel' style='width:auto'></a></center>"; 

			echo "</form></center>";
			
			echo "<br><br>";
		?>
		<?php
		  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["AdminID"])) 
		  {
			if(isset($_POST['Generate']))
			{
				$regNo=$name=$equipmentDesc=$equipmentName=$equipmentID=$status="";
				$regNo=$_POST['studentRegNo'];
				$name=$_POST['studentName'];
				$equipmentDesc=$_POST['componentDescription'];
				$equipmentName=$_POST['componentType'];
				$equipmentID=$_POST['componentID'];
				$status=$_POST['status'];
				
				$array1=array('studentRegNo','studentName','componentDescription','componentType','componentID','status','fromDate','toDate');
				$array2=array('RegNo','StudentName','EquipmentDescription','EquipmentName','EquipmentID','Status','Date','Date');
				$i=0;
				$sql="SELECT * FROM log WHERE";
				
				while($i<count($array1))
				{
					//echo $array[$i];
					$var=$_POST[$array1[$i]];
					if($var!="")
					{
							if($array1[$i]=='fromDate')
							{
								$sql=$sql." ".$array2[$i].">="." '".$var."' AND";
							}
							else if($array1[$i]=='toDate')
							{
								$sql=$sql." ".$array2[$i]."<="." '".$var."' AND";
							}
							else
							{
							   $sql=$sql." ".$array2[$i]."="." '".$var."' AND";
							}
					}
					$i++;
				}
				$sql=substr($sql, 0, -3);
				
				  $result=mysqli_query($conn, $sql);
				  $numofRows=mysqli_num_rows($result);
				  if($numofRows>0)
				  {
					$_SESSION["ReportGeneration"]=$sql;
				   echo "<center><table>";
				   echo "<tr><th>RegNo</th><th>StudentName</th><th>EquipmentID</th><th>Equipment Description</th><th>EquipmentName</th><th>Date</th><th>Time</th><th>Status</th></tr>";
				   while($row=mysqli_fetch_array($result))
			       {
				    echo "<tr>";
				    echo "<td>".$row[0]."</td>";
				    echo "<td>".$row[1]."</td>";
				    echo "<td>".$row[2]."</td>";
				    echo "<td>".$row[3]."</td>";
				    echo "<td>".$row[4]."</td>";
				    echo "<td>".$row[5]."</td>";
				    echo "<td>".$row[6]."</td>";
				    echo "<td>".$row[7]."</td>";
				    echo "</tr>";
			       }
				   echo "</table></center>";
				   echo "<a href='ReportGeneration/reportGenaration2.php'><button style='width:auto'>Download Excel</button></a>";
				   echo "<br><br>";
				  }
				  else
				  {
					  $message="* No suitable records found";
				  }
			}
		}
	   ?>
		<center><span style="color:red;margin-top:-400px"><?php echo $message;?></span></center>
	</div>
   <div style="margin-left:-50px;background-color:black;height:113px;margin-top:0px;color:orange;text-align:center;">
	     <br>
		<p >Gateway Software Solutions, Coimbatore</p>
	</div>
</body>
</html>