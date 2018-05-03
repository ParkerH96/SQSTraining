<!--
  Last Modified: Spring 2018
  Function: This page shows information relevant to an administrator.
            It only shows this information to accounts with the Admin ranking.
            Administrators can add or remove users to or from groups. They can also promote users to leadership positions on that group or strip users of that ranking.
  Change Log: Completely redone this page to look and function better
-->

<html>
  <head>
    <?php ob_start();
      include 'config/header.php';
      require_once('../sql_connector.php'); //connects to the database
      if ($_SESSION['level'] != '5' && $_SESSION['level'] != '6'){	header('location:index.php'); } //redirect user to index page if the user isn't an admin
    ?>

    <?php
      if(isset($_POST['userSkills'])){
        $userSkillsUID = $_POST['uid'];
      } ?>

  </head>
  <body class="inventory">

    <?php
      $query = "SELECT * FROM user";
      $result = $mysqli->query($query);
    ?>

    <div class="container"><h2 id="welcomeHeader" style="display:inline;">Welcome, Admin </h2>
    <button style="display:inline;margin-left:20px; margin-bottom: 10px;"  id="exportButton" onclick="window.location.href='export.php'" type="button" class="btn btn-info btn-sm">Export</button>
    <br>

    <!-- makes table to display table header -->
    <table id="displayTable" class="table table-striped table-responsive">
      <thead>
         <tr>
           <th>ID</th>
           <th>First Name</th>
           <th>Last Name</th>
           <th>Email</th>
           <th>Progress</th>
           <th>DOB</th>
           <th>Gender</th>
           <th>Status</th>
           <th></th>
         </tr>
       </thead>

    <?php
    //fills up table with user(s) info
    if($result->num_rows > 0)
      while($row = $result->fetch_array(MYSQLI_ASSOC)){
      echo '<tr>
        <td>'. $row['UID'].'</td>
        <td>'. $row['first_name'].'</td>
        <td>'. $row['last_name'].'</td>
        <td>'. $row['Email'].'</td>
        <td>';

      $progress = $row['progress'];
      $pbar_type = '';
      if( $progress < 40 ) {
        $pbar_type = 'danger';
      } else if($progress < 80) {
        $pbar_type = 'warning';
      } else {
        $pbar_type = 'success';
      }
      ?>
      <div class="progress-bar progress-bar-striped bg-<?php echo $pbar_type; ?>" id="progressBarInfo" style="width: 100%;" role="progressbar" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
        <?php echo $progress . '%'; ?>
      </div>
      <?php echo '</td>
      <td>'. $row['dateofbirth'].'</td>
      <td>'. $row['gender'].'</td>';

      $stmt = $mysqli->prepare("SELECT title FROM levels WHERE id = ?");
      $stmt->bind_param("s",$row['level']);
      $stmt->execute();
      $stmt->bind_result($rank);
      $stmt->fetch();
      $stmt->close();

      echo '<td>' . $rank . '</td>';

      if($_SESSION['level'] > $row['level']){
        echo '<td><button class="editUser btn btn-warning btn-sm" data-toggle="modal" data-city="' . $row['city'] . '" data-state="' . $row['state'] . '" data-zip="' . $row['zip'] . '" data-address="' .
        $row['address'] . '" data-target="#editUserModal" data-level="'.$row['level'].'" data-gender="'.$row['gender'].'" data-dob="'.$row['dateofbirth'].'" data-email="'.$row['Email'].'"
        data-first-name="'.$row['first_name'].'" data-last-name="'.$row['last_name'].'" data-user="'.$row['UID'].'"><i style="color: white;" class="fas fa-pencil-alt"></i></button>
        <button data-uid="' . $row['UID'] . '" data-target="#deleteModal" class="deleteUser btn btn-danger btn-sm" data-toggle="modal"><i style="color: white;" class="fas fa-trash"></i></button></td></tr>';
      }
      else {
        echo '<td></td>';
      }
    }
    else
      echo '<tr><td>No Users Found!</td></tr>';
    echo "</table></div>";
    ?>

  </body>
  <div style="padding-top:50px;"></div>
