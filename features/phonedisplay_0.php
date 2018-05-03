<!--
  Last Modified: Spring 2018
  Function: Displays phone numbers on Profile Page
  Change Log: Restructured to conform to new profile page
  Error: No Error
-->

<?php
	require_once('../sql_connector.php');

	$phone_numbers = [];
	$phone_number_ids = [];
	$group_ids = [];
	$number_of_phones = 0;
	$UID = $_SESSION["user"];

	$result1 = $mysqli->query("SELECT * FROM phone_list WHERE user_id = '$UID';");
	$total_numbers = $result1->num_rows;

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
		<div class="profile-inputs" id="pn-container">
			<?php
			if($number_of_phones == 0){
				echo "No Registered Numbers<br>";
			}
			else {
				foreach($phone_numbers as $key => $val) {
					echo '<div><input class="form-control" style="display: none;" type="number" value="' . $phone_number_ids[$key] . '" name="phone_id[]"><input id="phone_number'.$key.'" disabled type="text" class="form-control phone-numbers"
					name="phone_number[]" value="'.$val.'"> <button type="button" style="display: none; height: 30px; margin-bottom: 4px;" data-id="' . $key . '"class="deletePN btn btn-danger btn-sm"><i class="fas fa-minus"></i>
					</button></div>';
				}
			}
			?>
		</div>
		<button type="button" style="display: none" id="addPhoneNumber" name="addPhoneNumber" class="btn btn-success btn-sm">Add Number</button>
	</div>
