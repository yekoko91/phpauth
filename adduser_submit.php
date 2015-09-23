<?php 

     /*** begin our session ***/
	session_start();
	

	/*** first check that both the username, password and form_token have been sent***/
	if (!isset($_POST['username'],$_POST['password'],$_POST['form_token']))
	{
		$_SESSION['message'] = 'Please enter a valid username and password';
		header ('Location: ../phpauth/adduser.php');
	    exit();
	}
	
	 /*** check the form token is valid ***/
	elseif ($_POST['form_token'] != $_SESSION['form_token'])
     {
		$_SESSION['message'] ='Invalid form sumission';
		header ('Location: ../phpauth/adduser.php');
	    exit();
	 }
	elseif ($_POST['username'] == "" || $_POST['password'] == "")
	{
		$_SESSION['message'] = 'username or password must not be blank';
		header ('Location: ../phpauth/adduser.php');
	    exit();
	}
	 /*** check the username is the correct length ***/
	 elseif (strlen($_POST['username']) > 20 || strlen($_POST['username']) < 4) 
	 {
	 	$_SESSION['message'] = 'Incorrect length for username';
	 	header ('Location: ../phpauth/adduser.php');
	    exit();

	 }
	/*** check the password is the correct length***/
	 elseif (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 4)
	 {
	 	$_SESSION['message'] = 'Incorrect length for password';
	 	header ('Location: ../phpauth/adduser.php');
	    exit();

	 }

	 /*** check the username has only alpha numeric characters ***/
	 elseif (ctype_alnum($_POST['username']) != true) 
	 {
	 	$_SESSION['message'] = "Username must be alpha numeric";
	 	header ('Location: ../phpauth/adduser.php');
	    exit();

	 }
	 /*** check the password has only alpha numeric characters ***/
	 elseif (ctype_alnum($_POST['password']) != true) 
	 {
	 	$_SESSION['message'] = "Password must be alpha numeric";
	 	header ('Location: ../phpauth/adduser.php');
	    exit();

	 }
	 
	 else {
	 	
	 	/*** if we are here the data is valid and we can insert it into database ***/
	  	$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
	  	$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

		
	  	/*** now we can encrypt the password ***/		
	  	$password = sha1($password);
	  	
	 	/*** connect to database ***/
	    /*** mysql hostname***/
	    $mysql_hostname = 'localhost';

		/*** mysql username ***/
		$mysql_username = 'root';

		/*** mysql password ***/
		$mysql_password = 'root';

		/*** database name ***/
		$mysql_dbname = 'php_auth';
		 

	 	try {
 	 		$dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname",$mysql_username,$mysql_password);
 	 		

			/*** $message = a message saying we have connected ***/

	    	/*** set the error mode to exceptipons ***/
	 		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 		
			/*** prepare the insert***/
	 		$stmt = $dbh->prepare("INSERT INTO users (username,password) VALUES (:username, :password)");

	 		/*** bind the parameters ***/
	 		$stmt->bindParam(':username',$username, PDO::PARAM_STR);
	 		$stmt->bindParam(':password',$password, PDO::PARAM_STR,40);

	 		/*** execute the preapared statement ***/
	 		$stmt->execute();
	 		 

	 		/*** unset the form token session variable ***/
	 		unset($_SESSION['form_token']);

	 		/*** if all is done, say thanks ***/
	 		$_SESSION['message'] = 'New user added';
	 		header ('Location: ../phpauth/index.php');
		    exit();

	 		 
	 	} 
		catch (Exception $e) 
	 	{
			/*** check if the username already exists ***/
			if ($e->getCode() == 23000)
			{
				$_SESSION['message'] = 'Username is already taken!';
				header ('Location: ../phpauth/adduser.php');
		        exit();
			}
			else
			{
				/*** if we are here, something has gone wrong with the database  ***/
				$_SESSION['message'] = 'We are unable to process your request. Try again later';
				header ('Location: ../phpauth/adduser.php');
		        exit();
			}
	    }
	}


 ?>

  