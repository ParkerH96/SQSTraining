<!--
  Last Modified: Spring 2018
  Function: Displays name on Profile Page
  Change Log: Restructed to conform with new profile page
  Error: No error
-->

<?php
  $UID = $_SESSION['user'];
  $stmt = $mysqli->prepare("SELECT first_name, last_name FROM user WHERE UID = ?");
  $stmt->bind_param("s",$UID);
  $stmt->execute();
  $stmt->bind_result($firstname, $lastname);
  $stmt->fetch();
  $stmt->close();
 ?>


<input class="form-control" id="FirstName" type="text" name="first_name" maxlength="25" value="<?php echo $firstname ?>" disabled><br>
<input class="form-control" id="LastName" type="text" name="last_name" maxlength="25" value="<?php echo $lastname ?>" disabled><br>
