<?php
    require "sql/connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Games</title>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">

<?php
		$path = '';
    session_start();
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        require_once "header-user.php";
    }else{
        require_once "header-guest.php";
    }
?>
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-secondary mt-3">High Score Ranking</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm text-center">
                <table class="table table-hover mt-3">
                    <tr>
                        <td colspan="3" class="bg-primary">
                            <div>
                                <a href="highlow/index.php" class="text-white px-2 py-2 mt-3 fw-bold h4" style="text-decoration: none;">High and Low</a>
                            </div>
                        </td>
                    </tr>
<?php
            $sqlCommand = "SELECT
                           highlow as 'score',
                           username as 'username'
                           FROM users";
            $highLowScores = getScores($sqlCommand);
            arsort($highLowScores);
            $i = 0;
            foreach($highLowScores as $score){
                if($i == 0){
                    $class = 'fw-bold text-danger h4';
                }elseif($i == 1){
                    $class = 'fw-bold text-primary h5';
                }elseif($i == 2){
                    $class = 'fw-bold text-success';
                }else{
                    $class = '';
                }
?>
                    <tr>
                        <td>
                            <span class="<?= $class; ?>"><?= $i + 1; ?></span>
                        </td>
                        <td>
                            <span class="<?= $class; ?>"><?= $score['username']; ?></span>
                        </td>
                        <td>
                            <span class="<?= $class; ?>"><?= $score['score']; ?></span>
                        </td>
                    </tr>
<?php
                $i++;
                if($i == 10){
                    break;
                }
            }
?>
                </table>
            </div>

            <div class="col-sm text-center">
                <table class="table table-hover mt-3">
                    <tr>
                        <td colspan="3" class="bg-danger">
                            <div>
                                <a href="four/index.php" class="text-white px-2 py-2 mt-3 fw-bold h4" style="text-decoration: none;">Four Blocks</a>
                            </div>
                        </td>
                    </tr>
<?php
            $sqlCommand = "SELECT
                           four as 'score',
                           username as 'username'
                           FROM users";
            $FourScores = getScores($sqlCommand);
            arsort($FourScores);
            $i = 0;
            foreach($FourScores as $score){
                if($i == 0){
                    $class = 'fw-bold text-danger h4';
                }elseif($i == 1){
                    $class = 'fw-bold text-primary h5';
                }elseif($i == 2){
                    $class = 'fw-bold text-success';
                }else{
                    $class = '';
                }
?>
                    <tr>
                        <td>
                            <span class="<?= $class; ?>"><?= $i + 1; ?></span>
                        </td>
                        <td>
                            <span class="<?= $class; ?>"><?= $score['username']; ?></span>
                        </td>
                        <td>
                            <span class="<?= $class; ?>"><?= $score['score']; ?></span>
                        </td>
                    </tr>
<?php
                $i++;
                if($i == 10){
                    break;
                }
            }
?>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm text-center">
                <table class="table table-hover mt-3">
                    <tr>
                        <td colspan="3" class="bg-secondary">
                            <div>
                                <a href="" class="text-white px-2 py-2 mt-3 fw-bold h4" style="text-decoration: none;">Comming Soon</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm text-center">
                <table class="table table-hover mt-3">
                    <tr>
                        <td colspan="3" class="bg-secondary">
                            <div>
                                <a href="" class="text-white px-2 py-2 mt-3 fw-bold h4" style="text-decoration: none;">Comming Soon</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <?php
        if(empty($_SESSION['user_id'])){
        ?>
        <div class="row text-center mt-4">
            <div class="col-sm">
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

<?php
    function getScores($sqlCommand){
        $mysql = connection();
        if($result = $mysql -> query($sqlCommand)){
            $scores = array();
            while($row = $result -> fetch_assoc()){
                $scores[] = $row;
            }
            return $scores;
        }
    }
?>