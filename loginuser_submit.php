<?php 
	//if ($_GET['id'] == '' || $_SERVER['REQUEST_METHOD']=='POST') {
	 	# code...
	 	/*** begin our session ***/
	session_start();


	/***check if the users is already logged in  ***/
	if (isset($_SESSION['user_id']))
	{
		$_SESSION['message'] = 'User is already logged in';
		header ('Location: ../phpauth/loginuser.php');
	    exit();

	}
	/*** first check that both the username, password and form_token have been sent***/
	elseif ($_POST['username'] == "" || $_POST['password'] == "")
	{
		$_SESSION['message'] = 'username or password must not be blank';
		header ('Location: ../phpauth/loginuser.php');
	    exit();
	}
	 
	elseif (strlen($_POST['username']) > 20 || strlen($_POST['username']) < 4) 
	{
		$_SESSION['message'] = 'You must be enter atleast 4 characters ';
		header ('Location: ../phpauth/loginuser.php');
	    exit();
	}
	/*** check the password is the correct length***/
	elseif (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 4)
	{
		$_SESSION['message'] = 'Incorrect length for password';
		header ('Location: ../phpauth/loginuser.php');
	    exit();
	}
	/*** check the username has only alpha numeric characters ***/
	elseif (ctype_alnum($_POST['username']) != true) 
	{
		$_SESSION['message'] = "Username must be alpha numeric";
		header ('Location: ../phpauth/loginuser.php');
	    exit();
	}
	/*** check the password has only alpha numeric characters ***/
	elseif (ctype_alnum($_POST['password']) != true) 
	{
		$_SESSION['message'] = "Password must be alpha numeric";
		header ('Location: ../phpauth/loginuser.php');
	    exit();
	}

	else
	{
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

		try 
		{
			$dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname",$mysql_username,$mysql_password);
			/*** $message = a message saying we have connected ***/

			/*** set the error mode to exceptipons ***/
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			/*** Prepare the select statment ***/
			$stmt = $dbh->prepare("SELECT user_id,username,password 
				 				   FROM users 
				 				   WHERE username = :username 
				 				   AND password = :password");
			
			
			/*** bind the parameters ***/
			$stmt->bindParam(':username',$username, PDO::PARAM_STR);
			$stmt->bindParam(':password',$password, PDO::PARAM_STR,40);

			/*** execute the preapared statement ***/
			$stmt->execute();
			// var_dump($stmt);
			// die();
			/*** check for a result ***/
			$user_id = $stmt->fetchColumn();

			/*** if we have no result then fail boat ***/
			if ($user_id == false){
				$_SESSION['message'] = 'Sorry! username or password is not correct';
				header ('Location: ../phpauth/loginuser.php');
	            exit();
			}
			/*** if we do have a result, all is well***/
			else{

				/*** set the session user_id variable ***/
				$_SESSION['user_id'] = $user_id;
				$_SESSION['user_name'] = $username;
				 
				
				/*** tell the user we are logged in ***/
				$_SESSION['message'] = "login successful";
				
				header ('Location: ../phpauth/index.php');
				exit();
				 
			}
			   

		} 
		catch (Exception $e) 
		{
			/*** if we are here, something has gone wrong with the database ***/
			$message = 'we are unable to process your request. Please try again later';
		}

		 
	   
	}

	

 

?>
 