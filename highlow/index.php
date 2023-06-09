<?php
    session_start();
    require "contents/functions.php";
    require "../sql/connection.php";

		// Generate a random binary and convert it to an ASCII string by converting it to hex
		$toke_byte = random_bytes(16);
		$csrf_token = bin2hex($toke_byte);
		// save token into session
		$_SESSION['csrf_token'] = $csrf_token;

    // 4 suits and 13 numbers of cards.
    $cardSet = array();
    for($i = 0; $i <= 3; $i++){
        for($j = 0; $j <= 12; $j++){
            $cardSet[] = array($i, $j);
        }
    }
    $rightCard = getNewCard($cardSet);
    $cardSet = removeUsedCard($rightCard, $cardSet);

    $score = 0;
    $highScore = 0;

    if(isset($_SESSION['user_id'])){
        $highScore = $_SESSION['highlow'];
    }

    if(isset($_SESSION['hl_highscore'])){
        if($_SESSION['hl_highscore'] > $highScore){
            $highScore = $_SESSION['hl_highscore'];
        }
    }

    $_SESSION['rightcard'] = $rightCard;
    $_SESSION['cardset'] = $cardSet;
    $_SESSION['hl_score'] = $score;
    $_SESSION['hl_highscore'] = $highScore;

    if(isset($_SESSION['user_id'])){
        $_SESSION['highlow'] = $highScore;
    }
    
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        sendHighScore($highScore, $user_id);
    }
    
    // only for displaying cards at index page
    $indexCardSet = $cardSet;
    $indexLeft = getNewCard($indexCardSet);
    $indexCardSet = removeUsedCard($indexLeft, $indexCardSet);
    $indexRight = getNewCard($indexCardSet);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>High and Low</title>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		 
		<!-- stylesheet -->
		<link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container site-container">
             
<?php
		$game = 'highlow';
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        require_once "../header-user.php";
    }else{
        require_once "../header-guest.php";
    }
?>

				<h2 class="text-center my-3 h3">High and Low Game</h2>
        <div class="row bg-success py-5 d-flex justify-content-center">

            <div class="col-6 col-md-5 my-2">
                <div class="card mx-auto card-highlow">
                    <div class="row h-25">
                        <span class="text-start text-<?= cardColor($indexLeft); ?> h4 mb-4 ms-2">
                            <?= cardNumber($indexLeft); ?>
                        </span>
                    </div>
                    <div class="row h-50">
                        <span class="display-1 text-center text-<?= cardColor($indexLeft); ?> py-3">
                            <?= cardSuit($indexLeft); ?>
                        </span>
                    </div>
                    <div class="row h-25">
                        <span class="text-end text-<?= cardColor($indexLeft); ?> h4 mt-4 me-2">
                            <?= cardNumber($indexLeft); ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-5 my-2">
                <div class="card mx-auto card-highlow">
                    <div class="row h-25">
                        <span class="text-start text-<?= cardColor($indexRight); ?> h4 mb-4 ms-2">
                            <?= cardNumber($indexRight); ?>
                        </span>
                    </div>
                    <div class="row h-50">
                        <span class="display-1 text-center py-3">
                            <?= cardSuit($indexRight); ?>
                        </span>
                    </div>
                    <div class="row h-25">
                        <span class="text-end text-<?= cardColor($indexRight); ?> h4 mt-4 me-2">
                            <?= cardNumber($indexRight); ?>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        <div class="row text-center mt-4">

            <div class="col-sm">
                <div class="row">
                    <div class="col-sm">
													<a href="../index.php">
															<span class="btn btn-secondary btn-sm px-3 ms-2 float-end">Top Page</span>
													</a>
													<form action="game.php" method="post">
															<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
															<button type="submit" class="btn btn-danger btn-sm  px-3 ms-2 float-end">Start Game</button>
													</form>
                    </div>
                </div>
								
								<?php
								if(empty($_SESSION['user_id']) && $highScore != 0){
								?>
										<div class="row">
												<form action="../signin.php" method="post">
														<input type="hidden" value="<?=$game?>" name="game">
														<button type="submit" class="btn btn-primary btn-sm float-end mt-2">Sign in, and save your high score!</button>
												</form>
										</div>
								<?php
								}
								?>
						</div>

            <div class="col-sm text-start ms-3">
                <div class="h5">Score: <?= $score; ?></div>
                <div class="h5">High Score: <?= $highScore; ?></div>
            </div>

        </div>

    </div>

</body>
</html>