<?php
function checkCSRF($csrf_token){
		if ($csrf_token != $_SESSION['csrf_token']) {
				?>
				<p class="text-danger fw-bold text-center">Invalid Request</p>
				<?php
				exit();
		}
}

function cardColor($card){
    if($card[0] <= 1){
        $color = 'dark';
    }else{
        $color = 'danger';
    }
    return $color;
}

function cardSuit($card){
    if($card[0] == 0){
        $suit = '<img src="../img/spade.png" class="w-50">'; //spade
    }elseif($card[0] == 1){
        $suit = '<img src="../img/club.png" class="w-50">'; //club
    }elseif($card[0] == 2){
        $suit = '<img src="../img/diamond.png" class="w-50">'; //diamond
    }else{
        $suit = '<img src="../img/heart.png" class="w-50">'; //heart
    }
    return $suit;
}

function cardNumber($card){
    if($card[1] <= 8){
        $number = $card[1] + 2;
    }elseif($card[1] == 9){
        $number = 'J';
    }elseif($card[1] == 10){
        $number = 'Q';
    }elseif($card[1] == 11){
        $number = 'K';
    }else{
        $number = 'A';
    }
    return $number;
}

function removeUsedCard($usedCard, $cardSet){
    $removeNumber = $usedCard[0] * 13 + $usedCard[1];
    unset($cardSet[$removeNumber]);
    return $cardSet;
}

function getNewCard($cardSet){
    $cardSetInOrder = array_values($cardSet);
    $count = count($cardSetInOrder);
    $newCard = $cardSetInOrder[rand(0, $count - 1)];
    return $newCard;
}

function sendHighScore($hl_highscore, $user_id){
    $mysql = connection();

    $sqlCommand = "UPDATE users
                   SET 
                   highlow = '$hl_highscore'
                   WHERE id = '$user_id';";

    if($mysql -> query($sqlCommand)){
        // echo "success";
    }else{
        die("error in updating the highscore ". $mysql->error);
    }
}
?>