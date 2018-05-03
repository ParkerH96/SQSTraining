<!--
  Last Modified: Spring 2018
  Function: Add a Feature to the database
  Change Log: Added Page
-->
<?php
  require_once('../sql_connector.php');

  if(!empty($_POST)) {

    $name         = $mysqli->escape_string($_POST['name']);
    $description  = $mysqli->escape_string($_POST['description']);
    $file         = basename($_FILES["file"]["name"]);
    $target       = $mysqli->escape_string($_POST['target']);

    $target_dir 		= "features/";
    $uploadOk 			= 1;
    $target_file 		= $target_dir . basename($_FILES["file"]["name"]);

    if (!file_exists($target_file)) {
      move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
    }

    $mysqli->query("INSERT INTO features_available (name, description, file, target) VALUES ('$name', '$description', '$file', '$target')");

    header("location: user_features.php");
  }
  else {
    header("location: user_login.php");
  }
?>
