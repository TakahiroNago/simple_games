
<?php
  // check if signed in
	$path = '../'; // path used in header
	if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
		$user_id = $_SESSION['user_id'];
    require_once "../header-user.php";
	}else{
    require_once "../header-guest.php";
	} 