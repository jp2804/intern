<!DOCTYPE html>
<html lang="en">
<head>
<title>Sign Up</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="javascript/script.js"></script>
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
		$servername="localhost";
	    $username="root";
	    $serverpassword="";
        $dbname="inventory_management";
		$nameErr=$regNoErr=$genderErr=$emailErr=$mobileErr=$passErr=$rePassErr="";
		$existsErr="";
		$name=$regNo=$age=$email=$mobile="";
		$count=0;
		if($_SERVER["REQUEST_METHOD"] == "POST") 
		{
		   $name=$_POST["StudentName"];
		   $regNo=$_POST["RegisterNo"];
		   $gender=$_POST["gender"];
		   $email=$_POST["Email"];
		   $mobile=$_POST["MobileNo"];
		   $password=$_POST["Password"];
		   $repassword=$_POST["RePassword"];
		   
		   $name_pat1="/^[A-Z]{1}[a-z]+[ ]{0,1}[A-Z]*[a-z]*$/";
		   $name_pat2="/^[A-Z]+[ ]{0,1}[A-Z]*$/";
		   $ID_pat="/^[1-9][0-9][A-Z]{3}[0-9]{4}$/";
		   $email_pat="/^[a-zA-Z0-9_.]+@[a-z]+[.][a-z]+$/";
		   $mobile_pat="/^[0-9]{10}$/";
		   $pass_pat="/^[a-zA-Z0-9.,@#%&^$*_+-]{8,20}$/";
		   
		   if(!(preg_match($name_pat1,$name) || preg_match($name_pat2,$name))) 
		   {
			 $nameErr="*Enter your correct name.";
			 $name="";
			 $count++;
		   }
		  
		   if(!preg_match($email_pat,$email)) 
		   {
			 $emailErr="*Invalid email.";
			 $email="";
			 $count++;
		   }
		   if(!preg_match($mobile_pat,$mobile)) 
		   {
			 $mobileErr="*Invalid mobile number.";
			 $mobile="";
			 $count++;
		   }
		   if(!preg_match($pass_pat,$password)) 
		   {
			 $passErr="*Password length should be between 8 to 20.";
			 $password="";
			 $count++;
		   }
		   if($repassword!=$password)
		   {
			  $rePassErr="*Password does not match";
			  $password="";
			  $count++;
		   }
		   
		   if(isset($_POST['signUpSubmit']))
		   {
			   if($count==0)
			   {
				  $conn=mysqli_connect($servername,$username,$serverpassword,$dbname);
				  if(!$conn)
				  {
					die("Connection failed:".mysqli_connect_error());
				  }
				  else
				  {
					  $sql="INSERT INTO employees(Name,Emp_ID,Gender,Email,Mobile,Password) VALUES ('".$name."', '".$regNo."', '".$gender."', '".$email."', '".$mobile."', '".$password."')";	
				      if(mysqli_query($conn,$sql))
					  {
						header("Location:Login.php");
					  }
					  else
					  {
						$existsErr="Student already exists";
						echo "Error:".$sql."<br>".mysqli_error();
					  }
				  }
				  mysqli_close($conn);
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
	<div class="container" style = "background-color:#696969;margin-left:-20px;width:1245px;overflow-y: auto;">
	 <form method="POST" style="width:100%">
		  <h2 style="text-align:center">Sign-Up</h2>
		 <center> <div class="col">
		    <input type="text" name="StudentName" placeholder="Name" value="<?php echo $name;?>" required> 
			<span style="color:red"> <?php echo $nameErr;?></span>
			<br>
			<input type="text" name="RegisterNo" placeholder="Employee ID" value="<?php echo $regNo;?>" required>
			<span style="color:red"> <?php echo $regNoErr;?></span>
			<br>
			<span id="Genradio"><b>Gender:</b> <input type="radio" name="gender" value="Male" checked>Male
			<input type="radio" name="gender" value="Female">Female</span>
			<span style="color:red"> <?php echo $genderErr;?></span>
			<br>
			<input type="text" name="Email" placeholder="Email Id" value="<?php echo $email;?>" required>
			<span style="color:red"> <?php echo $emailErr;?></span>
			<br>
			<input type="text" name="MobileNo" placeholder="Mobile Number" value="<?php echo $mobile;?>" required>
			<span style="color:red"> <?php echo $mobileErr;?></span>
			<br>
			<input type="password" name="Password" placeholder="Password" required>
			<span style="color:red"> <?php echo $passErr;?></span>
			<br>
			<input type="password" name="RePassword" placeholder="Re-Enter Password" required>
			<span style="color:red"> <?php echo $rePassErr;?></span>
			<br>
			<input type="submit" value="Sign Up" name="signUpSubmit" style="background-color:black">
			<span style="color:red"><?php echo $existsErr;?></span>
		  </div></center>
	   </form>
	  <br>
	  <div class="container1, col">
	  <p style = "text-align:center;"> Already have an account? <a href="Login.php" style="padding-left:10px;color:skyblue""> Login</a></p>
	  </div>
    </div>
	
	<div style="margin-left:-20px;background-color:black;height:113px;margin-top:-20px;color:orange;text-align:center;">
	     <br>
		<p>Gateway Software Solutions, Coimbatore</p>
	</div>

</body>
</html>