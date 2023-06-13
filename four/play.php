<?php
	session_start();
	require "contents/functions.php";
	require "../sql/connection.php";
	
	if(isset($_POST['rotate-ccw']) || isset($_POST['rotate-cw']) || isset($_POST['left']) || isset($_POST['right']) || isset($_POST['down']) || isset($_POST['stay']) || isset($_POST['finish'])){
		$csrf_token = $_POST['csrf_token'];
		checkCSRF($csrf_token);
	}

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
		<title>Four blocks</title>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		
		<!-- stylesheet -->
		<link href="../css/style.css" rel="stylesheet">
	</head>


	<body>
		<div class="container site-container">
							
	<?php
		$game = 'four';
		if(isset($_SESSION['username'])){
			$username = $_SESSION['username'];
			require_once "../header-user.php";
		}else{
			require_once "../header-guest.php";
		} 
	?>

			<h2 class="text-center mt-3">Four Blocks</h2>
			<div class="container">
				<div class="row mx-auto d-flex justify-content-center">
					<div class="col col-sm-5 col-md-4 d-flex justify-content-center no-margin">
						<?php
						require "contents/game.php";
						?>
					</div>
					<div class="col col-sm-5 col-md-4 d-flex justify-content-center">

						<table class="text-center">

							<tr>
								<td>
									<div class="mt-2">
										<div class="fw-bold ">Next Block</div>
										<table class="mx-auto">
											<?php
												for($i = 0; $i < 4; $i++){
													?>
													<tr>
														<?php
														for($j = 0; $j < 4; $j++){
															?>
															<td class="border bg-<?= $next_block_display[$i][$j] ;?> text-<?= $next_block_display[$i][$j] ;?>">***</td>
															<?php
														}
														?>
													</tr>
													<?php
												}
											?>
										</table>
									</div>
								</td>
							</tr>

							<?php
							if(!($game_over)){
							?>
							<form action="" method="post">
							<?php
							}
							?>

								<tr>
									<td>
										<button type="submit" class="btn btn-outline-danger mt-4 btn-sm" name="rotate-ccw">
											<i class="fa-solid fa-rotate-left"></i>
										</button>
										<button type="submit" class="btn btn-outline-danger mt-4 btn-sm" name="rotate-cw">
											<i class="fa-solid fa-rotate-right"></i>
										</button>
									</td>
								</tr>
								
								<tr>
									<td>
										<button type="submit" class="btn btn-outline-danger btn-sm" name="left">
											<i class="fa-solid fa-arrow-left"></i>
										</button>
										<button type="submit" class="btn btn-outline-danger btn-sm" name="stay">
											<i class="fa-solid fa-chevron-down"></i>
										</button>
										<button type="submit" class="btn btn-outline-danger btn-sm" name="right">
											<i class="fa-solid fa-arrow-right"></i>
										</button>
									</td>
								</tr>

								<tr>
									<td>
										<button type="submit" class="btn btn-outline-danger btn-sm" name="down">
											<i class="fa-solid fa-arrow-down"></i><i class="fa-solid fa-arrow-down"></i>
										</button>
									</td>
								</tr>
				
								<tr>
									<td>
										<button type="submit" class="btn btn-outline-danger" name="finish">
										<i class="fa-solid fa-arrows-down-to-line"></i>
										</button>
									</td>
								</tr>

							<?php
							if(!($game_over)){
							?>
								<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
							</form>
							<?php
							}
							?>
							
							<tr>
								<td>
									<a href="index.php">
										<button type="button" class="btn btn-outline-secondary mt-3">Reset</button>
									</a>
								</td>
							</tr>

							<tr>
								<td>
									<div class="h5 mt-2">
										Score: <?= "$score"; ?>
									</div>
								</td>
							</tr>

							<tr>
								<td>
									<div class="h5">
										High Score: <?= "$high_score". " "; ?>
									</div>
								</td>
							</tr>

						</table>

					</div>
				</div>
			</div>

			<?php
			if($game_over){
			?>
			<h2 class="text-center text-danger my-2">Game Over</h2>
			<?php
			}
			?>
			
		</div>
	</body>
</html>