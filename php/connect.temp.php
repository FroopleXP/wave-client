<?php
	
	$db = mysqli_connect("HOST", "USER", "PASS", "DB");

	if (!$db) {
			$page = "
				<div class='page_container_header'>
					<h1>Connection Error!</h1>
					<p>Sometimes things just don't work!</p>
				</div>
				<div class='page_container'>"
					. mysqli_connect_error() .
				"</div>
		";
		echo $page;
		exit();

	}

?>