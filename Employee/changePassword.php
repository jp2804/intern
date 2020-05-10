<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Change Password</title>
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
		if(isset($_SESSION["StudentID"]))
		{
			$servername="localhost";
			$username="root";
			$serverpassword="";
			$dbname="inventory_management";
			$error="";
			$count=0;
			$conn=mysqli_connect($servername,$username,$serverpassword,$dbname);
	
			if(!$conn)
			{
				die("Connection failed:".mysqli_connect_error());
			}
			else
			{
				 $sqlQuery = "SELECT Password FROM employees WHERE Emp_ID='{$_SESSION["StudentID"]}'";
				 $result=mysqli_query($conn, $sqlQuery);
				 $row=mysqli_fetch_array($result);
			}
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") 
			{
				$oldPassword=$_POST["oldPassword"];
				$newPassword=$_POST["newPassword"];
				$reTypePassword=$_POST["reTypePassword"];
				$pass_pat="/^[a-zA-Z0-9.,@#%&^$*_+-]{8,20}$/";
				if($oldPassword!=$row[0])
				{
					$error="*Current password is invalid. Try again!";
					$count++;
				}
				else if(!preg_match($pass_pat,$newPassword)) 
				{
					 $error="*Password length should be between 8 to 20.";
					 $count++;
				}
				else if($newPassword!=$reTypePassword)
				{
					$error="*Password does not match";
					$count++;
				}
				
				if (isset($_POST['changePassSubmit']))
				{
					if($count==0)
					{
						$sql="UPDATE students set Password='$newPassword' WHERE RegNo='{$_SESSION["StudentID"]}'";
						if(mysqli_query($conn,$sql))
						{ 
							$error="*Password Updated successfully";
						}
						else
						{
							$error="* Something wrong.";
						}
					}
				}
			}
		}
		if(!isset($_SESSION["StudentID"]))
		{
			$error="* Unauthorized Access. Student not found";
		}
	?>

	
	<div class="header" style="background-color: black;color:orange;height:120px;text-align:center">
     	<div style="background-color: black;height:90px;width:180px;">
		 <img src="resources/logo.png" />
		</div>
	
		<h3 style="margin-top:-40px">Gateway Software Solutions </h3>
	</div>
	  <div class="header2">
	     <?php
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
	  <a href="statusPage.php"><button class="tablinks">Status</button></a>
	  <a href="changePassword.php"><button class="tablinks" style="background-color:#ccc">Change Password</button></a>
	  <a href="Logout.php"><button class="tablinks">Log Out</button></a>
	</div>

	<div class="requestContainer" style="background-color:#696969;height:410px;margin-top:-20px;">
	 <h2><br></h2>
		<center><h2 style="margin-left:0px">Update Password</h2></center>
		<center><form method="POST">
			<input type="password" name="oldPassword" placeholder="Old Password" required><br><br>
			<input type="password" name="newPassword" placeholder="New Password" required><br><br>
			<input type="password" name="reTypePassword" placeholder="Re type Password" required><br><br>
			<input type="submit" value="Change Password" name="changePassSubmit"><br><br>
			<span style="color:red"> <?php echo $error;?></span>
		</form></center>
	</div>
	 <div style="margin-left:-50px;background-color:black;height:113px;margin-top:0px;color:orange;text-align:center;">
	     <br>
		<p >Gateway Software Solutions, Coimbatore</p>
	</div>
     
</body>
</html>