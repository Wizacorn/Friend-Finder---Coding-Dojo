<?php
	session_start();
	require('friendfinderconnection.php');

//----------------------------------Action = login/register----------------------------------------------------

	//logging in
	if (isset($_POST['action']) && $_POST['action'] == 'login') 
	{
		login();
	}
	elseif (isset($_POST['action']) && $_POST['action'] == 'register') 
	{
		register();
	}
	elseif(isset($_POST['action']) && $_POST['action'] == 'log-out')
	{
		session_destroy();
		header('Location: friendfinder.php');
	}

//This portion contains all error messages for failing the register requirements ------------------------------------------------------------
	//Confirm email input


	function register()
	{
	$errors = array();
	//let's see if the first_name is a string
	if(!(isset($_POST['first']) && is_string($_POST['first']) && strlen($_POST['first'])>0))
	{	
		$errors[] = "First name is not valid!";
		$_SESSION['first'] = true;
	}
	//let's see if the last_name is a string
	if(!(isset($_POST['last']) && is_string($_POST['last']) && strlen($_POST['last'])>0))
	{
		$errors[] = "Last name is not valid!";
		$_SESSION['last'] = true;
	}

	if(!(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))
	{	$errors[] = "Email is not valid";
		$_SESSION['email'] = true;
	}

	if(!(isset($_POST['password1']) && strlen($_POST['password1'])>=6))
	{
		$errors[] = "Please double check your password (length must be greater than 6)";
		$_SESSION['password1'] = true;
	}

	if(!(isset($_POST['password2']) && isset($_POST['password1']) && $_POST['password1'] == $_POST['password2']))
	{	
		$errors[] = "Please confirm your password";
		$_SESSION['password2'] = true;
	}

	if(count($errors)>0)
	{
		$_SESSION['register_errors'] = $errors;
		header("Location: friendfinder.php");
	}
	else
	{
		//see if the email address already is taken
		$query = "SELECT * FROM users WHERE email = '{$_POST['email']}'";
		$users = fetch_all($query);	

		//see if someone already registered with that email address
		if(count($users)>0)
		{
			$errors[] = "Someone already registered with this email address.";
			$_SESSION['register_errors'] = $errors;
			header("Location: friendfinder.php");
		}
		else
		{
			$query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) 
			VALUES ('".mysql_real_escape_string($_POST['first'])."', '".mysql_real_escape_string($_POST['last'])."', '".mysql_real_escape_string($_POST['email'])."', '".mysql_real_escape_string(md5($_POST['password1']))."', NOW(),NOW())";
			mysql_query($query);
			echo $query;
			$_SESSION['message'] = "User was successfully created!";
			header('Location: friendpage.php');
		}
	}
}

//Logging in ---------------------------------------------------------------------------------
	
	function login()
	{
		$email = filter_var($_POST['login_name'], FILTER_VALIDATE_EMAIL);
		$regxquery = '((?:[0-9]+))';
		$login_password = md5($_POST['login_password']);

		$errors = array();

		if(!(isset($_POST['login_name']) && $email)) 
			$errors[] = 'Email is not valid';


		if(!(isset($_POST['login_password']) && strlen($_POST['login_password']) >=6 )) 
			$errors[] = 'Please double check your password (length must be greater than 6)';

		if(count($errors) > 0) 
		{
			$_SESSION['login_errors'] = $errors;
			header('Location: friendfinder.php');
		}
		else 
		{
			$compare = "SELECT * FROM users WHERE email = '{$_POST['login_name']}' && 
			password ='".md5($_POST['login_password'])."'";
			$users = fetch_all($compare);

			if(count($users) > 0) 
			{
				$_SESSION['logged_in'] = true;
				$_SESSION['user']['first_name'] = $users[0]['first_name'];
				$_SESSION['user']['last_name'] = $users[0]['last_name'];
				$_SESSION['user']['email'] = $users[0]['email'];
				$_SESSION['user']['users_id'] = $users[0]['id'];

				header('Location: friendpage.php');
			}
			else
			{

				$errors[] = 'Invalid login information.';
				$_SESSION['login_errors'] = $errors;
				header('Location: friendfinder.php');

			}
		}		
	}



 ?>