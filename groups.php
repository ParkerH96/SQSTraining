<!--
  Last Modified: Spring 2018
  Function: Displays groups and allows admin to edit groups by adding,
            deleting groups as well as adding or removing users from
            groups and promote or demote users in groups
  Change Log: Redone page to actually funtion
-->

<?php
      include 'config/header.php';
      require_once('../sql_connector.php');
      require_once("../feature_connector.php");
			// if ($_SESSION['level'] != '6' && $_SESSION['level'] != '5')	//redirects to index page if user isn't a user
			//     header('location:index.php');
?>

<html>
	<body>
		<div class="container">
      <?php if($_SESSION['level'] == '2' || $_SESSION['level'] == '3') { ?>
      <h3 id="GroupHead">My Groups</h3>
      <hr>
      <?php
      $my_groups = $mysqli->query("SELECT groups.UID, groups.name FROM groups INNER JOIN group_members ON groups.UID = group_members.group_id WHERE group_members.uid = ".$_SESSION['user'].";");
      if($my_groups->num_rows > 0) {
        while($row = $my_groups->fetch_assoc()) { ?>
          <div class="my-group-container">
            <h5 style="margin-bottom: 10px;"><?php echo $row['name']; ?></h5>
            <?php
            if($_SESSION['level'] == 3){
              $group_members = $mysqli->query("SELECT user.first_name, user.last_name FROM user INNER JOIN group_members ON user.UID = group_members.uid WHERE group_members.group_id = ".$row['UID'].";");
              if($group_members->num_rows > 0) {
                while($single_member = $group_members->fetch_assoc()){ ?>
                  <span class="badge badge-success"><?php echo $single_member['first_name'] . " " . $single_member['last_name']; ?></span>
                <?php }
              }
            }
            ?>
          </div>
        <?php }
      }

    } else if($_SESSION['level'] == '5' || $_SESSION['level'] == '6' || $_SESSION['level'] == '4') { ?>

      <h3 id="groupsHead" style="display:inline">Groups</h3>
      <button style="display:inline;margin-left:20px;" id="addgroupBut" type="button" name="addGroup" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addGroupModal">Add Group</button>
      <hr>
      <div style="margin-left:5%;">
        <!-- //Display all members of each group -->
        <?php
        $result = $mysqli->query('SELECT * FROM groups');
        if($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) { ?>
            <div class="groups">
              <div class='row'>
                <h5 id="UserNameHead"><u><?php echo $row['name']; ?></u></h5>
                <button onclick="injectGroup(this)" id="addUserbut" style="display:inline-block;margin-left:20px;" type="button" name="addUserGroup" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addUserGroupModal" data-group="<?php echo $row['UID'] ?>">Add User</button>
                <form action="group_operations/remove_group.php" id="removeGroupForm" method="post">
                  <input type="text" id="textGroupName" name="group" value="<?php echo $row['UID']; ?>" style="display:none;">
                  <button style="display:inline-block;margin-left:10px;" id="removeGroupbut" type="submit" name="removeGroup" class="btn btn-sm btn-danger" data-group="<?php echo $row['UID'] ?>">Remove Group</button>
                </form>
              </div><br />
            <?php
            $result2 = $mysqli->query("SELECT user.UID, user.first_name, user.Email, group_members.leader FROM user INNER JOIN group_members ON user.uid=group_members.uid WHERE group_members.group_id=".$row['UID']." ORDER BY leader DESC;");
            if($result2->num_rows > 0){
              while($member = $result2->fetch_assoc()) {
                $leadership = "";
                if($member["leader"] == 1)
                $leadership = "(Leader) ";
                ?>
                <div class="row">
                  <div class="group-info">
                    <?php echo $leadership . $member["first_name"] ?>
                  </div>
                  <div class="group-info">
                    <?php echo $member["Email"] ?>
                  </div>
                  <div class="group-btn">
                    <form action="" id="userForm" method="post">
                      <input type="text" id="userInput" name="user" value="<?php echo $member['UID'] ?>" style="display:none;">
                      <input type="text" id="groupInput" name="group" value="<?php echo $row['UID'] ?>" style="display:none;">
                      <?php if($member["leader"] == 1){ ?>
                        <button type="submit" id="demoteBut"name="button" class="btn btn-sm btn-info" onclick='this.form.action="group_operations/demote_from_leader.php";'>Demote&nbsp;</button>
                      <?php }
                      else { ?>
                        <button type="submit" id="promotebut" name="button" class="btn btn-sm btn-info" onclick='this.form.action="group_operations/promote_to_leader.php";'>Promote</button>
                      <?php } ?>
                    </form>
                  </div>
                  <div class="group-btn">
                    <form action="" id="userFormRemove" method="post">
                      <input type="text" id="userRemoveInput" name="user" value="<?php echo $member['UID'] ?>" style="display:none;">
                      <input type="text" id="groupRemoveInput" name="group" value="<?php echo $row['UID'] ?>" style="display:none;">
                      <button type="submit" id="removebut" name="button" class="btn btn-sm btn-danger" onclick='this.form.action="group_operations/remove_from_group.php";'>Remove</button>
                    </form>
                  </div>
                </div>
                <?php
              }
              ?>
              <hr style="margin-left:-5%">
              </div>
              <?php
            }
            else
            echo "<p> No members in this group </p>";
            echo "<br />";
          }
        }
        ?>
        <br />
      </div>

    <?php } ?>
		</div>
	</body>
  <div style="padding-top:50px;"></div>
  <div id="addUserGroupModal" class="modal fade" role="dialog">
      <!-- Modal content -->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="addUtoGHeader" class="modal-title">Add User to Group</h4>
            <button type="button" id="addUtoGBut" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form id="AddUserModalForm" name="AddUserGroupModalForm" class="" action="group_operations/add_to_group.php" method="post">
          <div class="modal-body">
            <br>
            Which User? &nbsp;
            <select class="form-control" id="dropdownUser" class="user-select" name="user">
              <?php $query = "SELECT * FROM user ORDER BY first_name";
                    $result = $mysqli->query($query);
                    while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row['UID'] . "'>" . $row['first_name'] ." " . $row['last_name'] . "</option>";
                    }
              ?>
            </select><br><br>
            Will they be a Leader? &nbsp;
            <select class="form-control" id="dropdownLeader" class="leader-select" name="leader">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
            <input type="text" id="inputGroup" name="group" value="" hidden>
          </div>
          <div class="modal-footer">
            <input id="SubmitUserGroup" type="submit" name="addUserGroupSub" value="Add User" class="btn btn-success">
          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="addGroupModal" class="modal fade" role="dialog">
      <!-- Modal content -->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="AddGroupHead" class="modal-title">Add Group</h4>
          <button type="button" id="addGExit" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form id="addModalForm" name="addGroupModalForm" class="" action="group_operations/add_group.php" method="post">
          <div class="modal-body">
            <br>
            Group Name: &nbsp;
            <input class="form-control" id="groupNameInput" type="text" name="group_name" value=""><br>
          </div>
          <div class="modal-footer">
            <input id="AddGroup" type="submit" name="addGroupSub" value="Add Group" class="btn btn-success">
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
    include "footer.php";
   ?>
</html>

<script type="text/javascript">
  function injectGroup(param) {
    let group = $(param).data('group');
    var form = document.forms["AddUserGroupModalForm"];
    form.elements["group"].value = group;
    console.log(group);
  }
</script>
