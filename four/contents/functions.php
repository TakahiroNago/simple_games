<?php
function checkCSRF($csrf_token){
		if ($csrf_token != $_SESSION['csrf_token']) {
				?>
				<p class="text-danger fw-bold text-center">Invalid Request</p>
				<?php
				exit();
		}
}

function getNewBlock($next_block_type){
  $color = '';
  if($next_block_type == 0){
    $color = 'danger';
    $shape = [
      [[1, 3], [1, 4], [1, 5], [1, 6]],
      [[0, 4], [1, 4], [2, 4], [3, 4]],
      [[1, 3], [1, 4], [1, 5], [1, 6]],
      [[0, 4], [1, 4], [2, 4], [3, 4]],
    ];
  }
  if($next_block_type == 1){
    $color = 'warning';
    $shape = [
      [[1, 3], [1, 4], [1, 5], [2, 5]],
      [[1, 4], [1, 5], [2, 4], [3, 4]],
      [[1, 4], [2, 4], [2, 5], [2, 6]],
      [[0, 5], [1, 5], [2, 4], [2, 5]],
    ];
  }
  if($next_block_type == 2){
    $color = 'success';
    $shape = [
      [[1, 4], [1, 5], [1, 6], [2, 4]],
      [[0, 4], [1, 4], [2, 4], [2, 5]],
      [[2, 3], [2, 4], [2, 5], [1, 5]],
      [[1, 4], [1, 5], [2, 5], [3, 5]],
    ];
  }
  if($next_block_type == 3){
    $color = 'primary';
    $shape = [
      [[1, 3], [1, 4], [1, 5], [2, 4]],
      [[1, 4], [2, 4], [3, 4], [2, 5]],
      [[1, 5], [2, 4], [2, 5], [2, 6]],
      [[0, 5], [1, 4], [1, 5], [2, 5]],
    ];
  }
  if($next_block_type == 4){
    $color = 'secondary';
    $shape = [
      [[1, 3], [1, 4], [2, 4], [2, 5]],
      [[1, 5], [2, 4], [2, 5], [3, 4]],
      [[1, 4], [1, 5], [2, 5], [2, 6]],
      [[0, 5], [1, 4], [1, 5], [2, 4]],
    ];
  }
  if($next_block_type == 5){
    $color = 'info';
    $shape = [
      [[1, 5], [1, 6], [2, 4], [2, 5]],
      [[0, 4], [1, 4], [1, 5], [2, 5]],
      [[1, 4], [1, 5], [2, 3], [2, 4]],
      [[1, 4], [2, 4], [2, 5], [3, 5]],
    ];
  }
  if($next_block_type == 6){
    $color = 'dark';
    $shape = [
      [[1, 4], [1, 5], [2, 4], [2, 5]],
      [[1, 4], [1, 5], [2, 4], [2, 5]],
      [[1, 4], [1, 5], [2, 4], [2, 5]],
      [[1, 4], [1, 5], [2, 4], [2, 5]],
    ];
  }
  return [$shape, $color];
}


function insertBlock($shape, $color, $rotate, $x_move, $down, $blocks){
  for($i = 0; $i < 4; $i++){
    $blocks[$shape[$rotate][$i][0] + $down][$shape[$rotate][$i][1] + $x_move]['color'] = $color;
  } 
  return $blocks;
}


function checkGameOver($shape, $rotate, $x_move, $down, $blocks){
  $over = false;
  for($i = 0; $i < 4; $i++){
    if($blocks[$shape[$rotate][$i][0] + $down][$shape[$rotate][$i][1] + $x_move]['solid']){
      $over = true;
    } 
  } 
  return $over;
}


function moveBlock($shape, $color, $rotate, $x_move, $down, $blocks, $tmp_rotate, $tmp_x_move, $tmp_down){
  for($i = 0; $i < 4; $i++){
    $blocks[$shape[$rotate][$i][0] + $down][$shape[$rotate][$i][1] + $x_move]['color'] = 'white';
  } 
  for($i = 0; $i < 4; $i++){
    $blocks[$shape[$tmp_rotate][$i][0] + $tmp_down][$shape[$tmp_rotate][$i][1] + $tmp_x_move]['color'] = $color;
  } 
  return $blocks;
}


function removeLine($blocks, $col, $rowRemoved){
  for($i = $rowRemoved; $i >= 1; $i--){
    for($j = 1; $j <= $col; $j++){
        $blocks[$i][$j] = $blocks[$i - 1][$j];
    }
  }
  return $blocks;
}

function setBlocks($row, $col){
  $blocks = array();
  for($i = 0; $i <= $row; $i++){
    for($j = 0; $j <= $col + 1; $j++){
      $blocks[$i][$j] = ['solid' => false, 'color' => 'white'];
    }
  }
  for($i = 1; $i <= $col; $i++){
    $blocks[$row + 1][$i] = ['solid' => true, 'color' => 'white'];
  }
  for($i = 1; $i <= $row; $i++){
    $blocks[$i][0] = ['solid' => true, 'color' => 'white'];
    $blocks[$i][$col + 1] = ['solid' => true, 'color' => 'white'];
  }

  return $blocks;
}


function sendHighScore($f_highscore, $user_id){
  $mysql = connection();

  $sqlCommand = "UPDATE users
                 SET 
                 four = '$f_highscore'
                 WHERE id = '$user_id';";

  if($mysql -> query($sqlCommand)){
      // echo "success";
  }else{
      die("error in updating the highscore ". $mysql->error);
  }
}


function getNextBlock($next_block_type){
  $new_block = getNewBlock($next_block_type);
  $shape = $new_block[0][0];
  $color = $new_block[1];
  
  $next_block_display = array();
  for($i = 0; $i < 4; $i++){
    for($j = 0; $j < 4; $j++){
      $next_block_display[$i][$j] = 'white';
    }
  }

  for($i = 0; $i < 4; $i++){
    $next_block_display[$shape[$i][0]][$shape[$i][1] - 3] = $color;
  }

  return $next_block_display;
}


?>