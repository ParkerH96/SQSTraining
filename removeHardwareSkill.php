<!--
  Last Modified: Spring 2018
  Function: Removes Hardware skill from Skills and removes it from any user that had it
  Change Log: Added Page
-->

<?php
	require_once('../sql_connector.php');

	if(!empty($_POST)){

		$skills = $_POST['hardwareskills'];

		foreach ($skills as $key) {
			$mysqli->query("DELETE FROM user_hardware_skills WHERE skill_id = '$key'");

			$mysqli->query("DELETE FROM hardware_skills WHERE UID = '$key'");
		}

		header("location: admin_skills.php");
  }
	else {
		header("location: user_login.php");
	}
?>
