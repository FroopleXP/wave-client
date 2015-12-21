<?php
	
	include("inc/main_menu.php");
	include("login_check.php");

	if (isset($_GET['dev_id'])) {
		$dev_to_del = strip_tags($_GET['dev_id']);
		$user_id = $_COOKIE['user_id'];
		if (!is_numeric($dev_to_del)) {
			echo "Invalid Device ID";
			exit();
		} else {

			require('connect.php');
			$device_user = mysqli_query($db, "SELECT device_owner FROM devices WHERE `device_id` = $dev_to_del");
			$user_id_dev = mysqli_fetch_assoc($device_user);	

			if ($user_id_dev['device_owner'] != $user_id) {
				echo "That's not the way to be now is it...";
				exit();
			} else {
				$del_dev = mysqli_query($db, "DELETE FROM devices WHERE `device_id` = '$dev_to_del'");
				if (!$del_dev) {
					echo "There was an error, please try again.";
					exit();
				}
			}

		}
	} 

	header("Location: ../home.php");

?>