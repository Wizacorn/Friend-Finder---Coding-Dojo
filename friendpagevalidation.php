<?php
	if(!isset($_SESSION))
	{
    session_start();
	}
	require('friendfinderconnection.php');

	//Adds users to the DB after clicking the "Add friends" button
	if(isset($_POST['action'])) 
	{
		$add_friend = "INSERT INTO friends (user_id,friend_id) 
		VALUES ({$_SESSION['user']['users_id']},{$_POST['friend']}),
		({$_POST['friend']},{$_SESSION['user']['users_id']}) ";
		mysql_query($add_friend);

		//To prevent the same query from being sent multiple times upon refreshing
		header('Location: friendpage.php');
	}

	//Generates the list of users currently in the database that are friends
	//Or available to add as a friend
	function list_of_users()
	{
		$list = "SELECT first_name,last_name, email,id FROM users 
		WHERE id != {$_SESSION['user']['users_id']}";
		$users = fetch_all($list);
		$html = "<table border='1px'>";
		foreach($users as $value) 
		{
			$query = "SELECT * FROM friends WHERE user_id = {$_SESSION['user']['users_id']} && friend_id = {$value['id']}";
			$friend = fetch_record($query);
			$html .= "<form method='post' action='friendpage.php'>	
		 		<input type='hidden' name='action' value='add_friend'/>
				<tr><td>{$value['first_name']} {$value['last_name']}</td>
				<td>{$value['email']}</td>";
				if($friend) 
				{
					$html .= "<td>Friend</td>";
				}
				else
				{
					$html .= "<td>
					<input type='hidden' name='friend' value='{$value['id']}'>
					<input type='submit' value='Add Friends'>
					</td>";
				}
				$html .="</tr>
				</form>";
			if($_SESSION['user']['users_id'] == $value['id']) 
			{
				echo "<td>Friends</td>";
			}
		}
		$html .= "</table>";
		return $html;
	}

	//List of the user's friends
	function get_friends()
	{
		$get_friends = "SELECT first_name,last_name,email,id FROM users
		LEFT JOIN friends ON friends.user_id = users.id 
		WHERE friend_id = {$_SESSION['user']['users_id']}";
		$friends =  fetch_all($get_friends);
		$html = "<table border ='1px'>";
		foreach ($friends as $value) 
		{
			$html .= "<tr><td>{$value['first_name']} {$value['last_name']}
			</td><td>{$value['email']}</tr></td>";
		}
		$html .= "</table>";
		return $html;
	}

 ?>