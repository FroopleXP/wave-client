<?php
	
	include("inc/main_menu.php");
	include("php/login_check.php");
	include("php/connect.php");

	$user_id = $_COOKIE['user_id'];
	$devices = null;
	$device_get = mysqli_query($db, "SELECT * FROM devices WHERE device_owner = '$user_id'");

	if (mysqli_num_rows($device_get) < 1) {
		$devices = "<tr><td>You haven't configured any devices yet!</td></tr><tr><td><a href='new_device.php'><button type='button' class='btn btn_yellow'>Get Started!</button></a></td></tr>";
	} else {
		while ($row = mysqli_fetch_array($device_get)) {
			$devices .= "<tr colspan='4' class='device_row'><td class='device_cell'>" . $row['device_name'] . "</td><td><a href='edit_device.php?dev_id=" . $row['device_id'] . "'>Edit</a></td><td><a href='php/delete_device.php?dev_id=" . $row['device_id'] . "'>Delete</a></td><td><a href='control.php?dev_id=" . $row['device_id'] . "'>Control</a></td></tr>";
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
		<h1>Dashboard</h1>
		<p>Welcome, <?php echo $_COOKIE['user_name']; ?></p>
	</div>
	<div class="page_container">
		<table class="table_container device_list">
			<tr>
				<td><h2>My Devices</h2></td>
			</tr>
			<?php echo $devices; ?>
		</table>
	</div>

</body>
</html>