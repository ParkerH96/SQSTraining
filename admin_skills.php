<!--
  Last Modified: Spring 2018
  Function: Gives admin control of which skills are available
  Change Log: Added Page
-->

<html>
  <head>
    <?php ob_start();
      include 'config/header.php';
      require_once('../sql_connector.php'); //connects to the database
      echo "Made it";
      if ($_SESSION['level'] != '5' && $_SESSION['level'] != '6'){ echo "Here";	header('location:index.php'); } //redirect user to index page if the user isn't an admin
    ?>
  </head>
  <body>
    <div class="inventory">
      <div class="container skills">
        <h3 id="skillsHead">Skills</h3>
        <hr>
        <div class="software-skills" style="margin-right:5%;">
          <h4 id="softSkillsHead">Software Skills</h4>
          <form id="SoftSkillsForm" name="softwareskills" class="software-add form-group" action="addSoftwareSkill.php" method="post">
            <div class="software-skills-bank">
              <select multiple="multiple" id='lstBoxSoftware1' class="form-control" name="softwareskills[]">
                <?php
                  $softSkills = $mysqli->query("SELECT * FROM software_skills ORDER BY skill;");
                  while ($row = $softSkills->fetch_assoc())
                    echo '<option value="'.$row['UID'].'">'.$row['skill'].'</option>';
                 ?>
              </select>
              <br>
            </div>
            <div class="input-group">
              <input id="softSkillInput" class="form-control"  type="text" name="softskill" maxlength="30" value="">
              <span class="input-group-btn">
                <input type="submit" id="softAdd" value="Add" class="btn btn-success" onclick='this.form.action="addSoftwareSkill.php";'>
                <input type="button" id="SoftRemove" class="btn btn-danger" value="Remove">
              </span>
            </div>
          </form>
        </div>
        <div class="hardware-skills">
          <h4 id="hardSkillsHead">Hardware Skills</h4>
          <form class="hardware-add form-group" id="HardwareSkillsForm" name="hardwareskills" action="" method="post">
            <div class="hardware-skills-bank">
    				  <select multiple="multiple" id='lstBoxHardware1' class="form-control" name="hardwareskills[]">
    						<?php
    							$hardSkills = $mysqli->query("SELECT * FROM hardware_skills ORDER BY skill;");
    							while ($row = $hardSkills->fetch_assoc())
    								echo '<option value="'.$row['UID'].'">'.$row['skill'].'</option>';
    						 ?>
    				  </select>
              <br>
    				</div>
            <div class="input-group">
              <input id="hardSkillsInput" class="form-control"  type="text" name="hardskill" maxlength="30" value="">
              <span class="input-group-btn">
                <input type="submit" id="hardAdd" value="Add" class="btn btn-success" onclick="this.form.action = 'addHardwareSkill.php'">
                <input type="button" id="HardRemove" class="btn btn-danger" value="Remove" >
              </span>
            </div>
          </form>
        </div>
      </div>
    </div><br>
  </body>
  <?php
    include "footer.php";
   ?>
</html>

<script type="text/javascript">
  $("#HardRemove").on("click", function() {
    if ($("#lstBoxHardware1").val().length == 0) {
      alert("No Hardware Skill was selected!");
    }
    else {
      document.forms["hardwareskills"].action="removeHardwareSkill.php";
      $("#HardwareSkillsForm").submit();
    }
  });
  $("#SoftRemove").on("click", function() {
    if ($("#lstBoxSoftware1").val().length == 0) {
      alert("No Software Skill was selected!");
    }
    else {
      document.forms["softwareskills"].action="removeSoftwareSkill.php";
      $("#SoftSkillsForm").submit();
    }
  });
</script>
