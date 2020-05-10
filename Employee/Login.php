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
        width: 100%;
    }
}
</style>
<link rel="stylesheet" href="../css/LoginCSS.css">
</head>
<body>
	<?php
		session_start();
		if(isset($_SESSION["StudentID"]))
		{
		   unset($_SESSION["StudentID"]);
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
		   $regNo=$_POST["Emp_ID"];
		   $studentPassword=$_POST["password"];
		   
		   if (isset($_POST['loginSubmit']))
			{
				$sql="SELECT * FROM employees WHERE Emp_ID='$regNo' and Password='$studentPassword'";
				$result=mysqli_query($conn,$sql);
				$count = mysqli_num_rows($result);
				if($count == 1) 
				{
					$_SESSION["StudentID"] = $regNo;
					header("location: RequestPage.php");
				}
				else 
				{
					$error = " *Invalid credentials !";
				}
			}
		}
	?>
    
	<div class="header" style="background-color: black;color:orange;height:120px">
     	<div style="background-color: black;height:90px;width:180px;">
		 <img src="resources/logo.png" />
		</div>
	
		<h3 style="margin-top:-40px">Gateway Software Solutions </h3>
	</div>
	

	<div  style = "background-color:#696969;margin-top:0px;height:400px;margin-top:-20px;overflow-y: auto;">
	  <form method="POST">
	   <br><br>
		  <center><h2>Employee Login</h2></center>
			 <br><br>
		 <center><div class="col">
			<input type="text" name="Emp_ID" placeholder="Emp_ID" required>
			<br>
			<input type="password" name="password" placeholder="Password" required>
			<br>
			<input type="submit" value="Login" name="loginSubmit" style="margin-left:10px;background-color:black">
		  </div><center>
	   </form>
	   <center><span style="color:red"><?php echo "$error";?></span></center>
	  <br>
	  
	  <center><a href="Signup.php" style = "padding-left:20px;color:skyblue">Create an account</a></center>
	  
    </div>
	<div style="margin-left:-20px;background-color:black;height:113px;margin-top:-20px;color:orange;text-align:center">
	     <br>
		<p>Gateway Software Solutions, Coimbatore</p>
	</div>
	
</body>
</html>