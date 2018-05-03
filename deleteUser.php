<!--
  Last Modified: Spring 2018
  Function: Delete a user from the database
  Change Log: Added Page
-->
<?php

  include_once '../sql_connector.php';

  if(!empty($_POST)) {
    $UID = $_POST['UID'];

    $mysqli->query("DELETE FROM user_hardware_skills WHERE user_id = $UID");
    $mysqli->query("DELETE FROM user_software_skills WHERE user_id = $UID");
    $mysqli->query("DELETE FROM phone_list WHERE user_id = $UID");
    $mysqli->query("DELETE FROM group_members WHERE uid = $UID");
    $mysqli->query("DELETE FROM assigned_features WHERE user_id = $UID");
    $mysqli->query("DELETE FROM user WHERE UID = $UID");

    header("location: admin_user_info.php");
  }
  else {
    header("location: index.php");
  }

?>
