<!--
  Last Modified: Spring 2018
  Function: Add an Assignment of a Feature to either a group or user
  Change Log: Added Page
-->
<?php
  require_once('../sql_connector.php');

  if(!empty($_POST)) {

    $feature_id = $mysqli->escape_string($_POST['feature_select']);
    $assign_type = $_POST['group_user_select'][0];
    $assignment_id = $mysqli->escape_string(substr($_POST['group_user_select'], 1));

    if($assign_type == 'u') {
      $mysqli->query("INSERT INTO assigned_features (feature_number, user_id) VALUES ($feature_id, $assignment_id)");
    } else {
      $mysqli->query("INSERT INTO assigned_group_features(feature_number, group_id) VALUES ($feature_id, $assignment_id)");
    }

    header("location: user_features.php");
  }
  else {
    header("location: user_login.php");
  }

?>
