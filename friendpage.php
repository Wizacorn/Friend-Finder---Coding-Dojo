<?php 
	if(!isset($_SESSION))
	{
    session_start();
	}
	require('friendpagevalidation.php');
 ?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home</title>

	</script>
</head>
<body>
	<div id="welcome">
		<?php 
		//Lists the user's name as well as the user's email
		echo "Welcome, {$_SESSION['user']['first_name']}!<br>";
		echo $_SESSION['user']['email'];
		 ?>
	</div>
	<div>
		<h2>List of Friends:</h2>
		<div id="list_of_friends">
			<?php 
				//List of the user's friends
				echo get_friends();
			 ?>
		</div>
		<h2>List of Users who subscribed to Friend Finder:</h2>
		<div id="list_of_users">
			<?php 
				//Generates the list of users in the DB
				echo list_of_users();
				
			 ?>
		</div>
	</div>
	<form name="log_out" action="friendfinder.php" method="post">
	<?php 
		if(isset($_POST['log_out'])) 
		{
			session_destroy();
			header('Location: friendfinder.php');
		}
	 ?>
	 	<button>Log Out</button>
	 </form>
</body>
</html>