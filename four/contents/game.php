<?php
	// rows and columns to display
	$row = 15; // use number >= 8
	$col = 8; // use number >= 6

	if(!(isset($_SESSION['f_highscore']))){
		// go to index page when high score is not set
		header("location: four/index.php");

	}else{
		// get data from session
		$shape = $_SESSION['shape'];
		$color = $_SESSION['color'];
		$rotate = $_SESSION['rotate'];
		$x_move = $_SESSION['x_move'];
		$down = $_SESSION['down'];
		$blocks = $_SESSION['blocks'];
		$score = $_SESSION['f_score'];
		$high_score = $_SESSION['f_highscore'];
		$next_block_type = $_SESSION['next_block_type'];
		$next_block_display = $_SESSION['next_block_display'];
		$tmp_x_move = $x_move;
		$tmp_rotate = $rotate;
		$tmp_down = $down;
		$game_over = false;

		// response to button
		if(isset($_POST['rotate-ccw']) || isset($_POST['rotate-cw']) || isset($_POST['left']) || isset($_POST['right']) || isset($_POST['down']) || isset($_POST['stay'])){

			// check if movable
			if(isset($_POST['rotate-ccw'])){
				$tmp_rotate = $rotate + 1;
				if($tmp_rotate == 4){
					$tmp_rotate = 0;
				}
			}elseif(isset($_POST['rotate-cw'])){
				$tmp_rotate = $rotate - 1;
				if($tmp_rotate == - 1){
					$tmp_rotate = 3;
				}
			}elseif(isset($_POST['left'])){
				$tmp_x_move = $x_move - 1;
			}elseif(isset($_POST['right'])){
				$tmp_x_move = $x_move + 1;
			}
			$move = true;
			for($i = 0; $i < 4; $i++){
				if($blocks[$shape[$tmp_rotate][$i][0] + $down][$shape[$tmp_rotate][$i][1] + $tmp_x_move]['solid']){
					$move = false;
				}
			}
			if(!($move)){
				$tmp_x_move = $x_move;
				$tmp_rotate = $rotate;
			}

			// check if block goes down
			$go_down = true;
			$tmp_down = $down;
			for($i = 0; $i < 4; $i++){
				if($blocks[$shape[$tmp_rotate][$i][0] + $tmp_down + 1][$shape[$tmp_rotate][$i][1] + $tmp_x_move]['solid']){
					$go_down = false;
				}
			}
			if($go_down){
				$tmp_down += 1;
			}

			if(isset($_POST['down'])){
					while($go_down){
						for($i = 0; $i < 4; $i++){
							if($blocks[$shape[$tmp_rotate][$i][0] + $tmp_down + 1][$shape[$tmp_rotate][$i][1] + $tmp_x_move]['solid']){
								$go_down = false;
							}
						}
						if($go_down){
							$tmp_down += 1;
						}
					}
			}
			
			// insert the moved block data to $blocks
			$blocks = moveBlock($shape, $color, $rotate, $x_move, $down, $blocks, $tmp_rotate, $tmp_x_move, $tmp_down);

			// copy temoporary data to parmanent data
			if($move){
				$x_move = $tmp_x_move;
				$rotate = $tmp_rotate;
			}
			$down = $tmp_down;

			// when cannot go down, make the block solid
			if(!($go_down)){
				for($i = 0; $i < 4; $i++){
					$blocks[$shape[$rotate][$i][0] + $down][$shape[$rotate][$i][1] + $x_move]['solid'] = true;
				}
			}

			// when lined up, remove the line
			$lineRemoved = 0;
			for($i = $row; $i >= 1; $i--){
				$linedUp = 0;
				for($j = 1; $j <= $col; $j++){
					if($blocks[$i][$j]['solid']){
							$linedUp++;
					}
				}
				if($linedUp == $col){
					$blocks = removeLine($blocks, $col, $i);
					$i++;
					$lineRemoved++;
				}
			}

			// score calculation
			$scoreToAdd = 100;
			for($i = 0; $i < $lineRemoved; $i++){
				$scoreToAdd *= 2;
			}
			$scoreToAdd -= 100;
			$score += $scoreToAdd;
			if($high_score < $score){
				$high_score = $score;
			}

			// when cannot go down, create a new block
			if(!($go_down)){
				$new_block = getNewBlock($next_block_type);
				$shape = $new_block[0];
				$color = $new_block[1];
				$rotate = 0;
				$x_move = 0;
				$down = 0;
				$tmp_rotate = 0;
				$tmp_x_move = 0;
				$tmp_down = 0;
				$blocks = insertBlock($shape, $color, $rotate, $x_move, $down, $blocks);

				// check game over
				if($down <= 1){
					$game_over = checkGameOver($shape, $rotate, $x_move, $down, $blocks);
				}

				// create new next block display
				$next_block_type = rand(0, 6);
				$next_block_display = getNextBlock($next_block_type);
			}
				
		} // end of if(isset($_POST['***']))
	}
?>

	<div class="mt-2">
		<table>
			<?php
				for($i = 1; $i <= $row; $i++){
					?>
					<tr>
						<?php
						for($j = 1; $j <= $col; $j++){
							?>
							<td class="border bg-<?= $blocks[$i][$j]['color'] ;?> text-<?= $blocks[$i][$j]['color'] ;?>">***</td>
							<?php
						}
						?>
					</tr>
					<?php
				}
			?>
		</table>
	</div>

<?php
  // send values to next page
	$_SESSION['shape'] = $shape;
	$_SESSION['color'] = $color;
	$_SESSION['rotate'] = $rotate;
	$_SESSION['x_move'] = $x_move;
	$_SESSION['down'] = $down;
	$_SESSION['blocks'] = $blocks;
	$_SESSION['f_score'] = $score;
	$_SESSION['f_highscore'] = $high_score;
	$_SESSION['next_block_type'] = $next_block_type;
	$_SESSION['next_block_display'] = $next_block_display;
?>

