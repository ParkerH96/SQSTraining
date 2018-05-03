<!--
  Last Modified: Spring 2018
  Function: This file processes an administrator's request to demote a group leader back to mere group member.
						NOTE: if the user or the group entered does not actually exist, no error message is given. Nothing happens to the database when there is such a SQL error.
  Change Log: Restucted to new database
-->

<?php
	require_once('../../sql_connector.php');

	$uid = $_POST["user"];
	$gid = $_POST["group"];


	//Finally, demote the account from its leadership position.
	//Check if the account belongs to the group
	$sql3 = "SELECT * FROM group_members WHERE group_id='$gid' AND uid='$uid';";
	$result3 = $mysqli->query($sql3);
	//If the account does not belong to the group, add the user before promoting
	if($result3->num_rows > 0)
	{
		$sql4 = "UPDATE group_members SET leader = 1 WHERE group_id='$gid' AND uid='$uid';";
		$result4 = $mysqli->query($sql4);
	}

	header("location: ../groups.php")

?>
