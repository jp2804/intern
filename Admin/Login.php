<!DOCTYPE html>
<html lang="en">
<head>
<title>Login</title>
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
        width: 90%;
    }
}
</style>
<link rel="stylesheet" href="../css/LoginCSS.css">
</head>
<body>
	<?php
		session_start();
		if(isset($_SESSION["AdminID"]))
		{
		   unset($_SESSION["AdminID"]);
		}
		$servername="localhost";
	    $username="root";
	    $serverpassword="";
        $dbname="inventory_management";
		$error="";
		$errcount=0;
		$conn=mysqli_connect($servername,$username,$serverpassword,$dbname);
		
		if($_SERVER["REQUEST_METHOD"] == "POST") 
		{
		   $adminID=$_POST["AdminID"];
		   $adminPassword=$_POST["password"];
		   
		   if (isset($_POST['adminLogin']))
			{
				$sql="SELECT * FROM admins WHERE emp_id='$adminID' and password='$adminPassword'";
				$result=mysqli_query($conn,$sql);
				$count=mysqli_num_rows($result);
				if($count == 1) 
				{
					$_SESSION["AdminID"] = $adminID;
					header("location: statusPage.php");
				}
				else 
				{
					$error = " *Invalid credentials !";
				}
			}
		}
	?>
	
	<div class="header" style="background-color: black;color:orange;height:100px">
     	<div style="background-color: black;height:90px;width:180px;">
		 <img src="resources/logo.png" />
		</div>
	
		<h3 style="margin-top:-40px">Gateway Software Solutions </h3>
	</div>
	

	<div style = "background-color:#696969;margin-top:0px;height:400px;overflow-y: auto;" >
	  <form method="POST">
	       <br><br>
		  <h2 style="text-align:center">Admin Login</h2>
			<br><br>
			<center>
		  <div class="col" >
			<input type="text" name="AdminID" placeholder="Admin ID" required>
			<br>
			<input type="password" name="password" placeholder="Password" required>
			<br>
			<input type="submit" value="Login" name="adminLogin" style="margin-left:10px;background-color:black">
		  </div>
		  </center>
	   </form>
	   <center><span style="color:red"><?php echo "$error";?></span></center>
	  <br>
    </div>
	<div style="margin-left:-20px;background-color:black;height:113px;margin-top:-20px;color:orange;text-align:center">
	     <br>
		<p>Gateway Software Solutions, Coimbatore</p>
	</div>
	
</body>
</html>