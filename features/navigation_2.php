<!--
  Last Modified: Spring 2018
  Function: Displays Nav bar at top of the page content
  Change Log: Restructured to look better
  Error: Doesn't Display Profile Link
-->

<div id="heading2">
  <?php //The navigation bar based on user level ?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="col-md-10">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li><a class="nav-link" href="./">Home </a></li>

          <?php if(isset($_SESSION['user'])){ ?>

            <!-- <li><a class="nav-link" href="profile.php">Profile</a></li> -->

            <li><a class="nav-link" href="groups.php">Groups</a></li>
            <?php if($_SESSION['level'] == '5' || $_SESSION['level'] == '6'){ ?>

              <li class="dropdown">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="javascript:void(0)">Admin
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="admin_user_info.php">Users</a></li>
                  <li><a class="nav-link" href="admin_skills.php">Skills</a></li>
                  <li><a class="nav-link" href="user_features.php">Features</a></li>
                </ul>
              </li>


            <?php } else if($_SESSION['level'] == '4'){ ?>

              <li><a class="nav-link" href="superuser_user_info.php">Superuser Page</a></li>

            <?php } ?>

            <li><a class="nav-link" href="http://sqs.com/">SQS Site</a></li>
            <li><a class="nav-link" href="log_out.php">Log out</a></li>

          <?php } else { ?>

            <li><a class="nav-link" href="user_login.php">Sign in</a></li>
            <li><a class="nav-link" href="user_register.php">Sign up</a></li>

          <?php } ?>

        </ul>
      </div>
    </div>
    <div class="col-md-2">
      <a href="./"><img id="header-img" src="assets/images/logo.png" alt="SQS logo"></a>
    </div>
  </nav>


</div> <!-- /container -->
