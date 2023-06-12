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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>High and Low</title>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        
<?php
		$game = 'highlow';
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        require_once "../header-user.php";
    }else{
        require_once "../header-guest.php";
    }
?>

        <h2 class="text-center my-3">High and Low Game</h2>
        <div class="row bg-success py-5">

            <div class="col-sm">
                <div class="card mx-auto" style="width: 200px;">
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

            <div class="col-sm">
                <div class="card mx-auto" style="width: 200px;">
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

        <div class="row text-center mt-4">
            <div class="col-sm-8">

            <?php
            if(empty($cardSet)){
            ?>
                <span class="float-end text-danger pt-2 h2">INCREDIBLE! YOU USED UP ALL THE CARDS!! CONGRATULATIONS!!!</span>
            <?php
            }else{
								?>
								<h2>High or Low?</h2>
								<h6>2 < 3 < 4 < 5 < 6 < 7 < 8 < 9 < 10 < J < Q < K < A</h6>
								<?php
                if(isset($_POST['high'])){
                    if($leftCard[1] <= $rightCard[1]){
                        $message = 'YOU WIN !';
                        $link = 'game';
                        $buttonValue = 'Next';
                        $buttonColor = 'danger';
                        $scoreCalc = true;
                    }else{
                        $message = 'YOU LOSE !';
                        $link = 'index';
                        $buttonValue = 'Restart';
                        $buttonColor = 'dark';
                        $scoreCalc = false;
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-7">
                            <span class="float-end text-danger pt-2 h2"><?= $message; ?></span>
                        </div>
                        <div class="col-sm">
														<a href="<?= $link; ?>.php" class="btn btn-<?= $buttonColor; ?> px-3 mt-2 float-start">
																<?= $buttonValue; ?>
														</a>
                        </div>
                    </div>
                    <?php
                }
    
                if(isset($_POST['low'])){
                    if($leftCard[1] >= $rightCard[1]){
                        $message = 'YOU WIN !';
                        $link = 'game';
                        $buttonValue = 'Next';
                        $buttonColor = 'danger';
                        $scoreCalc = true;
                    }else{
                        $message = 'YOU LOSE !';
                        $link = 'index';
                        $buttonValue = 'Restart';
                        $buttonColor = 'dark';
                        $scoreCalc = false;
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-7">
                            <span class="float-end text-danger pt-2 h2"><?= $message; ?></span>
                        </div>
                        <div class="col-sm">
														<a href="<?= $link; ?>.php" class="btn btn-<?= $buttonColor; ?> px-3 mt-2 float-start">
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
                <div class="h5 mt-3">Score: <?= $score; ?></div>
                <div class="h5">High Score: <?= $highScore; ?></div>
            </div>

        </div>

    </div>

</body>
</html>
