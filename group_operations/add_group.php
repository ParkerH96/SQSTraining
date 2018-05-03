<!--
  Last Modified: Spring 2018
  Function: Creates POST Group to database
  Change Log: Restucted to new database
-->

<?php
	require_once('../../sql_connector.php');
?>

 <?php

	$group_name = $_POST["group_name"];

	$sql3 = "INSERT INTO groups (name) VALUES ('$group_name');";
	$result3 = $mysqli->query($sql3);

	header("location: ../groups.php");
?>
