<?php
	session_start();

	// Generate a random binary and convert it to an ASCII string by converting it to hex
	$toke_byte = openssl_random_pseudo_bytes(16);
	$csrf_token = bin2hex($toke_byte);
	// save token into session
	$_SESSION['csrf_token'] = $csrf_token;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign in</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
	<div class="container">
		<?php
    if(isset($_SESSION['username'])){
				header("location:index.php");
    }
		?>
		<div class="row mt-3">
				<div class="col col-sm-12 col-md-6 mx-auto bg-info rounded">
						<a href="index.php" style="text-decoration: none;">
								<h1 class="text-center my-3 text-white h1">Simple Games</h1>
						</a>
				</div>
		</div>
		<div class="card w-25 mx-auto my-5">
			<div class="card-header text-primary border-bottom-0 bg-white">
				<h1 class="card-title display-6 text-center">Sign in</h1>
			</div>
			<div class="card-body">
				<form action="do-signin.php" method="post">
					<div class="row mb-3">
						<div class="col-sm">
							<label for="username">Username</label>
							<input type="text" name="username" id="username" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-sm">
							<label for="username">Password</label>
							<input type="password" name="password" id="password" class="form-control">
						</div>
					</div>
					<div class="row text-center">
						<div class="col-sm">
							<input type="submit" name="signin-btn" id="signin" class="form-control btn btn-primary" value="Sign in">
							<a href="signup.php" class="small">Create an account</a>
						</div>
					</div>
					<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
<?php
		if(isset($_POST['game'])){
?>
					<input type="hidden" name="game" value="<?=$_POST['game']?>">
<?php
		}
?>
				</form>
			</div>
		</div>

	</div>

</body>
</html>