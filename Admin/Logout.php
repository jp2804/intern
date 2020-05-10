<?php
   session_start();
   
  if(isset($_SESSION["AdminID"]))
	{
	   unset($_SESSION["AdminID"]);
	   header("Location: Login.php");
	}
?>