<!--
  Last Modified: Spring 2018
  Function: This file removes a group and the users assigned to it
  Change Log: Restucted to new database
-->


<?php
	require_once('../../sql_connector.php');
?>

 <?php

	$gid = $_POST["group"];

  $sql3 = "DELETE FROM group_members WHERE group_id = '$gid'";
	$result3 = $mysqli->query($sql3);

	$sql3 = "DELETE FROM groups WHERE UID = '$gid'";
	$result3 = $mysqli->query($sql3);

	header("location: ../groups.php");
?>
