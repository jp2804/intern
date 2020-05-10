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

	<div class="tab" style="height:410px">
	  <a href="statusPage.php"><button class="tablinks">Status</button></a>
	  <a href="addComponent.php"><button class="tablinks">Add Equipment</button></a>
	  <a href="modifyComponent.php"><button class="tablinks">Modify Equipment</button></a>
      <a href="reportGenaration.php"><button class="tablinks">Report Generation</button></a>	 
	 <a href="viewemployees.php"><button class="tablinks" style="background-color:#ccc">Employee Details</button></a>
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
					$getStudents = "SELECT Emp_ID from employees ORDER BY Emp_ID ASC";
					$result = mysqli_query($conn,$getStudents);
					if (!$result) 
					{
						$error ="No Employees available<br>";
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
		   echo "<center><h2>Information of Employees</h2></center>";
		   echo "<br>";
		   echo "<form method='POST'>";
		   echo "<center><select name='studentName'>"; // Open your drop down box 
		   while ($row = mysqli_fetch_array($result)) 
		   {
				echo '<option value="'.$row[0].'">'.$row[0].'</option>';
		   }
			echo '</select></center>';
			echo '<br>';
			echo "<center><input type='submit' style = 'background-color:black' value='View' name='View'></center>";
			echo "</form>";
			echo "<br><br>";
		?>
		<?php
		  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["AdminID"])) 
		  {
			if(isset($_POST['View']))
			{
				$name=$gender=$age=$branch=$email=$mobile="";
				$selectedRegNo=$_POST['studentName'];
		        $sql1="SELECT Name, Gender, Email, Mobile FROM employees WHERE Emp_ID='{$selectedRegNo}'";
			    $result=mysqli_query($conn, $sql1);
				 while($row=mysqli_fetch_array($result))
			     {
				   $name=$row[0];
				   $gender=$row[1];
				   $email=$row[2];
				   $mobile=$row[3];
			     }
				 echo "<center><table>";
				  echo "<tr><th style = 'background-color:skyblue'>Employee Name</th><td>".$name."</td><tr>";
				  echo "<tr><th style = 'background-color:skyblue'>Employee ID</th><td>".$selectedRegNo."</td><tr>";
				  echo "<tr><th style = 'background-color:skyblue'>Employee Gender</th><td>".$gender."</td><tr>";
				  echo "<tr><th style = 'background-color:skyblue'>Employee Email</th><td>".$email."</td><tr>";
				  echo "<tr><th style = 'background-color:skyblue'>Employee Mobile Number</th><td>".$mobile."</td><tr>";
				 echo "</table></center>";
				 echo "<br><br>";
			}
			mysqli_close($conn);
		  }
		?>
	
    <center><span style="color:red"><?php echo $message;?></span></center></div></div>
	 <div style="margin-left:-50px;background-color:black;height:113px;margin-top:400px;color:orange;text-align:center;">
	     <br>
		<p >Gateway Software Solutions, Coimbatore</p>
	</div>
	</div>
     
</body>
</html>