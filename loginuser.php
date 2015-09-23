<?php 
	session_start();
	 
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>User Login</title>
	<link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/default.css">
	<script src="public/js/bootstrap.min.js" type="text/javascript" charset="utf-8" ></script>
	<script src="public/js/jquery-1.11.3.min.js" type="text/javascript" charset="utf-8"></script>
	</head>
<body>
<div class="container">
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
	    <div class="panel panel-primary">
		<?php  //include_once 'loginuser_submit.php'; 
		if( !isset($_SESSION['user_id'] ) ) { ?>
		<div class="panel-heading">
			<h2>User Login</h2>
		</div>
		<div class="panel-body">
			 
		<?php if (isset($_SESSION['message'])): ?>
			<div class="alert alert-danger">
				<?php  
					echo $_SESSION['message'];
					unset($_SESSION['message']);
				?>
			</div>
		<?php endif; ?>
		<form action="loginuser_submit.php" method="post" accept-charset="utf-8">
			<fieldset>
				 <p>
				 	<label>User Name</label>
				 	<input type="text" id="username" name="username" value="" maxlength="20" />
				 	 
				 </p>
				 <p>
				 	<label>Password</label>
				 	<input type="password" name="password" value="" maxlength="20" />
				 	
				 </p>
				 <p class="text-center">
				 	 
				 	<!-- <input type="submit" value="->Login" /> -->
				 	<button  type="submit" class="btn btn-primary">Login</button>
				 </p>
			</fieldset>
		</form>
			<?php }
			 	else {
			?>
			<div class="panel-heading">
				<h2>Logout here</h2>
			</div>
			<div class="alert alert-danger">
			You are now login!
			</div>
				<a class="btn btn-primary" role="button" href="logout.php">Log Out</a>
				<a class="btn btn-primary" role="button" href="member.php">member</a>
 
			<?php } ?>
       </div><!-- end of panel body -->
    </div><!-- end of panel primary -->
</div><!-- end of col-md-4 -->
	<div class="col-md-4"></div>
</div><!-- end of class row -->
</div><!-- end of class container -->
</body>
</html>