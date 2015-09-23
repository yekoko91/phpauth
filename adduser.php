<?php 
	/*** begin our session  ***/
	session_start();

	/*** set a form token ***/
	$form_token = md5(uniqid('auth',true));

	/*** Set the session from token ***/
	$_SESSION['form_token'] = $form_token;

	 
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>User Authentication System</title>
	 
	<link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/default.css">
	<script src="/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/jquery-1.11.3.min.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<div class="container">
	<div calss="row">
		<div class="col-md-4"></div>	
		<div class="col-md-4">
		<?php if( isset($_SESSION['user_id'] ) ) : ?>
		<div class="panel panel-primary">		
		<div class="panel-heading">
			<h2>Add user</h2>
		</div><!--end of panel-heading -->
		<div class="panel-body">
				 
				<?php if (isset($_SESSION['message'])): ?>
					<div class="alert alert-danger">
						<?php 
							echo $_SESSION['message'];
							unset($_SESSION['message']);					
						?>
					</div>
				<?php endif; ?>
			
			<form action="adduser_submit.php" method="post" accept-charset="utf-8">
				<fieldset>
					 <p>
					 	<label>User Name</label>
					 	<input type="text" id="username" name="username" value="" maxlength="20" />
					 	
					 </p>
					 <p>
					 	<label>Password</label>
					 	<input type="text" name="password" value="" maxlength="20" />
					 	
					 </p>
					 <p class="text-center">
					 	<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
					 	<button type="submit" class="btn btn-primary">Add User</button>
					 </p>
				</fieldset>
			</form>
			</div><!--end of panel body -->
			</div><!--end of panel-primary -->
			<?php else: ?>
				<h5>Please Login !</h5>
				<a class="btn btn-primary" href="loginuser.php">Login</a>
			<?php endif; ?>
		</div><!--end of col-md-4  -->
		<div class="col-md-4"></div>
	</div><!--end of row -->
</div><!-- end of container-->
</body>
</html>