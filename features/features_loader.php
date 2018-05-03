<!-- This file contains the function used to customize user accounts.
The function is called "feature_loader". With the help of its helper function "get_version_number", it loads the php code for assigned features. -->

<!-- Completely restructed to work with new database requirments -->

<!--
  Last Modified: Spring 2018
  Function: This file contains the function used to customize user accounts.
						The function is called "feature_loader". With the help of its helper
						function "get_version_number", it loads the php code for assigned features.
  Change Log: Restructured to conform to new database changes and to actually work
-->

<?php

include_once '../sql_connector.php';

function get_feature($target, $uid){
	global $mysqli;

	$result = $mysqli->query("SELECT fa.file FROM assigned_features as af LEFT JOIN features_available as fa ON af.feature_number=fa.id WHERE af.user_id=$uid AND fa.target='$target' ORDER BY fa.id DESC");
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			return $row["file"];
		}
	}

	$result = $mysqli->query("SELECT group_id FROM group_members WHERE uid = $uid");
	if($result->num_rows > 0) {
		while ($group_row = $result->fetch_assoc()) {
			$result1 = $mysqli->query("SELECT fa.file FROM assigned_group_features as af LEFT JOIN features_available as fa ON af.feature_number=fa.id WHERE af.group_id=" . $group_row['group_id'] . " AND fa.target='$target' ORDER BY fa.id DESC");
			if($result1->num_rows > 0) {
				while($row = $result1->fetch_assoc()) {
					return $row["file"];
				}
			}
		}
	}

	$sql = "SELECT file FROM features_available WHERE target='$target' ORDER BY file;";
	$result = $mysqli->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			return $row["file"];
		}
	}

	return "0";
}

/** feature_loader is the function that allows each user account to see a custom version of the website.
* The $name feature names the feature requested by a webpage's php code.
* For example, "phonesub" refers to the feature that lists a user's phone subscriptions.
* The $user_email parameter is retrieved from a session variable of the logged-in user.
*/
function feature_loader($target, $user_id){

	global $mysqli;

	$feature = get_feature($target, $user_id);

	if($feature != "0"){
		include $feature;
	}
	else {
		echo "An error occurred in the feature loader sql query";
	}
}

?>
