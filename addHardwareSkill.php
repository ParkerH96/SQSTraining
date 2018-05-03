<!--
  Last Modified: Spring 2018
  Function: Add Hardware skill to Skills
  Change Log: Added Page
-->

<?php
	require_once('../sql_connector.php');

	if(!empty($_POST)){

		$skill = $mysqli->escape_string($_POST['hardskill']);

		$mysqli->query("INSERT INTO hardware_skills (skill) VALUES ('$skill')");

		header("location: admin_skills.php");
  }
	else {
		header("location: user_login.php");
	}

?>
