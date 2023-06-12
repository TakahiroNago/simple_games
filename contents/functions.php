<?php
		function checkCSRF($csrf_token){
				if ($csrf_token != $_SESSION['csrf_token']) {
						?>
						<p class="text-danger fw-bold text-center">Invalid Request</p>
						<?php
						exit();
				}
		}

    function checkUserName($username){
        if(strlen($username) > 20){
            ?>
            <p class="text-danger fw-bold text-center">Username must be 20 words or shorter.</p>
            <?php
            exit();
        }
        $mysql = connection();
        $sqlCommand = "SELECT username FROM users";
        if($result = $mysql -> query($sqlCommand)){
            $username_list = $result -> fetch_assoc();
            foreach($username_list as $user_exist){
                if($user_exist == $username){
										?>
                    <p class="text-danger fw-bold text-center">This Username is already used</p>
										<?php
                    exit();
                }
            }

        }
    }

    function checkPassword($password, $c_password){
        if(strlen($password) < 8){
            ?>
            <p class="text-danger fw-bold text-center">Password must be 8 words or longer.</p>
            <?php
            exit();
        }
        if(strlen($password) > 100){
            ?>
            <p class="text-danger fw-bold text-center">Password must be 100 words or shorter.</p>
            <?php
            exit();
        }
        if(!(preg_match("/[a-z]/", $password) && preg_match("/[A-Z]/", $password) && preg_match("/[0-9]/", $password))){
            ?>
            <p class="text-danger fw-bold text-center">Password must contain at least 1 upper case letter, 1 lower case letter, and 1 numeric character.</p>
            <?php
            exit(); 
        }
        if($password != $c_password){
            ?>
            <p class="text-danger small text-center fw-bold">password and confirm password did not match</p>
            <?php
            exit(); 
        }
    }

    function addUser($username, $password){
        $mysql = connection();

        $password = password_hash($password, PASSWORD_DEFAULT);

        $sqlCommand = "INSERT INTO users(username,password) VALUES('$username', '$password')";

        if($mysql -> query($sqlCommand)){
            header("location: signin.php");
        }else{
            die("error in adding a user". $mysql->error);
        }
    }
		
    function signin($username, $password){
			$mysql = connection();

			$sqlCommand = "SELECT * FROM users WHERE username = '$username'";

			if($result = $mysql -> query($sqlCommand)){
					if($result -> num_rows == 1){
							$account = $result -> fetch_assoc();
							if(password_verify($password, $account['password'])){

									$_SESSION['user_id'] = $account['id'];
									$_SESSION['username'] = $account['username'];
									$_SESSION['highlow'] = $account['highlow'];
									$_SESSION['four'] = $account['four'];
									setcookie('login', true);
									setcookie('username', $account['username']);

									header('location:index.php');
							}else{
								header('location:signin.php');
									?>
									<p class="text-danger small fw-bold text-cetner">Incorrect Password</p>
									<?php
							}
					}else{
						header('location:signin.php');
							?>
							<p class="text-danger small fw-bold text-cetner">User does not exist</p>
							<?php
					}
			}else{
				header('location:signin.php');
					?>
					<p class="text-danger small fw-bold text-cetner">User does not exist</p>
					<?php
			}
	}
?>