<?php
	
	include("inc/main_menu.php");
	include("php/login_check.php");

	$user_id = $_COOKIE['user_id'];
	$id_min_len = 11;
	$id_max_len = 11;

	$name_min_len = 5;
	$name_max_len = 15;
	$err_msg = null;

	if (isset($_POST['add_dev'])) {

		$dev_id = strip_tags($_POST['dev_id']);
		$dev_name = strip_tags($_POST['dev_name']);

		if (empty($dev_id) || empty($dev_name)) {
			$err_msg = "You must fill in all fields";
		} else {
			if (strlen($dev_id) < $id_min_len || strlen($dev_id) > $id_max_len) {
				$err_msg = "Your device ID must be " . $id_min_len . "-" . $id_max_len . " characters long.";
			} else {
				if (strlen($dev_name) < $name_min_len || strlen($dev_name) > $name_max_len) {
					$err_msg = "Your device name must be " . $name_min_len . "-" . $name_max_len . " characters long.";
				} else {
					
					require("php/connect.php");

					$user_id = mysqli_real_escape_string($db, $user_id);
					$dev_name = mysqli_real_escape_string($db, $dev_name);
					$dev_id = mysqli_real_escape_string($db, $dev_id);

					$device_check = mysqli_query("SELECT * FROM devices WHERE `device_channel` = $dev_id");

					if (mysqli_num_rows($device_check) > 0) {
						$err_msg = "That device has already been added, please add another.";
					} else {
						
						$device_add = mysqli_query($db, "INSERT INTO `wave`.`devices` (`device_id`, `device_owner`, `device_name`, `device_channel`) VALUES (NULL, '$user_id', '$dev_name', '$dev_id');");
						if ($device_add) {
							$page = "
									<div class='page_container_header'>
										<h1>Success!</h1>
									</div>
									<div class='page_container'>
										Your device was successfully registered!
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
										There was an error registering your device! <a href='new_device.php'>Try again</a>...
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

?>
<!DOCTYPE html>
<html>
<head>
	<title>WAVE - Home</title>
</head>
<body>

	<div class="page_container_header">
		<h1>+ New Device</h1>
		<p>Add your new Minlet</p>
	</div>
	<div class="page_container">
		<form method="POST" action="new_device.php">
			<table class="table_container">
				<tr><p><?php echo @$err_msg; ?></p></tr>
				<tr colspan="2">
					<td>Device name</td>
					<td><input type="text" name="dev_name" placeholder="Name your Minlet" value="<?php echo $dev_name; ?>"></td>
				</tr>
				<tr colspan="2">
					<td>Device ID</td>
					<td><input type="text" name="dev_id" placeholder="Channel ID" class="uppercase" value="<?php echo $dev_id; ?>"></td>
				</tr>
				<tr colspan="2">
					<td></td>
					<td><button type="submit" name="add_dev" class="btn btn_red">+ Device</button></td>
				</tr>
			</table>
		</form>
	</div>

</body>
</html>