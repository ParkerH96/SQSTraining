<!--
  Last Modified: Spring 2018
  Function: Displays phone numbers on Profile Page
  Change Log: Restructured to conform to new profile page
  Error: Displays "No Registered Numbers" regardless if the user has numbers
-->

<?php
	require_once('../sql_connector.php');

	$phone_numbers = [];
	$phone_number_ids = [];
	$group_ids = [];
	$number_of_phones = 0;
	$UID = $_SESSION["user"];

	$result1 = $mysqli->query("SELECT * FROM phone_list WHERE user_id = '$UID';");

	if($result1->num_rows > 0){
		$number_of_phones = $result1->num_rows;
		while($row = $result1->fetch_assoc()){
			array_push($phone_numbers, $row["phone_number"]);
			array_push($phone_number_ids, $row["id"]);
		}
	}
	?>
	<div class="col-md-4 col-sm-4">
		<div class="profile-labels">
			<label class="control-label" >Tel. Numbers</label>
		</div>
		<div class="profile-inputs">
			<?php
			//if($number_of_phones == 0){
			if(1){
				echo "No Registered Numbers";
			}
			else {
				foreach($phone_numbers as $key => $val) {
					echo '<input class="form-control" id="phone_number'.$key.'" type="text" name="phone_number'.$key.'" value="'.$val.'" disabled><br />';
				}
			}
			?>
		</div>
	</div>
