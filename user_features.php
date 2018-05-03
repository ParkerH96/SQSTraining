<!-- This file will serve as the admin location to add features to groups/users -->
<?php ob_start();
  include 'config/header.php';
  require_once('../sql_connector.php');
  if ($_SESSION['level'] != '5' && $_SESSION['level'] != '6'){	header('location:index.php'); }
?>

<html>
  <body>
    <div class="container">
      <h2 id="AvailFeatHead" style="display: inline;">Available Features</h2>
      <button id="AddFeatBut" style="display:inline;margin-left:20px; margin-bottom: 10px;" type="button" name="addAssignment" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addFeatureModal">Add Feature</button>
      <hr>
      <table id="FeatTable" class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th></th>
          </tr>
        </thead>
        <?php
        $feature_query = $mysqli->query("SELECT * FROM features_available ORDER BY file");
        if($feature_query->num_rows > 0){
          while($feature = $feature_query->fetch_assoc()){ ?>
          <tr>
            <td><?php echo $feature['name']; ?></td>
            <td><?php echo $feature['description']; ?></td>
            <td><a href="/features/<?php echo $feature['file'];?>" download><i class="fas fa-download"></i></a></td>
          </tr>
        <?php } ?>
      <?php } else
          echo '<tr><td>No Users Found!</td></tr>';
        ?>
      </table>
      <br>
      <h2 id="currentAssiGroupHead" style="display: inline;">Current Assignments (Group)</h2>
      <button id="AddAssiBut"style="display:inline;margin-left:20px; margin-bottom: 10px;" type="button" name="addAssignment" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addAssignmentModal">Add Assignment</button>
      <hr>
      <table id="GroupAssignedFeatTable" class="table table-striped">
        <thead>
          <tr>
            <th style="width: 25%;">Feature</th>
            <th style="width: 25%;">Group</th>
            <th style="width: 40%;">Description</th>
            <th style="width: 10%;"></th>
          </tr>
        </thead>
        <?php
          $group_assignments = $mysqli->query("SELECT id, feature_number, group_id FROM assigned_group_features");
          while($row = $group_assignments->fetch_assoc()) {

            $feature_number = $row['feature_number'];
            $feature_query = $mysqli->query("SELECT name, description FROM features_available WHERE id = $feature_number");
            $feature = $feature_query->fetch_assoc();

            $group_id = $row['group_id'];
            $group_query = $mysqli->query("SELECT name FROM groups WHERE UID = $group_id");
            $group = $group_query->fetch_assoc();

            ?>

            <tr>
              <td><?php echo $feature['name']; ?></td>
              <td><?php echo $group['name']; ?></td>
              <td><?php echo $feature['description']; ?></td>
              <td>
                <form id="RemAssForm" action="removeAssignment.php" method="post">
                  <input class="form-control" id="assiType" type="text" hidden name="assignment_type" value="group">
                  <input class="form-control" id="assiId" type="number" hidden name="assignment_id" value="<?php echo $row['id']; ?>">
                  <input class="btn btn-sm btn-danger" id="UnassignBut" style="float: right" type="submit" name="submit" value="Unassign">
                </form>
              </td>
            </tr>
          <?php } ?>
      </table>
      <br>
      <h2 id="UserAssiHead" style="display: inline;">Current Assignments (User)</h2>
      <button style="display:inline;margin-left:20px; margin-bottom: 10px;" type="button" name="addAssignment" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addAssignmentModal">Add Assignment</button>
      <hr>
      <table id="UserAssiTable"class="table table-striped">
        <thead>
          <tr>
            <th style="width: 25%;">Feature</th>
            <th style="width: 25%;">User</th>
            <th style="width: 40%;">Description</th>
            <th style="width: 10%;"></th>
          </tr>
        </thead>
      <?php
        $user_assignments = $mysqli->query("SELECT id, feature_number, user_id FROM assigned_features");
        while($row = $user_assignments->fetch_assoc()) {

          $feature_number = $row['feature_number'];
          $feature_query = $mysqli->query("SELECT name, description FROM features_available WHERE id = $feature_number");
          $feature = $feature_query->fetch_assoc();

          $user_id = $row['user_id'];
          $user_query = $mysqli->query("SELECT first_name, last_name FROM user WHERE UID = $user_id");
          $user = $user_query->fetch_assoc();

          ?>
          <tr>
            <td><?php echo $feature['name']; ?></td>
            <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
            <td><?php echo $feature['description']; ?></td>
            <td>
              <form id="remAssiUser"action="removeAssignment.php" method="post">
                <input type="text" id="UserAssi" style="display: none;" name="assignment_type" value="user">
                <input type="number" id="UserAssiID"style="display: none;" name="assignment_id" value="<?php echo $row['id']; ?>">
                <input class="btn btn-sm btn-danger" id="UserAssiBut" style="float: right" type="submit" name="submit" value="Unassign">
              </form>
            </td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </body>
  <div style="padding-top:50px;"></div>

  <!--
  Modals Added in Spring 2018
  These modals are designed for displaying the content for adding a Feature or Assignment without having to crowd the original page
  -->
  <div id="addAssignmentModal" class="modal fade" role="dialog">
      <!-- Modal content -->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="AddAssiHead">Add Assignment</h4>
          <button type="button" id="AddAssiBut" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="addAssignment.php" id="AddAssiForm" method="post">
          <div class="modal-body">
            <label for="feature_select">Feature </label>
            <select class="form-control" id="FeatureDropDown" name="feature_select">
              <?php
              $current_features = $mysqli->query("SELECT id, name FROM features_available ORDER BY id ASC");
              while($row = $current_features->fetch_assoc()){ ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
              <?php } ?>
            </select><br>
            <label for="group_user_select"> Assign to </label>
            <select class="form-control" id="GroupDropdown" name="group_user_select">
              <optgroup label="Groups">
                <?php
                $groups = $mysqli->query("SELECT UID, name FROM groups ORDER BY UID ASC");
                while($row = $groups->fetch_assoc()){ ?>
                  <option value="g<?php echo $row['UID']; ?>"><?php echo $row['name']; ?></option>
                <?php } ?>
              </optgroup>
              <optgroup label="Users">
                <?php
                $users = $mysqli->query("SELECT UID, first_name, last_name FROM user ORDER BY UID ASC");
                while($row = $users->fetch_assoc()){ ?>
                  <option value="u<?php echo $row['UID']; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></option>
                <?php } ?>
              </optgroup>
            </select>
          </div>
          <div class="modal-footer">
            <input type="submit" id="AddAssiSubmit" value="Add Assignment" class="btn btn-success">
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="addFeatureModal" class="modal fade" role="dialog">
      <!-- Modal content -->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="AddFeatHeader">Add Feature</h4>
          <button type="button" id="AddFeatButton" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="addFeature.php" id="AddFeatForm" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <label for="name">Feature Name </label>
            <input class="form-control" id="FeatName" type="text" name="name"><br><br>
            <label for="description">Feature Description </label>
            <input class="form-control" id="FeatDescription" type="textarea" name="description"><br><br>
            <label for="file">Feature File (.php)</label>
            <input class="form-control" id="FeatFile" type="file" name="file"><br><br>
            <label for="target">Target</label>
            <select class="form-control" id="FeatDropdownSelect" name="target">
              <?php
              $current_features = $mysqli->query("SELECT DISTINCT target FROM features_available ORDER BY id ASC");
              while($row = $current_features->fetch_assoc()){ ?>
                <option value="<?php echo $row['target']; ?>"><?php echo $row['target']; ?></option>
              <?php } ?>
            </select><br>
          </div>
          <div class="modal-footer">
            <input type="submit" id="AddFeatureBut" value="Add Feature" class="btn btn-success">
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
    include "footer.php";
   ?>
</html>
