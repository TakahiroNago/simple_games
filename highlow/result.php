<?php
    session_start();
    require "contents/functions.php";
    require "../sql/connection.php";

		if(isset($_POST['high']) || isset($_POST['low'])){
			$csrf_token = $_POST['csrf_token'];
			checkCSRF($csrf_token);
		}

    if(empty($_SESSION['rightcard'])){
        header("location: index.php");
    }else{
        $leftCard = $_SESSION['leftcard'];
        $rightCard = $_SESSION['rightcard'];
        $cardSet = $_SESSION['cardset'];
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
                        <span class="text-start text-<?= cardColor($leftCard); ?> h4 mb-4 ms-2">
                            <?= cardNumber($leftCard); ?>
                        </span>
                    </div>
                    <div class="row h-50">
                        <span class="display-1 text-center text-<?= cardColor($leftCard); ?> py-3">
                            <?= cardSuit($leftCard); ?>
                        </span>
                    </div>
                    <div class="row h-25">
                        <span class="text-end text-<?= cardColor($leftCard); ?> h4 mt-4 me-2">
                            <?= cardNumber($leftCard); ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-5 my-2">
                <div class="card mx-auto card-highlow">
                    <div class="row h-25">
                        <span class="text-start text-<?= cardColor($rightCard); ?> h4 mb-4 ms-2">
                            <?= cardNumber($rightCard); ?>
                        </span>
                    </div>
                    <div class="row h-50">
                        <span class="display-1 text-center py-3">
                            <?= cardSuit($rightCard); ?>
                        </span>
                    </div>
                    <div class="row h-25">
                        <span class="text-end text-<?= cardColor($rightCard); ?> h4 mt-4 me-2">
                            <?= cardNumber($rightCard); ?>
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <div class="row text-center mt-3">
            <div class="col-sm-8">

            <?php
            if(empty($cardSet)){
            ?>
                <span class="float-end text-danger pt-2 h2">INCREDIBLE! YOU USED UP ALL THE CARDS!! CONGRATULATIONS!!!</span>
            <?php
            }else{
								?>
								<div class="h4">High or Low?</div>
								<div class="h6">2 < 3 < 4 < 5 < 6 < 7 < 8 < 9 < 10 < J < Q < K < A</div>
								<?php
                if(isset($_POST['high'])){
                    if($leftCard[1] <= $rightCard[1]){
                        $message = 'You win !';
                        $link = 'game';
                        $buttonValue = 'Next';
                        $buttonColor = 'danger';
                        $scoreCalc = true;
                    }else{
                        $message = 'You lose !';
                        $link = 'index';
                        $buttonValue = 'Restart';
                        $buttonColor = 'secondary';
                        $scoreCalc = false;
                    }
                    ?>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-sm-7">
                            <span class="text-danger h3 pt-3"><?= $message; ?></span>
														<a href="<?= $link; ?>.php" class="btn btn-sm btn-<?= $buttonColor; ?> px-3 ms-2 mb-2">
																<?= $buttonValue; ?>
														</a>
                        </div>
                    </div>
                    <?php
                }
    
                if(isset($_POST['low'])){
                    if($leftCard[1] >= $rightCard[1]){
                        $message = 'You win !';
                        $link = 'game';
                        $buttonValue = 'Next';
                        $buttonColor = 'danger';
                        $scoreCalc = true;
                    }else{
                        $message = 'You lose !';
                        $link = 'index';
                        $buttonValue = 'Restart';
                        $buttonColor = 'secondary';
                        $scoreCalc = false;
                    }
                    ?>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-sm-7">
                            <span class="text-danger h3 pt-3"><?= $message; ?></span>
														<a href="<?= $link; ?>.php" class="btn btn-sm btn-<?= $buttonColor; ?> px-3 ms-2 mb-2">
																<?= $buttonValue; ?>
														</a>
                        </div>
                    </div>
                    <?php
                }
                if($scoreCalc){
                    if($_SESSION['hl_score'] == 0){
                        $score = 100;
                    }else{
                        $score = $_SESSION['hl_score'] * 2;
                    }
                }else{
                    $score = $_SESSION['hl_score'];
                }
                $highScore = $_SESSION['hl_highscore'];
                if($highScore < $score){
                    $highScore = $score;
                }
                $_SESSION['hl_score'] = $score;
                $_SESSION['hl_highscore'] = $highScore;
                
                if(isset($_SESSION['user_id'])){
                    $user_id = $_SESSION['user_id'];
                    sendHighScore($highScore, $user_id);
                }
            }
            ?>

            </div>
            <div class="col-sm text-start">
                <div class="h5 mt-2">Score: <?= $score; ?></div>
                <div class="h5">High Score: <?= $highScore; ?></div>
            </div>

        </div>

    </div>

</body>
</html>
