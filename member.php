<?php 

	/*** begin our session ***/
	session_start();

	
	 if (!isset($_SESSION['user_id']))
	 {
	 	$message = 'You must be logged in to access this page';
	 }
	 else {
	 	
	  	try {
	  		 
	 		/*** connect to database ***/
	 		/*** mysql hostname***/
	 		$mysql_hostname = 'localhost';

	 		/*** mysql username ***/
	 		$mysql_username = 'root';

	 		/*** mysql password ***/
	 		$mysql_password = 'root';

	 		/*** database name ***/
	 		$mysql_dbname = 'php_auth';

	 		$dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname",$mysql_username,$mysql_password);
	 		/*** $message = a message saying we have connected ***/

	 		/*** set the error mode to exceptions ***/
	 		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	 		/*** prepare the insert ***/
	 		$stmt = $dbh->prepare("SELECT username FROM users 
	 								WHERE user_id = :user_id");
	 		 

			/*** bind the parameters ***/
			$stmt->bindParam (':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

			/*** execute the preapared statement ***/
			$stmt->execute();

			/*** check for a result ***/
			$username = $stmt->fetchColumn();

			/*** if we have no something is wrong ***/
			if ($username == false)
			{
				$message = 'Access Error';
			}
			else
			{
				$message = 'Welcome  '. $username;
			}
			
	 	} 
	 	catch (Exception $e) 
	 	{
			/*** if we are here, something is wrong in the database ***/
			$message = 'We are unable to process your request. Please try again later';
			
	 	}
	 }
	
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title></title>
 	<link rel="stylesheet" href="">
 </head>
 <body>
 	<h2><?php echo $message; ?></h2>
 </body>
 </html>