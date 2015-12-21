<?php

	if(isset($_COOKIE["user_id"]) && isset($_COOKIE["user_name"])) {
		setcookie("user_id", '', strtotime( '-5 days' ), '/');
	    setcookie("user_name", '', strtotime( '-5 days' ), '/');
	}

	header("Location: login.php");

?>