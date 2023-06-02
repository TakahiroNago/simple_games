<?php
	session_start();
	require_once "../../sql/connection.php";
	require_once "functions.php";
	if(isset($_POST['signin-btn'])){
		$csrf_token = $_POST['csrf_token'];
		$username = $_POST['username'];
		$password = $_POST['password'];

		checkCSRF($csrf_token);
		signin($username, $password);
	}
?>