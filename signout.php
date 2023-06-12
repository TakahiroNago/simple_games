<?php
if(isset($_POST['game'])){
	$game = $_POST['game'];
}else{
	$game = 'none';
}
session_start();
session_unset();
session_destroy();

if($game == 'four'){
	header('location:four/index.php');
}elseif($game == 'highlow'){
	header('location:highlow/index.php');
}else{
	header('location:index.php');
}
?>