<!--
  Last Modified: Spring 2018
  Function: Display Address on Profile Page
  Change Log: Restructured the page to conform with the new Profile page
  Error: No Error
-->

<?php
    require_once('../sql_connector.php');
    $UID = $_SESSION["user"];
?>

    <div class="col-md-3 col-sm-3">
        <div class="profile-labels">
            <label class="control-label" >Address</label>
        </div>
        <div class="profile-inputs">
            <?php
            $results = $mysqli->query("SELECT * FROM user WHERE UID = '$UID'");
            while ($row = $results->fetch_assoc()) { ?>
                <input class="form-control" id="Address" type="text" name="address" maxlength="65" value="<?php echo $row['address'] ?>" disabled>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="col-md-3 col-sm-3">
        <div class="profile-labels">
            <label class="control-label" >City</label>
        </div>
        <div class="profile-inputs">
            <?php
            $results = $mysqli->query("SELECT * FROM user WHERE UID = '$UID'");
            while ($row = $results->fetch_assoc()) { ?>
                <input class="form-control" id="City" type="text" name="city" maxlength="50" value="<?php echo $row['city'] ?>" disabled>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="col-md-3 col-sm-3">
        <div class="profile-labels">
            <label class="control-label" >State</label><br>
        </div>
        <div class="profile-inputs">
            <?php
            $results = $mysqli->query("SELECT * FROM user WHERE UID = '$UID'"); ?>

            <?php
            while ($row = $results->fetch_assoc()) { ?>
                <select class="form-control" id="State" name="state" disabled style="width: 178px;">
                  <option value="NU" <?php if($row['state'] == "NU"){?> selected <?php } ?>>Select One</option>
                  <option value="AL" <?php if($row['state'] == "AL"){?> selected <?php } ?>>Alabama</option>
    							<option value="AK" <?php if($row['state'] == "AK"){?> selected <?php } ?>>Alaska</option>
    							<option value="AZ" <?php if($row['state'] == "AZ"){?> selected <?php } ?>>Arizona</option>
    							<option value="AR" <?php if($row['state'] == "AR"){?> selected <?php } ?>>Arkansas</option>
    							<option value="CA" <?php if($row['state'] == "CA"){?> selected <?php } ?>>California</option>
    							<option value="CO" <?php if($row['state'] == "CO"){?> selected <?php } ?>>Colorado</option>
    							<option value="CT" <?php if($row['state'] == "CT"){?> selected <?php } ?>>Connecticut</option>
    							<option value="DE" <?php if($row['state'] == "DE"){?> selected <?php } ?>>Delaware</option>
    							<option value="DC" <?php if($row['state'] == "DC"){?> selected <?php } ?>>District Of Columbia</option>
                  <option value="FL" <?php if($row['state'] == "FL"){?> selected <?php } ?>>Florida</option>
    							<option value="GA" <?php if($row['state'] == "GA"){?> selected <?php } ?>>Georgia</option>
    							<option value="HI" <?php if($row['state'] == "HI"){?> selected <?php } ?>>Hawaii</option>
    							<option value="ID" <?php if($row['state'] == "ID"){?> selected <?php } ?>>Idaho</option>
    							<option value="IL" <?php if($row['state'] == "IL"){?> selected <?php } ?>>Illinois</option>
    							<option value="IN" <?php if($row['state'] == "IN"){?> selected <?php } ?>>Indiana</option>
    							<option value="IA" <?php if($row['state'] == "IA"){?> selected <?php } ?>>Iowa</option>
    							<option value="KS" <?php if($row['state'] == "KS"){?> selected <?php } ?>>Kansas</option>
    							<option value="KY" <?php if($row['state'] == "KY"){?> selected <?php } ?>>Kentucky</option>
    							<option value="LA" <?php if($row['state'] == "LA"){?> selected <?php } ?>>Louisiana</option>
    							<option value="ME" <?php if($row['state'] == "ME"){?> selected <?php } ?>>Maine</option>
    							<option value="MD" <?php if($row['state'] == "MD"){?> selected <?php } ?>>Maryland</option>
    							<option value="MA" <?php if($row['state'] == "MA"){?> selected <?php } ?>>Massachusetts</option>
    							<option value="MI" <?php if($row['state'] == "MI"){?> selected <?php } ?>>Michigan</option>
    							<option value="MN" <?php if($row['state'] == "MN"){?> selected <?php } ?>>Minnesota</option>
    							<option value="MS" <?php if($row['state'] == "MS"){?> selected <?php } ?>>Mississippi</option>
    							<option value="MO" <?php if($row['state'] == "MO"){?> selected <?php } ?>>Missouri</option>
    							<option value="MT" <?php if($row['state'] == "MT"){?> selected <?php } ?>>Montana</option>
    							<option value="NE" <?php if($row['state'] == "NE"){?> selected <?php } ?>>Nebraska</option>
    							<option value="NV" <?php if($row['state'] == "NV"){?> selected <?php } ?>>Nevada</option>
    							<option value="NH" <?php if($row['state'] == "NH"){?> selected <?php } ?>>New Hampshire</option>
    							<option value="NJ" <?php if($row['state'] == "NJ"){?> selected <?php } ?>>New Jersey</option>
    							<option value="NM" <?php if($row['state'] == "NM"){?> selected <?php } ?>>New Mexico</option>
    							<option value="NY" <?php if($row['state'] == "NY"){?> selected <?php } ?>>New York</option>
    							<option value="NC" <?php if($row['state'] == "NC"){?> selected <?php } ?>>North Carolina</option>
    							<option value="ND" <?php if($row['state'] == "ND"){?> selected <?php } ?>>North Dakota</option>
    							<option value="OH" <?php if($row['state'] == "OH"){?> selected <?php } ?>>Ohio</option>
    							<option value="OK" <?php if($row['state'] == "OK"){?> selected <?php } ?>>Oklahoma</option>
    							<option value="OR" <?php if($row['state'] == "OR"){?> selected <?php } ?>>Oregon</option>
    							<option value="PA" <?php if($row['state'] == "PA"){?> selected <?php } ?>>Pennsylvania</option>
    							<option value="RI" <?php if($row['state'] == "RI"){?> selected <?php } ?>>Rhode Island</option>
    							<option value="SC" <?php if($row['state'] == "SC"){?> selected <?php } ?>>South Carolina</option>
    							<option value="SD" <?php if($row['state'] == "SD"){?> selected <?php } ?>>South Dakota</option>
    							<option value="TN" <?php if($row['state'] == "TN"){?> selected <?php } ?>>Tennessee</option>
    							<option value="TX" <?php if($row['state'] == "TX"){?> selected <?php } ?>>Texas</option>
    							<option value="UT" <?php if($row['state'] == "UT"){?> selected <?php } ?>>Utah</option>
    							<option value="VT" <?php if($row['state'] == "VT"){?> selected <?php } ?>>Vermont</option>
    							<option value="VA" <?php if($row['state'] == "VA"){?> selected <?php } ?>>Virginia</option>
    							<option value="WA" <?php if($row['state'] == "WA"){?> selected <?php } ?>>Washington</option>
    							<option value="WV" <?php if($row['state'] == "WV"){?> selected <?php } ?>>West Virginia</option>
    							<option value="WI" <?php if($row['state'] == "WI"){?> selected <?php } ?>>Wisconsin</option>
    							<option value="WY" <?php if($row['state'] == "WY"){?> selected <?php } ?>>Wyoming</option>
    						</select>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="col-md-3 col-sm-3">
        <div class="profile-labels">
            <label class="control-label" >Zip</label>
        </div>
        <div class="profile-inputs">
            <?php
            $results = $mysqli->query("SELECT * FROM user WHERE UID = '$UID'");
            while ($row = $results->fetch_assoc()) { ?>
                <input class="form-control" id="Zip" type="text" name="zip" maxlength="5" value="<?php echo $row['zip'] ?>" disabled>
            <?php
            }
            ?>
        </div>
    </div>
