<?php
  //error_reporting(0);
  //Start the session
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="themes/dashboard/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="themes/dashboard/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom icon font-->
    <link rel="stylesheet" href="themes/dashboard/css/fontastic.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="themes/dashboard/css/grasp_mobile_progress_circle-1.0.0.min.css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="themes/dashboard/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="themes/dashboard/css/style.blue.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="themes/dashboard/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="favicon.png">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]--> 

    <link href="content/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet" />
    <link href="content/pace.css" rel="stylesheet" />
    <!-- for pie chart -->
    <script src="scripts/chart/Chart.bundle.min.js"></script>
    <script src="scripts/chart/utils.js"></script>
  </head>
  <body ng-app="dgnApp">
    <div class="page login-page">
      <div class="container">
        <?php require_once('core/routes.php'); ?>
      </div>
    </div>

    <!-- Javascript files-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"> </script>
    <script src="themes/dashboard/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="themes/dashboard/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="themes/dashboard/js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="themes/dashboard/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="themes/dashboard/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="themes/dashboard/js/charts-home.js"></script>
    <script src="themes/dashboard/js/front.js"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <!---->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>


    <script src="scripts/pace.min.js" type="text/javascript"></script>

    
    <script src="scripts/angular.min.js"></script>
    <script src="scripts/app.js"></script>
  </body>
</html>