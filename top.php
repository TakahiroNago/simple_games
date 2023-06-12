<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Games</title>

		<!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		
		<!-- stylesheet -->
		<link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container mx-auto">

<?php
		$path = '';
    if(isset($_COOKIE['login']) && $_COOKIE['login']){
        $username = $_COOKIE['username'];
        require_once "header-user.php";
    }else{
        require_once "header-guest.php";
    }
?>

        <div class="row">
            <div class="col-12 col-md-6 text-center mt-3 d-flex justify-content-center">
								<div class="card">
                		<a href="highlow/index.php" class="text-decoration-none link-hover">
												<img class="card-img-top" src="img/highlow.png" alt="High and Low">
												<div class="card-body">
														<h4 class="card-title">High and Low</h4>
												</div>
										</a>
								</div>
            </div>
            <div class="col-12 col-md-6 text-center mt-3 d-flex justify-content-center">
								<div class="card">
                		<a href="four/index.php" class="text-decoration-none link-hover">
												<img class="card-img-top" src="img/four.png" alt="Four Blocks">
												<div class="card-body">
														<h4 class="card-title">Four Blocks</h4>
												</div>
										</a>
								</div>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <a href="ranking.php" class="btn btn-warning btn-sm float-end px-3 mt-4">High Score Ranking</a>
            </div>
        </div>

        <?php
    		if(!isset($_COOKIE['login']) || (isset($_COOKIE['login']) && !$_COOKIE['login'])){
        ?>
            <div class="row text-center mt-2">
                <div class="col">
                    <a href="signin.php" class="btn btn-primary rounded py-1 float-end" style="text-decoration: none;">
                        Sign in, and save your high scores!
                    </a>
                </div>
            </div>
        <?php
        }
        ?>

    </div>

</body>
</html>