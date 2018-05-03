<!--
  Last Modified: Spring 2018
  Function: Adds POST user to POST Group
  Change Log: Restucted to new database
-->

<?php
	require_once('../../sql_connector.php');
?>

 <?php

	$uid = $_POST["user"];
	$gid = $_POST["group"];
	$level = $_POST["leader"];

	if ($level == "0") {
		$level = 0;
	}
	else {
		$level = 1;
	}


	$sql3 = "INSERT INTO group_members (group_id, uid, leader) VALUES('$gid', '$uid', '$level');";
	$result3 = $mysqli->query($sql3);

	header("location: ../groups.php");
?>
