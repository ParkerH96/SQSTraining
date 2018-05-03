<!--
  Last Modified: Spring 2018
  Function: This file is the homepage for the website.
						If the website visitor is not logged in, it gives login instructions (for now).
						If the visitor is logged in, the homepage presents a form for entering phone numbers to associate with the user account.
  Change Log: Completely rehauled look and feel of page
-->

<?php
	//Load the header and the sql connection file
	include 'config/header.php';
	require_once('../sql_connector.php');
?>

<?php
	if(isset($_SESSION['SMSReport']))
	{
		echo $_SESSION['SMSReport'];
		unset($_SESSION['SMSReport']);
	}
	if(isset($_SESSION['SubscriptionReport']))
	{
		echo $_SESSION['SubscriptionReport'];
		unset($_SESSION['SubscriptionReport']);
	}
?>

<html>
	<div id="home_page">
	  <body>
	    <div>
				<?php
					if(isset($_SESSION['user'])){ ?>
					<h2>Welcome to the SQS Training Home Page</h2>
					<br>
					<iframe width="1024" height="576" src="https://www.youtube.com/embed/UE3pkxPVLiw?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
						<br><br>
						<?php
						include("phone_signup.php");
					}
					else
						/*Assume that phone numbers ought to be associated with account names. If not, a "No Association" account could be associated with those phone numbers added when no one was logged in. (Accounts can have more than one phone number).
					In the case that the user is logged in, what should be displayed instead? A description of the website?
					*/
						include("site_description_paragraph.php");
				?>
			</div>
	  </body>
		<?php
		/* Currently the footer is just a simple example of the features_loader function. */
			include "footer.php";
		?>
	</div>
</html>
