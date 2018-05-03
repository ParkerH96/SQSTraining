<!--
  Last Modified: Spring 2018
  Function: This file is the homepage for the website.
						If the website visitor is not logged in, it gives login instructions (for now).
						If the visitor is logged in, the homepage presents a form for entering phone numbers to associate with the user account.
  Change Log: Completely rehauled look and feel of page
-->

<?php
require_once("../feature_connector.php");

feature_loader("index", $_SESSION['user']);
?>
