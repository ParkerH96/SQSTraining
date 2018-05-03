<!--
  Last Modified: Spring 2018
  Function: this page presents information describing the logged in user
  Change Log: Redone page to look and function correctly
-->

<?php
	include 'config/header.php';
	require_once('../sql_connector.php');
	require_once('../feature_connector.php');
	if (!isset($_SESSION['user'])){	//redirects to index page if user isn't a user
	    header('location:index.php');
	}
?>

<script type=text/javascript src="/sqsg6/Training_site/assets/js/jquery.min.js"></script>
<html>
	<body>
		<div class="container">
			<form class="form-horizontal" id="saveProfileForm" action="saveprofile.php" method="post" enctype="multipart/form-data">
				<?php
					$UID = $_SESSION['user'];
					$stmt = $mysqli->prepare("SELECT first_name, last_name, password, Email, level, gender, dateofbirth, address, city, state, zip, photo FROM user WHERE UID = ?");
					$stmt->bind_param("s",$UID);
					$stmt->execute();
					$stmt->bind_result($firstname, $lastname, $password, $email, $level, $gender, $dateofbirth, $address, $city, $state, $zip, $photo);
					$stmt->fetch();
					$stmt->close();

					$stmt = $mysqli->prepare("SELECT title FROM levels WHERE id = ?");
					$stmt->bind_param("s",$level);
					$stmt->execute();
					$stmt->bind_result($rank);
					$stmt->fetch();
					$stmt->close();
				?>

				<h2 id="PersInfoHead">Personal Information</h2>
				<hr>
				<h3 style="text-align: center;" id="ProfProgHead">Profile Progress</h3>
				<div class="progress">
					<?php
						$blank_fields = 0;
						if( $firstname == 'NULL' || $firstname == '' ){ $blank_fields++; }
						if( $lastname == 'NULL' || $lastname == '' ){ $blank_fields++; }
						if( $password == 'NULL' || $password == '' ){ $blank_fields++; }
						if( $email == 'NULL' || $email == '' ){ $blank_fields++; }
						if( $level == 'NULL' || $level == '' ){ $blank_fields++; }
						if( $gender == 'NULL' || $gender == '' ){ $blank_fields++; }
						if( $dateofbirth == 'NULL' || $dateofbirth == '0000-00-00' ){ $blank_fields++;}
						if( $address == 'NULL' || $address == '' ){ $blank_fields++; }
						if( $city == 'NULL' || $city == '' ){ $blank_fields++; }
						if( $state == 'NU' || $state == NULL || $state == '' ){ $blank_fields++; }
						if( $zip == 'NULL' || $zip == '0' || $zip == 0 ){ $blank_fields++; }
						if( $photo == 'NULL' || $photo == NULL || '' ) { $blank_fields++; }

						$p_hardware_skills = $mysqli->query("SELECT * FROM user_hardware_skills WHERE user_id = $UID");
						$p_software_skills = $mysqli->query("SELECT * FROM user_software_skills WHERE user_id = $UID");
						$p_phone_numbers = $mysqli->query("SELECT * FROM phone_list WHERE user_id = $UID");

						if( $p_phone_numbers->num_rows == 0 ) { $blank_fields++; }
						if( $p_hardware_skills->num_rows == 0 ) { $blank_fields++; }
						if( $p_software_skills->num_rows == 0 ) { $blank_fields++; }

						$progress = round(((15 - $blank_fields) / 15) * 100);

						$mysqli->query("UPDATE user SET progress = $progress WHERE UID = $UID");

						$pbar_type = '';
						if( $progress < 40 ) {
							$pbar_type = 'danger';
						} else if($progress < 80) {
							$pbar_type = 'warning';
						} else {
							$pbar_type = 'success';
						}
					?>
  				<div id="userProg" class="progress-bar <?php if($progress < 100){ ?> progress-bar-striped <?php } ?> bg-<?php echo $pbar_type; ?>" <?php if($progress != 0) { echo 'style="width:' . $progress . '%"'; } ?> role="progressbar" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
						<?php
							if($progress != 0) {
								echo $progress . '%';
							}
						?>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="form-group col-sm-4">
						<div class="profile-labels">
							<label class="control-label" >Photo&emsp;</label>
						</div>
						<div class="profile-inputs">
							<img src="/uploads/<?php echo $photo ?>" alt="Profile Photo" height="175" width="175">&emsp;<br><br>
						</div>
					</div>
					<div class="col-sm-4">
						<input class="form-control" type="File" id="ProfilePhoto" hidden name="profile_photo" disabled><br><br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="profile-labels">
							<label class="control-label">First Name</label><br><br>
							<label class="control-label" style="padding-top: 12px;">Last Name</label><br><br>
							<label class="control-label" style="padding-top: 12px;">Email</label><br><br>
						</div>
						<div class="profile-inputs">
							<?php feature_loader("namedisplay", $_SESSION['user']); ?>

							<input class="form-control" id="Email" type="email" name="email" maxlength="30" value="<?php echo $email ?>" disabled><br><br>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="profile-labels">
							<label class="control-label">Rank</label><br><br>
							<label class="control-label" style="padding-top: 12px;">Gender</label><br><br>
							<label class="control-label" style="padding-top: 12px;">Password</label><br><br>
						</div>
						<div class="profile-inputs">
							<input class="form-control" id="Rank" type="text" name="rank" value="<?php echo $rank; ?>" readonly disabled><br>
							<select class="form-control" id="Gender" name="gender" disabled>
								<option value="NULL" <?php if($gender == NULL) { ?> selected <?php } ?>>Select One</option>
								<option value="Male" <?php if($gender == "Male") { ?> selected <?php } ?>>Male</option>
								<option value="Female" <?php if($gender == "Female") { ?> selected <?php } ?>>Female</option>
								<option value="Other" <?php if($gender == "Other") { ?> selected <?php } ?>>Other</option>
							</select><br>
							<input class="form-control" id="Password" type="password" name="password" value="*********" disabled><br><br>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="profile-labels">
							<label class="control-label">Birthday</label><br><br>
						</div>
						<div class="profile-inputs">
							<input class="form-control" id="DOB" type="date" name="dob" value="<?php echo $dateofbirth ?>" disabled><br><br>
						</div>
					</div>
					<br>
				</div>

				<input class="form-control" id="UserID" type="text" name="uid" value="<?php echo $UID ?>" hidden>
				<div class="row">
					<?php
						//Load group information
						feature_loader("groupdisplay", $_SESSION["user"]);

						//Load phone information
						feature_loader("phonedisplay", $_SESSION["user"]);
						?>
						</div>
						<br>
						<div class="row">
						<?php
						//Load address information
						// within the feature loader file for mailing address specific attention is
						// paid to displaying child elements of the mailing header.
						feature_loader("addressdisplay", $_SESSION["user"]);
					?>
				</div>
				<br>
				<h3 id="SoftSkilHead">Software Skills</h3>
				<hr>
				<div class="software-skills-bank">
					<label>Skill Bank</label>
				  <select multiple="multiple" id='lstBoxSoftware1' class="form-control" disabled>
						<?php
							$softSkills = $mysqli->query("SELECT * FROM software_skills ss WHERE NOT EXISTS (SELECT * FROM user_software_skills uss WHERE uss.skill_id = ss.uid AND uss.user_id = ".$_SESSION['user'].");");
							while ($row = $softSkills->fetch_assoc())
								echo '<option value="'.$row['UID'].'">'.$row['skill'].'</option>';
						 ?>
				  </select>
				</div>
				<div class="software-skills-arrows text-center">
				  <input type="button" id="SoftwarebtnAllRight" value=">>" class="btn btn-default" disabled/><br />
				  <input type="button" id="SoftwarebtnRight" value=">" class="btn btn-default" disabled/><br />
				  <input type="button" id="SoftwarebtnLeft" value="<" class="btn btn-default" disabled/><br />
				  <input type="button" id="SoftwarebtnAllLeft" value="<<" class="btn btn-default" disabled/>
				</div>
				<div class="software-skills-personal">
					<label>Your Skills</label>
				  <select multiple="multiple" name="personalss[]" id='lstBoxSoftware2' class="form-control" disabled>
						<?php
							$persSoftSkills = $mysqli->query("SELECT ss.*, uss.skill_id, uss.user_id FROM software_skills AS ss LEFT JOIN user_software_skills AS uss ON ss.UID = uss.skill_id WHERE uss.user_id = ".$_SESSION['user'].";");
							while ($row = $persSoftSkills->fetch_assoc())
								echo '<option value="'.$row['UID'].'">'.$row['skill'].'</option>';
						 ?>
				  </select>
				</div>
				<div class="clearfix"></div>
				<br>


				<h3 id="HardSkilHead">Hardware Skills</h3>
				<hr>
				<div class="hardware-skills-bank">
					<label>Skill Bank</label>
				  <select multiple="multiple" id='lstBoxHardware1' class="form-control" disabled>
						<?php
							$hardSkills = $mysqli->query("SELECT * FROM hardware_skills ss WHERE NOT EXISTS (SELECT * FROM user_hardware_skills uss WHERE  uss.skill_id = ss.uid AND uss.user_id = ".$_SESSION['user'].");");
							while ($row = $hardSkills->fetch_assoc())
								echo '<option value="'.$row['UID'].'">'.$row['skill'].'</option>';
						 ?>
				  </select>
				</div>
				<div class="hardware-skills-arrows text-center">
				  <input type="button" id="HardwarebtnAllRight" value=">>" class="btn btn-default" disabled/><br />
				  <input type="button" id="HardwarebtnRight" value=">" class="btn btn-default" disabled/><br />
				  <input type="button" id="HardwarebtnLeft" value="<" class="btn btn-default" disabled/><br />
				  <input type="button" id="HardwarebtnAllLeft" value="<<" class="btn btn-default" disabled/>
				</div>
				<div class="hardware-skills-personal">
					<label>Your Skills</label>
				  <select multiple="multiple" id='lstBoxHardware2' name="personalhs[]" class="form-control" disabled>
						<?php
							$persHardSkills = $mysqli->query("SELECT ss.*, uss.skill_id, uss.user_id FROM hardware_skills AS ss LEFT JOIN user_hardware_skills AS uss ON ss.UID = uss.skill_id WHERE uss.user_id = ".$_SESSION['user'].";");
							while ($row = $persHardSkills->fetch_assoc())
								echo '<option value="'.$row['UID'].'">'.$row['skill'].'</option>';
						 ?>
				  </select>
				</div>
				<div class="clearfix"></div>
				<br>
				<input id="SubmitProfile" type="submit" name="Save" value="Save" class="btn btn-success" style="float:right;" disabled>
				<button id="EditProfile" type="button" name="editprofile" class="btn btn-primary" style="float:right;margin-right:5px;">Edit</button>
				<input type="text" name="orgin" value="0" style="display:none;">
				<input type="text" id="UserLevel"name="level" value="<?php echo $level; ?>" style="display:none;">
			</form>
		</div>
		<div style="padding-top:5rem;"></div>
	</body>
	<?php
	  include "footer.php";
	 ?>
