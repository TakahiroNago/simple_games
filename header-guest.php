<div class="row bg-info">
    <div class="col-sm-6">
        <a href="../index.php" style="text-decoration: none;">
            <h1 class="text-center my-2 text-white h2">Simple Games</h1>
        </a>
    </div>
    <div class="col-sm">
        <div class="row">
            <div class="col-sm">
                <a href="../signup.php" class="btn btn-danger btn-sm float-end px-3 my-2">Sign Up</a>
								<form action="../signin.php" method="post">
										<input type="hidden" value="<?=$game?>" name="game">
                		<button type="submit" class="btn btn-primary btn-sm float-end px-3 me-2 my-2">Sign In</button>
								</form>
            </div>
        </div>
    </div>
</div>