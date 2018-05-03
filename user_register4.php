<!--
/**
This file is where users can create accounts.
Accounts created on this page are automically given a ranking of "3", which is simply an account without administrative privileges (further distinctions between account rankings may be given in the future).
Only the name, email, and password information must be created to create an account.
Errors will not be introduced to this page any time soon because specific errors can currently only be associated with users who are logged in.
*/ -->

<?php
	include 'config/header.php'; //connects to database
	require_once('../sql_connector.php');

	$UID = $_SESSION['user'];
	$stmt = $mysqli->prepare("SELECT first_name, last_name, password, Email, level, gender, dateofbirth, address, city, state, zip FROM user WHERE UID = ?");
	$stmt->bind_param("s",$UID);
	$stmt->execute();
	$stmt->bind_result($firstname, $lastname, $password, $email, $level, $gender, $dateofbirth, $address, $city, $state, $zip);
	$stmt->fetch();
	$stmt->close();

	$stmt = $mysqli->prepare("SELECT title FROM levels WHERE id = ?");
	$stmt->bind_param("s",$level);
	$stmt->execute();
	$stmt->bind_result($rank);
	$stmt->fetch();
	$stmt->close();
?>

<html>
	<body>
		<div class="container">
			<div class="form-horizontal" id="centerbox">
				<?php //A progress bar that will show the progress of the users registration ?>
				Registration Progress
			</div>
			<div class="progress">
				<div id="ProgBarReg4" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
					aria-valuenow="86" aria-valuemin="0" aria-valuemax="100" style="width:86%">
				</div>
			</div>
			<br>
			<form id="Reg4HardForm" class="" action="saveprofile.php" method="post">
				<h3 id="HardSkilHeadReg4">Hardware Skills</h3>
				<hr>
				<div class="hardware-skills-bank">
					<label>Skill Bank</label>
					<select multiple="multiple" id='lstBoxHardware1' class="form-control">
						<?php
							$softSkills = $mysqli->query("SELECT * FROM hardware_skills ss WHERE NOT EXISTS (SELECT * FROM user_hardware_skills uss WHERE  uss.skill_id = ss.uid AND uss.user_id = ".$_SESSION['user'].") ORDER BY ss.skill");
							while ($row = $softSkills->fetch_assoc())
								echo '<option value="'.$row['UID'].'">'.$row['skill'].'</option>';
						 ?>
					</select>
				</div>
				<div class="hardware-skills-arrows text-center">
					<input type="button" id="HardwarebtnAllRight" value=">>" class="btn btn-default"/><br />
					<input type="button" id="HardwarebtnRight" value=">" class="btn btn-default"/><br />
					<input type="button" id="HardwarebtnLeft" value="<" class="btn btn-default"/><br />
					<input type="button" id="HardwarebtnAllLeft" value="<<" class="btn btn-default"/>
				</div>
				<div class="hardware-skills-personal">
					<label>Your Skills</label>
					<select multiple="multiple" name="personalhs[]" id='lstBoxHardware2' class="form-control">
						<?php
							$persSoftSkills = $mysqli->query("SELECT ss.*, uss.skill_id, uss.user_id FROM hardware_skills AS ss LEFT JOIN user_hardware_skills AS uss ON ss.UID = uss.skill_id WHERE uss.user_id = ".$_SESSION['user'].";");
							while ($row = $persSoftSkills->fetch_assoc())
								echo '<option value="'.$row['UID'].'">'.$row['skill'].'</option>';
						 ?>
					</select>
				</div>
				<div class="clearfix"></div>
				<br>
				<input id="SubmitProfile" type="submit" name="Save" value="Save" class="btn btn-success" style="float:right;">
				<input id="UserIdReg4" type="text" name="uid" value="<?php echo $UID ?>" style="display:none;">
				<input id="FirstNameReg4" type="text" name="first_name" value="<?php echo $firstname ?>" style="display:none;">
				<input id="lastNameReg4" type="text" name="last_name" value="<?php echo $lastname ?>" style="display:none;">
				<input id="EmailReg4" type="text" name="email" value="<?php echo $email ?>" style="display:none;">
				<input id="UserLevelReg4" type="text" name="level" value="<?php echo $level ?>" style="display:none;">
				<input id="GenderReg4" type="text" name="gender" value="<?php echo $gender ?>" style="display:none;">
				<input id="dobReg4" type="date" name="dob" value="<?php echo $dateofbirth ?>" style="display:none;">
				<input id="AddressReg4" type="text" name="address" value="<?php echo $address ?>" style="display:none;">
				<input id="CityReg4" type="text" name="city" value="<?php echo $city ?>" style="display:none;">
				<input id="StateReg4" type="text" name="state" value="<?php echo $state ?>" style="display:none;">
				<input id="ZipCodeReg4" type="text" name="zip" value="<?php echo $zip ?>" style="display:none;">
				<input id="OrginReg4" type="text" name="orgin" value="3" style="display:none;">
			</form>
			<br>
		</div>
	</body>
</html>

<script type="text/javascript">
	$("#SubmitProfile").on('click', function() {
		var ssSelect = document.getElementById("lstBoxHardware2");
		for (var i = 0; i < ssSelect.options.length; i++)
				 ssSelect.options[i].selected = true;
	});

	(function () {
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
