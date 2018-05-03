<!-- /**
This file is where users can create accounts.
Accounts created on this page are automically given a ranking of "3", which is simply an account without administrative privileges (further distinctions between account rankings may be given in the future).
Only the name, email, and password information must be created to create an account.
Errors will not be introduced to this page any time soon because specific errors can currently only be associated with users who are logged in.
*/ -->

<?php
	include 'config/header.php'; //connects to database
	require_once('../sql_connector.php');
?>

<!-- <div class='container' id='error_success'>Account creation successful. Please continue with registration.</div> -->
<div class="alert alert-success">Account creation successful. Please continue with registration.</div>

<?php
	// If the user fills out any forms this saves the information in a SESSION variable
	//	to be used to retain information on pages when refreshed.
	if(isset($_POST['dob'])) {
		$_SESSION['dob'] = $_POST['dob'];
	}

	if(isset($_POST['phone_number'])) {
		$_SESSION['phone_number'] = $_POST['phone_number'];
	}

	if(isset($_POST['state'])) {
		$_SESSION['state'] = $_POST['state'];
	}

	if(isset($_POST['city'])) {
		$_SESSION['city'] = $_POST['city'];
	}

	if(isset($_POST['zip'])) {
		$_SESSION['zip'] = $_POST['zip'];
	}

	if(isset($_POST['streetname'])) {
		$_SESSION['streetname'] = $_POST['streetname'];
	}

	if(isset($_POST['streetnumber'])) {
		$_SESSION['streetnumber'] = $_POST['streetnumber'];
	}

if(isset($_POST['submit'])) {		//waits for buttons press
	//Add the optional information, if available
	//Add optional user information
	$url = 'user_register3.php';

	//Gender
	$sql = "UPDATE user SET gender=\"".$_POST['gender']."\" WHERE uid=".$_SESSION['ID'].";";
	$result = $mysqli->query($sql);

	//Date of birth
	$dateofbirth = $_POST["yearofbirth"]."-".$_POST["monthofbirth"]."-".$_POST["dayofbirth"];
	$sql = "UPDATE user SET dateofbirth='".$dateofbirth."' WHERE uid=".$_SESSION['ID'].";";
	$result = $mysqli->query($sql);

	//Phone information
	$sql = "INSERT INTO phone_list(user_id, phone_number, primary_phone) VALUES(".$_SESSION['ID'].", ".$_POST["phone_number"].", 1)";
	$result = $mysqli->query($sql);

	//Add optional address information
	$sql = "INSERT INTO mail_address(user_id) VALUES(".$_SESSION['ID'].")";
	$result = $mysqli->query($sql);

	$sql = "UPDATE mail_address SET state=\"".$_POST["state"]."\" WHERE user_id=".$_SESSION['ID'].";";
	$result = $mysqli->query($sql);

	$sql = "UPDATE mail_address SET city=\"".$_POST["city"]."\" WHERE user_id=".$_SESSION['ID'].";";
	$result = $mysqli->query($sql);

	$sql = "UPDATE mail_address SET zip=".$_POST["zip"]." WHERE user_id=".$_SESSION['ID'].";";
	$result = $mysqli->query($sql);

	$sql = "UPDATE mail_address SET street=\"".$_POST["streetname"]."\" WHERE user_id=".$_SESSION['ID'].";";
	$result = $mysqli->query($sql);

	$sql = "UPDATE mail_address SET street_num=".$_POST["streetnumber"]." WHERE user_id=".$_SESSION['ID'].";";
	$result = $mysqli->query($sql);

	header("location: $url");
}
//End of user registration page 2 sql commands
?>

