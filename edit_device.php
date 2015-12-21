<?php
	
	include("inc/main_menu.php");
	include("php/login_check.php");
	include("php/connect.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>WAVE - Home</title>
</head>
<body>

	<div class="page_container_header">
		<h1>Edit Device</h1>
		<p>Correctingz the Settingz</p>
	</div>
	<div class="page_container">
		<form method="POST" action="new_device.php">
			<table class="table_container">
				<tr><h2>Editing "<?php echo $device_name; ?>"</h2></tr>
				<tr colspan="2">
					<td>Device name</td>
					<td><input type="text" name="dev_name" placeholder="Name your Minlet" value="<?php echo $dev_name; ?>"></td>
				</tr>
				<tr colspan="2">
					<td>Device ID</td>
					<td><input type="text" name="dev_id" placeholder="Channel ID" class="uppercase" value="<?php echo $dev_channel; ?>"></td>
				</tr>
				<tr colspan="2">
					<td></td>
					<td><button type="submit" name="save" class="btn btn_red">Save</button></td>
				</tr>
			</table>
		</form>
	</div>

</body>
</html>