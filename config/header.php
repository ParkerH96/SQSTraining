<!-- Loaded into every file - Contains all includes for every library used throughout the site -->
<?php
  session_start();
  require_once("../feature_connector.php");
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/jquery.min.js"><\/script>')</script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>


    <script type="text/javascript">
      $(document).ready(function(){

        if($(window).width() > 767){
          $('.navbar .dropdown').hover(function() {
            $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();

          }, function() {
            $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp();

          });

          $('.navbar .dropdown > a').click(function(){
            location.href = this.href;
          });
        }
      });
    </script>

  </head>

  <body>

    <?php
      feature_loader("navigation", $_SESSION['user']);
     ?>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
