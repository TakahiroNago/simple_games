<?php
	// rows and columns to display
	$row = 15; // use number >= 8
	$col = 8; // use number >= 6

  // initiation of valuables
  $next_block_type = rand(0, 6);
  $new_block = getNewBlock($next_block_type);
  $shape = $new_block[0];
  $color = $new_block[1];
  $rotate = 0;
  $x_move = 0;
  $down = 0;
  $blocks = setBlocks($row, $col);
  $score = 0;
  $next_block_type = rand(0, 6);
	$next_block_display = getNextBlock($next_block_type);

  // insert the new block
  $blocks = insertBlock($shape, $color, $rotate, $x_move, $down, $blocks);
?>

	<div class="container mt-2">
		<table class="float-end">
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
	$_SESSION['next_block_type'] = $next_block_type;
	$_SESSION['next_block_display'] = $next_block_display;
?>