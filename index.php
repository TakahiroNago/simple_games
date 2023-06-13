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
    <div class="container mx-auto site-container">

				<div class="row mt-3">
						<div class="col col-sm-12 mx-auto bg-info rounded">
								<a href="index.php" class="text-decoration-none">
										<h1 class="text-center my-3 text-white h2">Simple Games</h1>
								</a>
						</div>
				</div>
        
        <div class="row mt-3 d-flex justify-content-center">
            <div class="col-12 col-sm-6 text-center mt-3 d-flex justify-content-center">
								<div class="card card-index">
                		<a href="highlow/index.php" class="text-decoration-none link-hover">
												<img class="card-img-top" src="img/highlow.png" alt="High and Low">
												<div class="card-body">
														<div class="card-title h4 text-info">High and Low</div>
												</div>
										</a>
								</div>
            </div>
            <div class="col-12 col-sm-6 text-center mt-3 d-flex justify-content-center">
								<div class="card card-index">
                		<a href="four/index.php" class="text-decoration-none link-hover">
												<img class="card-img-top" src="img/four.png" alt="Four Blocks">
												<div class="card-body">
														<div class="card-title h4 text-info">Four Blocks</div>
												</div>
										</a>
								</div>
            </div>
        </div>

        <div class="row">
            <div class="col col-sm-12 mx-auto">
                <a href="ranking.php" class="btn btn-warning text-white form-control mt-3">High Score Ranking</a>
            </div>
        </div>

    </div>

</body>
</html>
