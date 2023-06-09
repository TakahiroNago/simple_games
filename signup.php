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
    <title>Sign up</title>
		<!-- stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
		<link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="site-container mx-auto">
				<div class="row mt-3">
						<div class="col mx-auto bg-info rounded">
								<a href="index.php" class="text-decoration-none">
										<h1 class="text-center my-3 text-white h2">Simple Games</h1>
								</a>
						</div>
				</div>
        <div class="card card-user mx-auto my-5">
            <div class="card-header text-danger">
                <h1 class="text-center display-6">Sign Up</h1>
            </div>
            <div class="card-body">
                <form action="do-signup.php" method="post">
                    <div class="row mb-3">
                        <div class="col-sm">
                            <label for="username" class="form-label">User Name</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm-password" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm mt-3">
                            <input type="submit" name="signup" id="signup" value="Sign Up" class="btn btn-danger form-control px-4 me-4 mb-1">
                            <a href="signin.php" class="small float-end">Sign in</a>
                        </div>
                    </div>
										<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
                </form>

            </div>
        </div>
    </div>
</body>
</html>