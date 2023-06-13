<div class="row bg-primary">
    <div class="col-sm-6">
        <a href="../index.php" style="text-decoration: none;">
            <h1 class="text-center my-2 text-white h2">Simple Games</h1>
        </a>
    </div>
    <div class="col-sm">
								<form action="../signout.php" method="post">
										<input type="hidden" value="<?=$game?>" name="game">
                		<button type="submit" class="btn btn-danger btn-sm float-end px-3 me-2 my-2">Sign Out</button>
                		<span class="text-white float-end me-3 mt-2 pt-1 fw-bold">Welcome, <?= $username; ?> !</span>
								</form>
    </div>
</div>