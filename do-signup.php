<?php
	session_start();
	require_once "../sql/connection.php";
	require_once "../contents/functions.php";
	if(isset($_POST['signup'])){
			$csrf_token = $_POST['csrf_token'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$confirm_password = $_POST['confirm_password'];

			checkCSRF($csrf_token);
			checkUserName($username);
			checkPassword($password, $confirm_password);
			addUser($username, $password);
	}
?>
