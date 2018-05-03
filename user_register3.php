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
				<div id="ProgressBarReg3" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
					aria-valuenow="86" aria-valuemin="0" aria-valuemax="100" style="width:86%">
				</div>
			</div>
			<br>
			<form class="" id="RegForm3" action="saveprofile.php" method="post">
				<h3 id="RegFormSoftHead">Software Skills</h3>
				<hr>
				<div class="software-skills-bank">
					<label>Skill Bank</label>
					<select multiple="multiple" id='lstBoxSoftware1' class="form-control">
						<?php
							$softSkills = $mysqli->query("SELECT * FROM software_skills ss WHERE NOT EXISTS (SELECT * FROM user_software_skills uss WHERE  uss.skill_id = ss.uid AND uss.user_id = ".$_SESSION['user'].") ORDER BY ss.skill");
							while ($row = $softSkills->fetch_assoc())
								echo '<option value="'.$row['UID'].'">'.$row['skill'].'</option>';
						 ?>
					</select>
				</div>
				<div class="software-skills-arrows text-center">
					<input type="button" id="SoftwarebtnAllRight" value=">>" class="btn btn-default"/><br />
					<input type="button" id="SoftwarebtnRight" value=">" class="btn btn-default"/><br />
					<input type="button" id="SoftwarebtnLeft" value="<" class="btn btn-default"/><br />
					<input type="button" id="SoftwarebtnAllLeft" value="<<" class="btn btn-default"/>
				</div>
				<div class="software-skills-personal">
					<label>Your Skills</label>
					<select multiple="multiple" name="personalss[]" id='lstBoxSoftware2' class="form-control">
						<?php
							$persSoftSkills = $mysqli->query("SELECT ss.*, uss.skill_id, uss.user_id FROM software_skills AS ss LEFT JOIN user_software_skills AS uss ON ss.UID = uss.skill_id WHERE uss.user_id = ".$_SESSION['user'].";");
							while ($row = $persSoftSkills->fetch_assoc())
								echo '<option value="'.$row['UID'].'">'.$row['skill'].'</option>';
						 ?>
					</select>
				</div>
				<div class="clearfix"></div>
				<br>
				<input id="SubmitProfile" type="submit" name="Save" value="Save" class="btn btn-success" style="float:right;">
				<input id="UserIdReg3" type="text" name="uid" value="<?php echo $UID ?>" style="display:none;">
				<input id="FirstNameReg3" type="text" name="first_name" value="<?php echo $firstname ?>" style="display:none;">
				<input id="lastNameReg3" type="text" name="last_name" value="<?php echo $lastname ?>" style="display:none;">
				<input id="EmailReg3" type="text" name="email" value="<?php echo $email ?>" style="display:none;">
				<input id="UserLevelReg3" type="text" name="level" value="<?php echo $level ?>" style="display:none;">
				<input id="GenderReg3" type="text" name="gender" value="<?php echo $gender ?>" style="display:none;">
				<input id="dobReg3" type="date" name="dob" value="<?php echo $dateofbirth ?>" style="display:none;">
				<input id="AddressReg3" type="text" name="address" value="<?php echo $address ?>" style="display:none;">
				<input id="CityReg3" type="text" name="city" value="<?php echo $city ?>" style="display:none;">
				<input id="StateReg3" type="text" name="state" value="<?php echo $state ?>" style="display:none;">
				<input id="ZipCodeReg3" type="text" name="zip" value="<?php echo $zip ?>" style="display:none;">
				<input id="OrginReg3" type="text" name="orgin" value="2" style="display:none;">
			</form>
			<br>
		</div>
	</body>
</html>

<script type="text/javascript">
	$("#SubmitProfile").on('click', function() {
		var ssSelect = document.getElementById("lstBoxSoftware2");
		for (var i = 0; i < ssSelect.options.length; i++)
				 ssSelect.options[i].selected = true;
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
	}(jQuery));
</script>
