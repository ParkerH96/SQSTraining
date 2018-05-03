<!-- /**
This file is where users can create accounts.
Accounts created on this page are automically given a ranking of "3", which is simply an account without administrative privileges (further distinctions between account rankings may be given in the future).
Only the name, email, and password information must be created to create an account.
Errors will not be introduced to this page any time soon because specific errors can currently only be associated with users who are logged in.
*/ -->
<?php ob_start();
    include 'config/header.php'; //connects to database
    require_once('../sql_connector.php');
 ?>
<!DOCTYPE html>
<html>
    <div class="container">
        <div class="form-horizontal" id="centerbox">
          <?php //A progress bar that will show the progress of the users registration ?>
        Registration Progress
        </div>
        <div class="progress">
        <div id="ProgressBarReg1"class="progress-bar progress-bar-striped active" role="progressbar"
        	aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
        </div>

        <div class="login">
            <?php
            //Start of code for user registration page 1 in SQL
            if(isset($_POST['submit'])) {		//waits for buttons press
              $EmailError = False;
              $passwordError = False;
              $passwordsMatch = False;
              $NameError = False;

              $url = 'user_register2.php';

              //makes sure that pasword and email aren't sql queries
              if (preg_match('%[A-Za-z0-9\.\-\$\@\$\!\%\*\#\?\&]%', stripslashes(trim($_POST['password'])))) {
                  if($_POST['password'] == $_POST['confirmpassword']){
              		    $passwordsMatch = True;
                  }
            	    $password = $mysqli->real_escape_string(trim($_POST['password']));
                  $password = hash("sha256", $password);
              }
              else
                  $passwordError = True;

              if (preg_match('%[A-Za-z0-9]+@+[A-Za-z0-9]+\.+[A-Za-z0-9]%', stripslashes(trim($_POST['email']))))
                  $email = $mysqli->real_escape_string(trim($_POST['email']));
              else
                  $EmailError = True;

              if (preg_match('%^[a-zA-Z ]+$%', stripslashes(trim($_POST['first_name']))))
                  $first_name = $mysqli->real_escape_string(trim($_POST['first_name']));
              else
                  $NameError = True;

              if (preg_match('%^[a-zA-Z ]+$%', stripslashes(trim($_POST['last_name']))))
                  $last_name = $mysqli->real_escape_string(trim($_POST['last_name']));
              else
                  $NameError = True;

            	//updates info

              if($passwordsMatch == False) { ?>
                  <div class="alert alert-danger">Error: You did not type the same password twice.</div>
                  <?php
              }
              else if ($passwordError == False and $EmailError == False and $NameError == False) {

            	//Create a new user account with the mandatory information
                $results = $mysqli->query("INSERT INTO user (first_name, last_name, Password, Email) VALUES ('$first_name','$last_name', '$password', '$email');");

        		//If the account was successfully created, log the user into the new account
        		if ($results) {
        			$sql = "SELECT * FROM user WHERE Email=\"".$email."\";";
        			$result = $mysqli->query("SELECT * FROM user WHERE Email= '$email';");
        			$UID = -1;

        			if($result->num_rows > 0){
        				while($row = $result->fetch_assoc()){
                  session_start();
                  $_SESSION['level'] = $row["level"];
                  $_SESSION['priv'] = '1'; //delete soon
                  $_SESSION['name'] = $row["first_name"];
      			      $_SESSION['user'] = $row["UID"];
                }
              }
              header("location: user_register2.php");
        		}
        		else { ?>
        		 	<div class="alert alert-danger">Darn! that email is taken :( Try another!</div>
        		 <?php
                }
              }
        	  else { ?>
                <div class="alert alert-danger">Invalid Credentials please try again</div>
        	       <?php
              }
            }
            //End of user registration page 1 sql commands
            ?>
            <form  id="RegForm1" name="registerform" method="post">
                <div class="container-fluid">
                  <br><h5 id="SignUpWelcomeHead">Welcome to the SQS Training Site, please sign up.</h5><br>
                  <img src="/assets/images/logo.png" alt="" style="width:50%;display:block;margin-left:auto;margin-right:auto;"><br>
                	<div class="row">
                        <div class="col-md-6">
                            <label for="first_Name">First Name:</label><br>
                    		<input class="form-control" type="text" name="first_name" size="30" id="SignupFirstName" maxlength="50" placeholder="First Name" autofocus autocomplete="name"/><br>
                        </div>
                		<div class="col-md-6">
                            <label for="last_name">Last Name:</label><br>
                    		<input class="form-control" type="text" name="last_name" size="30" id="SignupLastName" maxlength="50" placeholder="Last Name" autocomplete="family-name"/><br>
                        </div>
                	</div>
                	<div class="row">
                        <div class="col-md-12">
                      		<label for="email">Email:</label><br>
                      		<input class="form-control" type="text" name="email" size="30" id="SignupEmail" maxlength="30" placeholder="Email" autocomplete="email"/><br>
                        </div>
                	</div>
                	<div class="row">
                		<div class="col-md-6">
                			<label for="signup_Password">Password:</label><br>
                			<input class="form-control" type="password" name="password" size="30" id="signup_Password" maxlength="30" placeholder="Password"/><br>
                		</div>
                		<div class="col-md-6">
                			<label for="signup_ConfirmPass">Confirm Password:</label><br>
                			<input class="form-control" type="password" name="confirmpassword" size="30" id="signup_ConfirmPass" maxlength="30" placeholder="Confirm Password" autocomplete="off"/><br>
                		</div>
                	</div>
                    <div class="row">
                      <div class="col-md-12">
                        <br>
                        <input class="btn btn-primary" type="submit" name="submit" value="Register" id="signup_Submit"/>
                      </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</html>
