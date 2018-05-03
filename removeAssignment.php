<!--
  Last Modified: Spring 2018
  Function: Remove an Assignment from either a group or user
  Change Log: Added Page
-->
<?php
  require_once('../sql_connector.php');

  if(!empty($_POST)) {

    $assignment_id = $mysqli->escape_string($_POST['assignment_id']);

    if($_POST['assignment_type'] == 'user') {
        $mysqli->query("DELETE FROM assigned_features WHERE id = $assignment_id");
    }
    else {
        $mysqli->query("DELETE FROM assigned_group_features WHERE id = $assignment_id");
    }

    header("location: user_features.php");

  }
  else {
    header("location: user_login.php");
  }

?>
