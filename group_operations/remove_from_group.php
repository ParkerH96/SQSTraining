<!--
  Last Modified: Spring 2018
  Function: This file processes administrator and superuser's requests to add users to groups. Rather than performing a single command with the use of joined tables, it adds users by performing three seperate SQL commands.
						NOTE: if the user or the group entered does not actually exist, no error message is given. Nothing happens to the database when there is such a SQL error.
  Change Log: Restucted to new database
-->

<?php
	require_once('../../sql_connector.php');
	
	$uid = $_POST["user"];
	$gid = $_POST["group"];

	$sql3 = "DELETE FROM group_members WHERE uid = '$uid' AND group_id = '$gid'";
	$result3 = $mysqli->query($sql3);

	header("location: ../groups.php");
?>