<div id="editUserModal" class="modal fade" role="dialog">
      <!-- Modal content -->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="editHeader" class="modal-title">Edit User</h4>
          <button id="editButton" type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form id="EditUserModalForm" name="EditUserModalForm" class="" action="saveprofile.php" method="post">
          <div class="modal-body">
            <br>
            <div class="row">
              <div class="col-md-3 col-sm-3">
                <div class="profile-labels-edit">
                  <label style="padding-top: 6px;" class="control-label">First Name</label><br><br>
                  <label style="padding-top: 11px;" class="control-label">Last Name</label><br><br>
                  <label style="padding-top: 9px;" class="control-label">Email</label>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="profile-inputs-edit">
                  <input class="form-control" id="FirstName" type="text" name="first_name" value=""><br>
                  <input class="form-control" id="LastName" type="text" name="last_name" value=""><br>
                  <input class="form-control" id="Email" type="email" name="email" value=""><br>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-3">
                <div class="profile-labels-edit">
                  <label style="padding-top: 6px;" class="control-label" >Date of Birth</label><br><br>
                  <label style="padding-top: 11px;" class="control-label" >Address</label><br><br>
                  <label style="padding-top: 7px;" class="control-label" >City</label><br><br>
                  <label style="padding-top: 7px;" class="control-label" >State</label><br><br>
                  <label style="padding-top: 6px;" class="control-label" >Zip</label><br><br>
                  <label style="padding-top: 5px;" class="control-label" >Gender</label><br><br>
                  <label style="padding-top: 4px;" class="control-label" >Access Level</label><br>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="profile-inputs-edit">
                  <input class="form-control" id="Dob"type="date" name="dob" value=""><br>
                  <input class="form-control" id="Address"type="text" name="address" value=""><br>
                  <input class="form-control" id="City"type="text" name="city" value=""><br>
                  <select class="form-control" id="State" name="state">
                    <option value="NU">Select One</option>
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
      							<option value="GA">Hawaii</option>
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
      						</select><br>
                  <input class="form-control" id="Zip" type="text" name="zip" value=""><br>
                  <select class="form-control" id="Gender" name="gender">
                    <option value="NULL">NULL</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select><br>
                  <select class="form-control level-select" id="Level" name="level">
                    <option value="3">User</option>
                    <option value="2">Restricted User</option>
                    <option value="4">Super User</option>
                    <option value="5">Admin</option>
                  </select><br>
                </div>
              </div>
            </div>
            <input type="number" id="uid" name="uid" value="" hidden>
            <input type="text" id="orgin" name="orgin" value="1" hidden>
          <div class="modal-footer">
            <input id="UserSkillsBTN" type="submit" onclick='this.form.action="admin_user_info.php"' name="userSkills" value="User Skills" class="btn btn-primary">
            <input id="SubmitProfile" type="button" name="editUser" value="Save" class="btn btn-success">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="deleteModal" class="modal fade" role="dialog">
    <!-- Modal content -->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="DeleteHead" class="modal-title">Delete User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="DeleteUserModalForm" name="DeleteUserModalForm" class="" action="deleteUser.php" method="post">
        <div class="modal-body">
          <p>Are you sure you want to delete this user?</p>
        </div>
        <div class="modal-footer">
          <input hidden type="number" id="UID" name="UID" value="">
          <input class="btn btn-success" id="Submit" type="submit" name="submit" value="Yes">
          <button type="button" name="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="UserSkillsModal" class="modal fade" role="dialog">
    <!-- Modal content -->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="UserSkillsHead" class="modal-title">Users Skills</h4>
        <button type="button" id="closeBut" class="close" data-dismiss="modal" onclick="document.getElementById('UserSkillsModal').style.display = 'none'">&times;</button>
      </div>
      <form id="UserSkillsModalForm" name="userSkillsModalForm" action="saveprofile.php" method="post">
        <input type="text" name="orgin" value="9" hidden>
        <div class="modal-body">
          <h5 id="SOftSkillHeader">Software Skills</h5>
  				<hr>
  				<div class="software-skills-bank">
  					<label>Skill Bank</label>
  				  <select multiple="multiple" id='lstBoxSoftware1' class="form-control">
  						<?php
  							$softSkills = $mysqli->query("SELECT * FROM software_skills ss WHERE NOT EXISTS (SELECT * FROM user_software_skills uss WHERE uss.skill_id = ss.uid AND uss.user_id = '$userSkillsUID');");
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
  							$persSoftSkills = $mysqli->query("SELECT ss.*, uss.skill_id, uss.user_id FROM software_skills AS ss LEFT JOIN user_software_skills AS uss ON ss.UID = uss.skill_id WHERE uss.user_id = '$userSkillsUID';");
  							while ($row = $persSoftSkills->fetch_assoc())
  								echo '<option value="'.$row['UID'].'">'.$row['skill'].'</option>';
  						 ?>
  				  </select>
  				</div>
  				<div class="clearfix"></div>
  				<br>

  				<h5 id="HardSkillsHeader">Hardware Skills</h5>
  				<hr>
  				<div class="hardware-skills-bank">
  					<label>Skill Bank</label>
  				  <select multiple="multiple" id='lstBoxHardware1' class="form-control">
  						<?php
  							$hardSkills = $mysqli->query("SELECT * FROM hardware_skills ss WHERE NOT EXISTS (SELECT * FROM user_hardware_skills uss WHERE  uss.skill_id = ss.uid AND uss.user_id = '$userSkillsUID');");
  							while ($row = $hardSkills->fetch_assoc())
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
  				  <select multiple="multiple" id='lstBoxHardware2' name="personalhs[]" class="form-control">
  						<?php
  							$persHardSkills = $mysqli->query("SELECT ss.*, uss.skill_id, uss.user_id FROM hardware_skills AS ss LEFT JOIN user_hardware_skills AS uss ON ss.UID = uss.skill_id WHERE uss.user_id = '$userSkillsUID';");
  							while ($row = $persHardSkills->fetch_assoc())
  								echo '<option value="'.$row['UID'].'">'.$row['skill'].'</option>';
  						 ?>
  				  </select>
  				</div>
        </div>
        <div class="modal-footer">
          <input type="number" id="uidSkills" name="uid" value="<?php echo $userSkillsUID; ?>" hidden>
          <input id="SubmitUserSkills"  class="btn btn-success" type="submit" name="submit" value="Submit">
          <button type="button" class="btn btn-danger" onclick="document.getElementById('UserSkillsModal').style.display = 'none'" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
  include "footer.php";
 ?>
