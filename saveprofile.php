<!--
  Last Modified: Spring 2018
  Function: Saves the users profile when submitted
  Change Log: Completely redone this page to function better
-->

<?php
	require_once('../sql_connector.php');

	if(!empty($_POST)){

		$UID						= $mysqli->escape_string($_POST['uid']);
		$firstname 			= $mysqli->escape_string($_POST['first_name']);
		$lastname 			= $mysqli->escape_string($_POST['last_name']);
		$email 					= $mysqli->escape_string($_POST['email']);
		$dob 						= $mysqli->escape_string($_POST['dob']);
		$gender 				= $mysqli->escape_string($_POST['gender']);
		$level					= $mysqli->escape_string($_POST['level']);
		$orgin					= $mysqli->escape_string($_POST['orgin']);
		$address				= $mysqli->escape_string($_POST['address']);
		$city 					= $mysqli->escape_string($_POST['city']);
		$state					= $mysqli->escape_string($_POST['state']);
		$zip						= $mysqli->escape_string($_POST['zip']);
		$softwareSkills = $_POST['personalss'];
		$hardwareSkills = $_POST['personalhs'];
		$phone_numbers = $_POST['phone_number'];
		$phone_ids = $_POST['phone_id'];

		foreach ($phone_numbers as $count => $pn) {
			$phone_id = $phone_ids[$count];
			if($phone_id < 0 && $pn != 'delete') {
				$mysqli->query("INSERT INTO phone_list(user_id, phone_number) VALUES ($UID, '$pn')");
			}
			else if ($phone_id < 0) {
				//do nothing
			}
			else if($pn != 'delete') {
				$mysqli->query("UPDATE phone_list SET phone_number = '$pn' WHERE id = $phone_id");
			}
			else {
				$mysqli->query("DELETE FROM phone_list WHERE id = $phone_id");
			}
		}

		if($_FILES["profile_photo"]["name"] != '') {
			//variables for uploading the profile photo
			$target_dir 		= "uploads/";
			$filename 			= basename($_FILES["profile_photo"]["name"]);
			$target_file 		= $target_dir . basename($_FILES["profile_photo"]["name"]);
			$uploadOk 			= 1;
			$imageFileType 	= pathinfo($target_file,PATHINFO_EXTENSION);

			if (!file_exists($target_file)) {
			  move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file);
			}

			$mysqli->query("UPDATE user SET first_name = '$firstname', last_name = '$lastname', dateofbirth = '$dob', gender = '$gender', Email = '$email', level = '$level', address = '$address', city = '$city', state = '$state', zip = '$zip', photo = '$filename'  WHERE UID = $UID");
		}
		else if(isset($_POST['first_name'])) {
			$mysqli->query("UPDATE user SET first_name = '$firstname', last_name = '$lastname', dateofbirth = '$dob', gender = '$gender', Email = '$email', level = '$level', address = '$address', city = '$city', state = '$state', zip = '$zip'  WHERE UID = $UID");
		}

		if(isset($_POST["personalss"]) && !empty($_POST["personalss"])) {
			$mysqli->query("DELETE FROM user_software_skills WHERE user_id = $UID");

			foreach ($softwareSkills as $value) {
				$mysqli->query("INSERT INTO user_software_skills (skill_id, user_id) VALUES ($value, $UID)");
			}
		}

		if(isset($_POST["personalhs"]) && !empty($_POST["personalhs"])){
			$mysqli->query("DELETE FROM user_hardware_skills WHERE user_id = $UID");

			foreach ($hardwareSkills as $value) {
				$mysqli->query("INSERT INTO user_hardware_skills (skill_id, user_id) VALUES ($value, $UID)");
			}
		}

		if($orgin == "1"){
			header("location: admin_user_info.php");
		}
		elseif ($orgin == "2") {
			header("location: user_register4.php");
		}
		elseif ($orgin == "9"){
			header("location: admin_user_info.php");
		}
		else {
			header("location: profile.php");
		}
	 }
	else
		header("location: user_login.php");
?>
