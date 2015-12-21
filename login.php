<?php
	
	include("inc/no_login_menu.php");

	if (isset($_COOKIE['user_id'])) {
		header("Location: home.php");
	}
	
	if (isset($_POST['login'])) {
		
		$username = strip_tags($_POST['username']);
		$password = strip_tags($_POST['password']);
		$password = md5($password);
		
		require("php/connect.php");
		$username = mysqli_real_escape_string($db, $username);
		$password = mysqli_real_escape_string($db, $password);

		$user_check = mysqli_query($db, "SELECT * FROM users WHERE BINARY user_name = '$username' AND BINARY user_pass = '$password'");

		if (mysqli_num_rows($user_check) < 1) {
			$error_msg = "Incorrect Login details...";
		} else {

			$user_pull = mysqli_fetch_array($user_check);
			$user_id = $user_pull['user_id'];
			$user_name = $user_pull['user_name'];

			setcookie("user_id", $user_id, strtotime( '+30 days' ), "/", "", false, false);
			$_COOKIE["user_id"] = $user_id;
			setcookie("user_name", $user_name, strtotime( '+30 days' ), "/", "", false, false);
			$_COOKIE["user_name"] = $user_name;
			
			header("Location: home.php");

		}

	} 

?>
<!DOCTYPE html>
<html>
<head>
	<title>WAVE - Login</title>
</head>
<body>
	<div class="page_container_header">
		<h1>Login</h1>
		<p>This where it all begins...</p>
	</div>
	<div class="page_container">

		<form method="POST" action="login.php">
			<table class="table_container">

				<tr>
					<td>
						<p><?php echo @$error_msg; ?></p>
					</td>
				</tr>
				<tr>
					<td>Username</td>
				</tr>
				<tr>
					<td>
						<input type="text" placeholder="Username" name="username" value="<?php echo @$username; ?>" required>
					</td>
				</tr>
				<tr>
					<td>Password</td>
				</tr>
				<tr>
					<td>
						<input type="password" placeholder="Password" name="password" required>
					</td>
				</tr>
				<tr colspan="2">
					<td>
						<input type="submit" class="btn btn_red" value="Login" name="login">
						<a href="register.php"><button type="button" class="btn btn_yellow">Register</button></a>
					</td>
				</tr>
			</table>
		</form>

	</div>

</body>
</html>