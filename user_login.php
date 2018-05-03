<!--
  Last Modified: Spring 2018
  Function: Controls the initial login for a user
  Change Log: Modified page to add new session variables
-->

<?php ob_start();
include 'config/header.php'; //connects to data base
include "footer.php";
require_once('../sql_connector.php');?>

<html>
<div class="login">
  <?php

  if(isset($_POST['submit'])) {          //waits for button press
      $EmailError = False;
      $passwordError = False;

      //makes sure password and email aren't sql queries
      if (preg_match('%[A-Za-z0-9\.\-\$\@\$\!\%\*\#\?\&]%', stripslashes(trim($_POST['password'])))) {
          $password = $mysqli->real_escape_string(trim($_POST['password']));
          $password  = hash("sha256", $password);
      }
      else {
          $passwordError = True;
      }

      if (preg_match('%[A-Za-z0-9]+@+[A-Za-z0-9]+\.+[A-Za-z0-9]%', stripslashes(trim($_POST['email'])))) {
          $email = $mysqli->real_escape_string(trim($_POST['email']));
      }
      else {
          $EmailError = True;
      }

      //updates info
      if ($passwordError == False and $EmailError == False) {

          $user = $mysqli->query("SELECT UID, first_name, level FROM user WHERE email = '$email' AND password = '$password'");

          if ($user->num_rows == 1) {
            while ($row = $user->fetch_assoc()) {
              $previousSession = $mysqli->query("SELECT * FROM session_users WHERE user_id = '" . $row['UID'] . "'");
              if($previousSession->num_rows == 1){
                while($row1 = $previousSession->fetch_assoc()){
                  $previousSessionID = $row1['session_id'];
                  $mysqli->query("DELETE FROM session_users WHERE session_id = '$previousSessionID'");

                  session_start();
                  $current_session_id = session_id();
                  session_commit();

                  session_id($previousSessionID);
                  session_start();
                  session_destroy();
                  session_commit();

                  session_id($current_session_id);
                  session_start();
                }
              }
              else {
                session_start();
              }

              $current_session_id = session_id();

              //Added Spring 2018 to create new session variables that can be used throughout a user's login
              $UID = $row["UID"];
              $_SESSION['user'] = $row["UID"];
              $_SESSION['name'] = $row["first_name"];
              $_SESSION['level'] = $row["level"];
            }

              $mysqli->query("INSERT INTO `session_users` (`session_id`, `user_id`) VALUES ('$current_session_id','$UID')");

              header("location:index.php");
          }
          else { ?>
            <div class="alert alert-danger">Invalid Log in Please go back and try again</div>
          <?php }

      }
      else { ?>
        <div class="alert alert-danger">Invalid Log in Please go back and try again</div>
      <?php }
  }
  ?>
	  <form method="post" action="">
        <br><h5 id="LogInWelcomeHead">Welcome to the SQS Training Site, please log in.</h5><br>
        <img id="LogInImage" src="/assets/images/logo.png" alt="" style="width:50%;display:block;margin-left:auto;margin-right:auto;"><br>
	      <label for="email_Signin">Email:</label><br>
	     	<input class="form-control" type="email" name="email" placeholder="Email" maxlength="30" id="email_Signin" autofocus autocomplete="email"/><br>

	    	<label for="password">Password:</label><br>
	      <input class="form-control" type="password" name="password" placeholder="Password" maxlength="30" id="password_Signin"/>

        <input class="btn btn-success" type="submit" name="submit" value="Sign in" id="submit_Signin"/>
	  </form>
	</div>

</html>
