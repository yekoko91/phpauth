<?php 
	
	//Begin the session 
	session_start();

	//Unset all of the session variables
	session_unset();

	//Destroy the session 
	session_destroy();

	header('Location: ../phpauth/loginuser.php');
 ?>
 <!-- <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>Logged Out</title>
 	<link rel="stylesheet" href="">
 </head>
 <body>
 	<h1>You are now logged out. Please come again</h1>
 	<a href="loginuser.php">login</a>
 </body>
 </html> -->