</html>

<script>
	$('.deletePN').on('click', function(){
		console.log('hi');
		let id = $(this).data('id');

		$('#phone_number' + id).css("display", "none");
		$('#phone_number' + id).val('delete');
		$(this).css("display", "none");
	});
	$('#addPhoneNumber').on('click', function() {
		let inputs = $('#pn-container').find($("input"));
		let new_id_num = (inputs.length / 2);
		$('#pn-container').append('<div><input style="display: none;" type="number" value="-1" name="phone_id[]">');
		$("#pn-container").append('<input id="phone_number' + new_id_num + '" type="text" class="phone-numbers" name="phone_number[]" value="New Number"> <button type="button" style="display: inline; height: 30px; margin-bottom: 4px;" data-id="' + new_id_num + '" class="deletePN btn btn-danger btn-sm"><i class="fas fa-minus"></i></button></div>');

		$('.deletePN').on('click', function(){
			console.log('hi');
			let id = $(this).data('id');

			$('#phone_number' + id).css("display", "none");
			$('#phone_number' + id).val('delete');
			$(this).css("display", "none");
		});
	});
	$("#EditProfile").on('click', function() {
		$("#ProfilePhoto").css("display", "inline-block");
		$('#addPhoneNumber').css("display", "block");
		$('.deletePN').css("display", "inline");
		$('.phone-numbers').removeAttr("disabled");
		document.getElementById("ProfilePhoto").disabled = false;
		document.getElementById("EditProfile").disabled = true;
		document.getElementById("SubmitProfile").disabled = false;
		document.getElementById("FirstName").disabled = false;
		document.getElementById("LastName").disabled = false;
		document.getElementById("Gender").disabled = false;
		document.getElementById("Email").disabled = false;
		document.getElementById("DOB").disabled = false;
		document.getElementById("lstBoxSoftware1").disabled = false;
		document.getElementById("SoftwarebtnAllRight").disabled = false;
		document.getElementById("SoftwarebtnRight").disabled = false;
		document.getElementById("SoftwarebtnLeft").disabled = false;
		document.getElementById("SoftwarebtnAllLeft").disabled = false;
		document.getElementById("lstBoxSoftware2").disabled = false;
		document.getElementById("lstBoxHardware1").disabled = false;
		document.getElementById("HardwarebtnAllRight").disabled = false;
		document.getElementById("HardwarebtnRight").disabled = false;
		document.getElementById("HardwarebtnLeft").disabled = false;
		document.getElementById("HardwarebtnAllLeft").disabled = false;
		document.getElementById("lstBoxHardware2").disabled = false;
		document.getElementById("Address").disabled = false;
		document.getElementById("City").disabled = false;
		document.getElementById("State").disabled = false;
		document.getElementById("Zip").disabled = false;
	});
	$("#SubmitProfile").on('click', function() {
		var ssSelect = document.getElementById("lstBoxSoftware2");
    for (var i = 0; i < ssSelect.options.length; i++)
         ssSelect.options[i].selected = true;

		var hsSelect = document.getElementById("lstBoxHardware2");
    for (var i = 0; i < hsSelect.options.length; i++)
         hsSelect.options[i].selected = true;
	});

	(function () {
    $('#SoftwarebtnRight').click(function (e) {
        var selectedOpts = $('#lstBoxSoftware1 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#lstBoxSoftware2').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
		$('#HardwarebtnRight').click(function (e) {
        var selectedOpts = $('#lstBoxHardware1 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#lstBoxHardware2').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#SoftwarebtnAllRight').click(function (e) {
        var selectedOpts = $('#lstBoxSoftware1 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#lstBoxSoftware2').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
		$('#HardwarebtnAllRight').click(function (e) {
				var selectedOpts = $('#lstBoxHardware1 option');
				if (selectedOpts.length == 0) {
						alert("Nothing to move.");
						e.preventDefault();
				}
				$('#lstBoxHardware2').append($(selectedOpts).clone());
				$(selectedOpts).remove();
				e.preventDefault();
		});

    $('#SoftwarebtnLeft').click(function (e) {
        var selectedOpts = $('#lstBoxSoftware2 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#lstBoxSoftware1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
		$('#HardwarebtnLeft').click(function (e) {
        var selectedOpts = $('#lstBoxHardware2 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#lstBoxHardware1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#SoftwarebtnAllLeft').click(function (e) {
        var selectedOpts = $('#lstBoxSoftware2 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#lstBoxSoftware1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
		$('#HardwarebtnAllLeft').click(function (e) {
        var selectedOpts = $('#lstBoxHardware2 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#lstBoxHardware1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
	}(jQuery));
</script>
