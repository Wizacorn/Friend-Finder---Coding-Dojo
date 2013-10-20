<?php 
	require('friendfinderprocess.php');
 ?>

<!doctype html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="basicform.css">
		<meta charset="UTF-8">
	<title>Basic PHP Form</title>
</head>
<body>
	<div class="container position">
		<div class="form-inline col-xs-3 col-sm-3 col-md-3">
			<?php 
				//If the session id = logged_in then give the all green messages else red message
				if (isset($_SESSION['logged_in'])) 
				{
					echo "<span class='green'>Logging you in.</span>";
				}
				else if(isset($_SESSION['login_errors'])) 
				{
						foreach ($_SESSION['login_errors'] as $value) 
					{
						echo "<span class='red'>".$value."</span><br>";
					}
				}	
			 ?>
			<h1 class="form-signin-heading">Login</h1>
			<form action="friendfinderprocess.php" method="post" form="form" class="form-inline" >
				<input type="hidden" name="action" value="login" />
				<label>Email<input class="form-control" name="login_name" type="text" placeholder="email address"></label>
				<label>Password<input class="form-control" name="login_password" type="password" placeholder="confirm password"></label>
				<input class="btn btn-lg btn-primary" type="submit" value="Log In">
			</form>
		</div>
		<div class="form-inline col-xs-3 col-sm-3 col-md-3">
			<h1>Register</h1>
				<h3> 
				<?php 
				//If the user's registration fails, print the following errors else green message
				if (isset($_SESSION['register_errors'])) 
				{
					foreach ($_SESSION['register_errors'] as $value) 
					{
						echo "<span class='red'>".$value."</span><br>";
					}
				}
				else if (isset($_SESSION['message'])) 
				{
					echo "<span class='green'>".$_SESSION['message']."</span>";
				}	
				?>
			</h3>
			 <form action="friendfinderprocess.php" method="post" class="table">
			 	<input type="hidden" name="action" value="register" />
			 	<label>
			 		Email:<input 

			 		class="form-control
			 		<?php 
			 		if(isset($_SESSION['email'])) 
			 		{
			 			echo 'red';
			 		}
			 		?>" 

			 		type="text" name="email" placeholder="enter your email">
			 	</label>
			 	<br>
				<label>
					First Name:<input  

					class="form-control
					<?php 
					if(isset($_SESSION['first'])) 
			 		{
			 			echo 'red';
			 		}
					?>" type="text" name="first" placeholder="first name">
				</label>
				<br>
				<label>
					Last Name:<input class="form-control
					<?php 
					if(isset($_SESSION['last'])) 
			 		{
			 			echo 'red';
			 		}
					?>" type="text" name="last" placeholder="last name">
				</label>
				<br>
				<label>
					Password:<input class="form-control
					<?php 
					if(isset($_SESSION['password1'])) 
			 		{
			 			echo 'red';
			 		}
					?>" type="password" name="password1" placeholder="password">
				</label>
				<br>
				<label>Confirm Password:<input class="form-control
					<?php 
					if(isset($_SESSION['password2'])) 
			 		{
			 			echo 'red';
			 		}
					?>" type="password" name="password2" placeholder="confirm password">
				</label>
				<br>
				<input class="btn btn-lg btn-primary" type="submit" value="Register">
			 </form>
		</div>
	 </div>
	 <?php  
	 session_unset();
	 ?>
</body>
</html>