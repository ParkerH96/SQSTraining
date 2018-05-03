<!--
  Last Modified: Spring 2018
  Function: Display Groups on Profile page
  Change Log: Restructed to conform with new profile page
  Error: Displays no groups regardless if user is in any groups
-->

<?php
			require_once('../sql_connector.php');

			$UID = $_SESSION["user"];

			//Retrieve and display group information
			$group_names = [];
			$group_ids = [];
			$number_of_groups = 0;
			$result1 = $mysqli->query("SELECT * FROM group_members INNER JOIN groups ON group_members.group_id = groups.uid WHERE group_members.uid = '$UID';");
			if($result1->num_rows > 0) {
				$number_of_groups = $result1->num_rows;
				while($row = $result1->fetch_assoc())
					array_push($group_names, $row["name"]);
			}
			?>

			<div class="col-md-4 col-sm-4">
				<div class="profile-labels">
					<label class="control-label" >Groups</label>
				</div>
				<div class="profile-inputs">
				<?php
					//if($number_of_groups == 0)
						echo "None";
					//else
						//foreach($group_names as $key => $val)
							//echo $val."<br />"
					?>
					</div>
				</div>
