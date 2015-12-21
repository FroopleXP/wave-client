<?php
	
	include("inc/main_menu.php");
	include("php/login_check.php");
	include("php/connect.php");

	// Getting the Device ID form the URL
	$device_id = strip_tags($_GET['dev_id']);
	$device_id = mysqli_real_escape_string($db, $device_id);
	$user_id = $_COOKIE['user_id'];

	if (is_numeric($device_id)) {

		$info_get = mysqli_query($db, "SELECT * FROM devices WHERE device_id = '$device_id'");

		if (mysqli_num_rows($info_get) > 0) {

			$info_pull = mysqli_fetch_array($info_get);
			$owner_id = $info_pull['device_owner'];

			if ($owner_id != $user_id) {
				$page = "
						<div class='page_container_header'>
							<h1>Oops!</h1>
							<p>Access Denied</p>
						</div>
						<div class='page_container'>
							You do not have permission to access this controller!
						</div>
				";
				echo $page;
				exit();				
			} else {

				$device_name = $info_pull['device_name'];
				$device_channel = $info_pull['device_channel'];

			}

		} else {
			$page = "
					<div class='page_container_header'>
						<h1>Oops!</h1>
						<p>Not this again...</p>
					</div>
					<div class='page_container'>
						It seems that there is no record of that device! Go <a href='home.php'>Home?</a>
					</div>
			";
			echo $page;
			exit();
		}

	} else {	
		header("Location: home.php");
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>WAVE - Controllingz</title>
	<script type="text/javascript" src="http://127.0.0.1:8080/socket.io/socket.io.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="js/controller_script.js"></script>
</head>
<body>

	<div class="page_container_header">
		<h1>Control</h1>
		<p>This is where the magic happens!</p>
	</div>
	<div class="page_container">
		<table class="table_container device_list" id="control_list">
			<tr>
				<td><h2>Controlling "<?php echo $device_name; ?>"</h2></td>
			</tr>
			<tr colspan="3">
				<td>Socket 1</td>
				<td><button type="button" id="switch" class="btn btn_red" channel_id="<?php echo $device_channel; ?>" socket_num="1" pos="0">Off</button></td>
				<td><button type="button" id="switch" class="btn btn_yellow" channel_id="<?php echo $device_channel; ?>" socket_num="1" pos="1">On</button></td>
			</tr>
			<tr colspan="3">
				<td>Socket 2</td>
				<td><button type="button" id="switch" class="btn btn_red" channel_id="<?php echo $device_channel; ?>" socket_num="2" pos="0">Off</button></td>
				<td><button type="button" id="switch" class="btn btn_yellow" channel_id="<?php echo $device_channel; ?>" socket_num="2" pos="1">On</button></td>
			</tr>
			<tr colspan="3">
				<td>Socket 3</td>
				<td><button type="button" id="switch" class="btn btn_red" channel_id="<?php echo $device_channel; ?>" socket_num="3" pos="0">Off</button></td>
				<td><button type="button" id="switch" class="btn btn_yellow" channel_id="<?php echo $device_channel; ?>" socket_num="3" pos="1">On</button></td>
			</tr>
			<tr colspan="3">
				<td>Socket 4</td>
				<td><button type="button" id="switch" class="btn btn_red" channel_id="<?php echo $device_channel; ?>" socket_num="4" pos="0">Off</button></td>
				<td><button type="button" id="switch" class="btn btn_yellow" channel_id="<?php echo $device_channel; ?>" socket_num="4" pos="1">On</button></td>
			</tr>
				<tr colspan="3">
				<td>Socket 5</td>
				<td><button type="button" id="switch" class="btn btn_red" channel_id="<?php echo $device_channel; ?>" socket_num="5" pos="0">Off</button></td>
				<td><button type="button" id="switch" class="btn btn_yellow" channel_id="<?php echo $device_channel; ?>" socket_num="5" pos="1">On</button></td>
			</tr>
		</table>
	</div>

</body>
</html>