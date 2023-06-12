<?php
	session_start();
	if(isset($_POST['game'])){
		$game = $_POST['game'];
	}else{
		$game = 'none';
	}
	require_once "sql/connection.php";
	require_once "contents/functions.php";
	if(isset($_POST['signin-btn'])){
		$csrf_token = $_POST['csrf_token'];
		$username = $_POST['username'];
		$password = $_POST['password'];

		checkCSRF($csrf_token);
		signin($username, $password, $game);
	}
?>