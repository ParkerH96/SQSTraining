<!--
  Last Modified: Spring 2018
  Function: Removes Software skill from Skills and removes it from any user that had it
  Change Log: Added Page
-->

<?php
	require_once('../sql_connector.php');

	if(!empty($_POST)){

		$skills = $_POST['softwareskills'];



		foreach ($skills as $key) {
			$mysqli->query("DELETE FROM user_software_skills WHERE skill_id = '$key'");

			$mysqli->query("DELETE FROM software_skills WHERE UID = '$key'");
		}

		header("location: admin_skills.php");
  }
	else {
		header("location: user_login.php");
	}

?>
