<?php // login.php
    session_start();
$conn = new mysqli('localhost','bowermaj_db','password','bowermaj_db'); // this is where the db connection is defined for the entire program.
	if(isset($_SESSION["username"])){

        if(basename($_SERVER['PHP_SELF']) == 'login.php'){
            //since we are being included and they are not logged in redirect them to the login page
            header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/index.php');
            die();
        }
	}else{
		logged_out:
		if(basename($_SERVER['PHP_SELF']) != 'login.php'){
			//since we are being included and they are not logged in redirect them to the login page
			header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/login.php');
			die();
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			//login request
			$uname = $_POST['uname'];
			$pword = $_POST['pword'];

			$escaped_uname = mysqli_real_escape_string($conn,$uname);
			$query = "SELECT * from users WHERE email='$escaped_uname'";
			$result = $conn->query($query);
			if(!$result) die("Database access failed: " . $conn->error);
			if($result->num_rows != 1){
				header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/login.php?invalid=true');
				die();
			}
			$row = $result->fetch_array(MYSQLI_NUM);
			if(!password_verify($pword,$row[3])){
				header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/login.php?invalid=true');
				die();
			}
			//correct login
			session_start();
            $_SESSION["username"] = $uname;
            $_SESSION["level"] = $row[8];
            $_SESSION["fname"] = $row[0];
            if($row[9]){
            	//temporary password
                header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/pass.php');
                die();
			}
            header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/index.php');
            die();
			

		}
		include_once 'nav.php';
        if(isset($_GET['invalid'])){
		    echo "<h3>Invalid Credentials</h3>";
		}
		echo <<<_END
		<form class="sign-in" action="login.php" method="post">
		<input type="email" name="uname" class="sign-in-email" placeholder="Email address" required autofocus>
		<input type="password" name="pword" class="sign-in-password" placeholder="Password" required>
		<button class="sign-in-btn" type="submit">Sign in</button></form>
_END;
	}
?>
