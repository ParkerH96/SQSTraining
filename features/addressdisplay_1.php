<!--
  Last Modified: Spring 2018
  Function: Display Address on Profile Page
  Change Log: Restructured the page to conform with the new Profile page
  Error: Doesn't load address data into input fields
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
                <input class="form-control" id="Address" type="text" name="address" maxlength="65" value="" disabled>
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
                <input class="form-control" id="City" type="text" name="city" maxlength="50" value="" disabled>
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
    							<option value="GA">Georgia</option>
    							<option value="HI">Hawaii</option>
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
                <input class="form-control" id="Zip" type="text" name="zip" maxlength="5" value="" disabled>
            <?php
            }
            ?>
        </div>
    </div>
