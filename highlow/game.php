<?php
    session_start();
    require "contents/functions.php";

		if(isset($_POST['csrf_token'])){
			$csrf_token = $_POST['csrf_token'];
			checkCSRF($csrf_token);
		}

		// Generate a random binary and convert it to an ASCII string by converting it to hex
		$toke_byte = openssl_random_pseudo_bytes(16);
		$csrf_token = bin2hex($toke_byte);
		// save token into session
		$_SESSION['csrf_token'] = $csrf_token;

    if(empty($_SESSION['rightcard'])){
        header("location: index.php");
    }else{
        $leftCard = $_SESSION['rightcard'];
        $cardSet = $_SESSION['cardset'];
    
        $rightCard = getNewCard($cardSet);
        $cardSet = removeUsedCard($rightCard, $cardSet);
    
        $_SESSION['leftcard'] = $leftCard;
        $_SESSION['rightcard'] = $rightCard;
        $_SESSION['cardset'] = $cardSet;
        $score = $_SESSION['hl_score'];
        $highScore = $_SESSION['hl_highscore'];
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
                        <span class="text-start ms-2 text-<?= cardColor($leftCard); ?> h4 mb-4">
                            <?= cardNumber($leftCard); ?>
                        </span>
                    </div>
                    <div class="row h-50">
                        <span class="display-1 text-center text-<?= cardColor($leftCard); ?> py-3">
                            <?= cardSuit($leftCard); ?>
                        </span>
                    </div>
                    <div class="row h-25">
                        <span class="text-end me-2 text-<?= cardColor($leftCard); ?> h4 mt-4">
                            <?= cardNumber($leftCard); ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-5 my-2">
                <div class="card mx-auto bg-info card-highlow">
                    <div class="row h-25">
                        <span class="text-start ms-2 text-info h4 mb-4">
                            0
                        </span>
                    </div>
                    <div class="row h-50">
                        <span class="display-1 text-center py-3">
                            <img src="../img/hidden.png" class="w-50">
                        </span>
                    </div>
                    <div class="row h-25">
                        <span class="text-end me-2 text-info h4 mt-4">
                            0
                        </span>
                    </div>
                </div>
            </div>

        </div>
    
        <div class="row text-center mt-3">
            <div class="col-sm-8">
                <div class="h4">High or Low?</div>
                <div class="h6">2 < 3 < 4 < 5 < 6 < 7 < 8 < 9 < 10 < J < Q < K < A</div>
                <form action="result.php" method="post">
                    <input type="submit" name="high" value="High" class="btn btn-sm btn-outline-primary px-3 me-3">
                    <input type="submit" name="low" value="Low" class="btn btn-sm btn-outline-success px-3">
										<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
                </form>
            </div>
            <div class="col-sm text-start">
                <div class="h5 mt-2">Score: <?= $score; ?></div>
                <div class="h5">High Score: <?= $highScore; ?></div>
            </div>
        </div>

    </div>

</body>
</html>
