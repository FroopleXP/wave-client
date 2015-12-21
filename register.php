<?php
	
	include("inc/no_login_menu.php");
	include("php/keys.php");

	if (isset($_COOKIE['user_id'])) {
		header("Location: home.php");
	}

	if (isset($_POST['register'])) {

		$error_msg = "";
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$response = file_get_contents($url . "?secret=" . $privatekey . "&response=" . $_POST['g-recaptcha-response'] . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
		$data = json_decode($response);

		$username = strip_tags($_POST['username']);
		$password = strip_tags($_POST['password']);
		$password_conf = strip_tags($_POST['password_conf']);

		if (isset($data -> success) AND $data -> success == true) {

			if (empty($username) || empty($password) || empty($password_conf)) {
				$error_msg = "Your must fill out all fields.";
			} else {
				if (strlen($username) < 5) {
					$error_msg = "Your username is too short...";
				} else {
					if (strlen($password) < 5) {
						$error_msg = "Your password is too short...";
					} else {
						if ($password !== $password_conf) {
							$error_msg = "You password's do not match!";
						} else {
							
							require("php/connect.php");
							$username = mysqli_real_escape_string($db, $username);
							$password = mysqli_real_escape_string($db, $password);
							$user_check = mysqli_query($db, "SELECT * FROM users WHERE user_name = '$username'");

							if (mysqli_num_rows($user_check) > 0) {
								$error_msg = "Sorry, that Username has already been taken...";
							} else {
								$password = md5($password);
								$user_ins = mysqli_query($db, "INSERT INTO users (`user_id`, `user_name`, `user_pass`) VALUES ('NULL', '$username', '$password')");
								if ($user_ins) {
									$page = "
											<div class='page_container_header'>
												<h1>Success!</h1>
												<p>Welcome aboard</p>
											</div>
											<div class='page_container'>
												You've successfully signed up! <a href='login.php'>Click here</a> to login
											</div>
									";

									echo $page;
									exit();
								} else {
									$page = "
											<div class='page_container_header'>
												<h1>Oops!</h1>
												<p>Not this again...</p>
											</div>
											<div class='page_container'>
												There was an error registering your account! <a href='register.php'>Try again</a>...
											</div>
									";
									echo $page;
									exit();
								}
							}

						}
					}
				}
			}
		} else {
			$error_msg = "Robots are cool and all but they're not wanted on this site!";
		}

	} 

?>
<!DOCTYPE html>
<html>
<head>
	<title>WAVE - Register</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>

	<div class="page_container_header">
		<h1>Register</h1>
		<p>Sign up today!</p>
	</div>
	<div class="page_container">
		<form method="POST" action="register.php">
			<table class="table_container">
				<tr>
					<td><p><?php echo @$error_msg; ?></p></td>
				</tr>
				<tr>
					<td>Username</td>
				</tr>
				<tr>
					<td><input type="text" placeholder="Username" name="username" autocomplete="off" value="<?php echo @$username; ?>" required><td>
				</tr>
				<tr>
					<td>Password</td>
				</tr>
				<tr>
					<td><input type="password" placeholder="Password" name="password" required></td>
				</tr>
				<tr>
					<td>Confirm Password</td>
				</tr>
				<tr>
					<td><input type="password" placeholder="Confirm Password" name="password_conf" required></td>
				</tr>
				<tr>
					<td><div class="g-recaptcha" data-sitekey="<?php echo $sitekey; ?>"></div></td>
				</tr>
				<tr>
					<td>
						<button type="submit" class="btn btn_yellow" name="register">Register</button>
						<a href="login.php"><button type="button" class="btn btn_red">Login</button></a>
					</td>
				</tr>
			</table>
		</form>
	</div>

</body>
</html>