<html>
	<div class="container">
		<div class="form-horizontal" id="centerbox">
			<?php //A progress bar that will show the progress of the users registration ?>
			Registration Progress
		</div>
		<div class="progress">
			<div  id="ProgressBarReg2" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="29" aria-valuemin="0" aria-valuemax="100" style="width:29%"></div>
		</div>
		<div class="login" id="register2">
	    <form action="" id="RegForm2" method="post">
				<label style="text-align: center;" class="control-label col-sm-12">Optional, may leave this page blank</label>
				<br>
				<br>
				<div class="row">
					<div class="col-md-6">
							<label for="gender">Gender:</label><br>
							<div class="radio">
							  <label><input type="radio" name="gender" value="Female" id="radiobtn_Female"/>&nbsp;Female</label>
							</div>
							<div class="radio">
							  <label><input type="radio" name="gender" value="Male" id="radiobtn_Male"/>&nbsp;Male</label>
							</div>
							<div class="radio">
							  <label><input type="radio" name="gender" value="Other" id="radiobtn_Other"/>&nbsp;Other</label>
							</div>
							<br/>
					</div>
					<div class="col-md-6">
							<label for="dob">Date of Birth:</label><br>
						<input class="form-control" type="date" name="dob" size="30" id="signup_DOB" value="<?php echo isset($_SESSION['dob']) ? $_SESSION['dob'] : ''; ?>"/>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-6">
							<label for="phone_number">Primary Phone:</label><br>
							<input class="form-control" type="tel" name="phone_number" maxlength="10" id="signup_PhoneNumber" value="<?php echo isset($_SESSION['phone_number']) ? $_SESSION['phone_number'] : ''; ?>"/>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-6">
							<label for="gender">Street Number:</label><br>
							<input class="form-control" type="number" name="streetnumber" size="10" id="signup_StreetNumber" maxlength="15" value="<?php echo isset($_SESSION['streetnumber']) ? $_SESSION['streetnumber'] : ''; ?>"/>
					</div>
					<div class="col-md-6">
							<label for="streetname">Street Name:</label><br>
							<input class="form-control" type="text" name="streetname" size="30" id="signup_StreetName" maxlength="50" value="<?php echo isset($_SESSION['streetname']) ? $_SESSION['streetname'] : ''; ?>"/>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-4">
							<label for="city">City:</label><br>
							<input class="form-control" type="text" name="city" size="30" id="signup_City" maxlength="50" value="<?php echo isset($_SESSION['city']) ? $_SESSION['city'] : ''; ?>"/>
					</div>
					<div class="col-md-4">
							<label for="state">State:</label><br>
							<select class="form-control" name="state" id="signup_State">
								<option value="AL">Alabama</option>
								<option value="AK">Alaska</option>
								<option value="AZ">Arizona</option>
								<option value="AR">Arkansas</option>
								<option value="CA">California</option>
								<option value="CO">Colorado</option>
								<option value="CT">Connecticut</option>
								<option value="DE">Delaware</option>
								<option value="DC">District Of Columbia</option>
								<option value="FL">Florida</option>
								<option value="GA">Georgia</option>
								<option value="HI">Hawaii</option>
								<option value="ID">Idaho</option>
								<option value="IL">Illinois</option>
								<option value="IN">Indiana</option>
								<option value="IA">Iowa</option>
								<option value="KS">Kansas</option>
								<option value="KY">Kentucky</option>
								<option value="LA">Louisiana</option>
								<option value="ME">Maine</option>
								<option value="MD">Maryland</option>
								<option value="MA">Massachusetts</option>
								<option value="MI">Michigan</option>
								<option value="MN">Minnesota</option>
								<option value="MS">Mississippi</option>
								<option value="MO">Missouri</option>
								<option value="MT">Montana</option>
								<option value="NE">Nebraska</option>
								<option value="NV">Nevada</option>
								<option value="NH">New Hampshire</option>
								<option value="NJ">New Jersey</option>
								<option value="NM">New Mexico</option>
								<option value="NY">New York</option>
								<option value="NC">North Carolina</option>
								<option value="ND">North Dakota</option>
								<option value="OH">Ohio</option>
								<option value="OK">Oklahoma</option>
								<option value="OR">Oregon</option>
								<option value="PA">Pennsylvania</option>
								<option value="RI">Rhode Island</option>
								<option value="SC">South Carolina</option>
								<option value="SD">South Dakota</option>
								<option value="TN">Tennessee</option>
								<option value="TX">Texas</option>
								<option value="UT">Utah</option>
								<option value="VT">Vermont</option>
								<option value="VA">Virginia</option>
								<option value="WA">Washington</option>
								<option value="WV">West Virginia</option>
								<option value="WI">Wisconsin</option>
								<option value="WY">Wyoming</option>
							</select>
					</div>
					<div class="col-md-4">
							<label for="zip">Zip:</label><br>
							<input class="form-control" type="text" pattern="\d*" maxlength="5" name="zip" id="signup_Zip" value="<?php echo isset($_SESSION['zip']) ? $_SESSION['zip'] : ''; ?>"/>
					</div>
				</div>
				<br>
				<div class="form-group" id="centerbox">
					<div class="control-label col-sm-6">
						<input class="btn btn-default" type="submit" name="submit" value="Next" id="signup_Next1"/>
					</div>
				</div>
	    </form>
		</div>
	</div>
</html>