</html>

<?php
  if(isset($_POST['userSkills'])){
    ?>
    <script type="text/javascript">
      var modal = document.getElementById('UserSkillsModal');
      modal.classList.add("show");
      modal.setAttribute("style","overflow-y:auto");
      modal.style.display = "block";
    </script>
    <?php
  }
//close database
$mysqli->close();
?>

<script type="text/javascript">
  var close = document.getElementsByClassName("close")[0];

  $('button.deleteUser').on('click', function(){
    let uid = $(this).data('uid');

    var inputs = document.getElementById('deleteModal').getElementsByTagName('input');
    inputs[0].value = uid;
  });

  $('button.editUser').on('click', function() {
      let uid = $(this).data('user');
      let email = $(this).data('email');
      let firstName = $(this).data('first-name');
      let lastName = $(this).data('last-name');
      let dob = $(this).data('dob');
      let gender = $(this).data('gender');
      let level = $(this).data('level');
      let address = $(this).data('address');
      let city = $(this).data('city');
      let zip = $(this).data('zip');
      let state = $(this).data('state');
      var inputs = document.getElementById('editUserModal').getElementsByTagName('input');
      inputs[7].value = uid;
      inputs[0].value = firstName;
      inputs[1].value = lastName;
      inputs[2].value = email;
      inputs[3].value = dob;
      inputs[4].value = address;
      inputs[5].value = city;
      inputs[6].value = zip;
      document.getElementById('editUserModal').getElementsByTagName('select')[0].value = state;
      document.getElementById('editUserModal').getElementsByTagName('select')[1].value = gender;
      document.getElementById('editUserModal').getElementsByTagName('select')[2].value = level;
  });

  $("#SubmitProfile").on('click', function() {
    document.forms["EditUserModalForm"].action="saveprofile.php";
    $("#EditUserModalForm").submit();
	});

  $("#UserSkillsBTN").on('click', function() {
    document.forms["EditUserModalForm"].action="";
    //$("#EditUserModalForm").submit();
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
  $("#SubmitUserSkills").on('click', function() {
		var ssSelect = document.getElementById("lstBoxSoftware2");
    for (var i = 0; i < ssSelect.options.length; i++)
         ssSelect.options[i].selected = true;

		var hsSelect = document.getElementById("lstBoxHardware2");
    for (var i = 0; i < hsSelect.options.length; i++)
         hsSelect.options[i].selected = true;
	});
</script>
