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

    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
  </head>
  <body ng-app="dgnApp">
    <!-- Side Navbar -->
    <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <div class="sidenav-header-inner text-center"><img src="content/images/avatar.png" alt="person" class="img-fluid rounded-circle">
            <h2 class="h5 text-uppercase">Hey</h2><span class="text-uppercase">There</span>
          </div>
          <div class="sidenav-header-logo"><a href="?controller=pages&action=home" class="brand-small text-center"> <strong>U</strong><strong class="text-primary">N</strong></a></div>
        </div>
        <div class="main-menu">
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li class="home"><a href="?controller=pages&action=home"> <i class="icon-home"></i><span>Home</span></a></li>
            <li class="about"> <a href="?controller=pages&action=about"><i class="icon-form"></i><span>About</span></a></li>
            <?php if($_SESSION["loggedInUserRole"] == 1 || $_SESSION["loggedInUserRole"] == 2){?>
            <li class="channels"> <a href="?controller=channels&action=index"><i class="icon-presentation"></i><span>Channels</span></a></li>
            <?php }?>
            <?php if($_SESSION["loggedInUserRole"] == 1){?>
            <li class="managechannels"> <a href="?controller=managechannels&action=index"> <i class="icon-list"> </i><span>Manage Channels</span></a></li>
            <li class="manageusers"> <a href="?controller=manageusers&action=index"> <i class="icon-user"></i><span>Manage Users</span></a></li>
            <li class="manageroles"> <a href="?controller=manageroles&action=index"> <i class="icon-interface-windows"></i><span>Manage Roles</span></a></li>
            <?php }?>
          </ul>
        </div>
      </div>
    </nav>
    <div class="page home-page">
      <!-- navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="?controller=pages&action=home" class="navbar-brand">
                  <div class="brand-text d-none d-md-inline-block"><img src="content/images/logo.png" /></div></a></div>
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell"></i><span class="badge badge-warning" id="noticeCount"></span></a>
                  <ul aria-labelledby="notifications" class="dropdown-menu">
                    <li><a rel="nofollow" href="?controller=channels&action=index" class="dropdown-item"> 
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-envelope"></i><span id="noticeStatus"></span> </div>
                          <div class="notification-time"><small id="noticeTime"></small></div>
                        </div></a></li>
                  </ul>
                </li>
                <?php if(!$_SESSION["isLoggedIn"]):?>
                <li class="nav-item"><a href="?controller=users&action=signin" class="nav-link logout">Sign In<i class="fa fa-sign-out"></i></a></li>
                <?php else:?>
                <li class="nav-item"><a href="?controller=users&action=logout" class="nav-link logout">Log Out<i class="fa fa-sign-out"></i></a></li>
                <?php endif;?>
              </ul>
            </div>
          </div>
        </nav>
        <div class="alert alert-info alert-dismissible fade show" id="noticeAlert" role="alert" style="display: none">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <strong>New notice: </strong> <span id="noticeMsg"></span>
        </div>
      </header>

      <?php require_once('core/routes.php'); ?>


      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p>AppBestir &copy; <?php echo date("Y")?></p>
            </div>
          </div>
        </div>
      </footer>
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
    <script>
      $('.'+'<?php echo $activePage?>').addClass('active');
    </script>

    <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('e1965aad1a0ab55dead4', {
      cluster: 'mt1',
      encrypted: true
    });

    $.ajax({
        dataType: "json",
        url: '?controller=channels&action=getsubscribedchannels',
        success:function(data){  
            var i = 0;
            data.forEach(function(item){
              var channel = pusher.subscribe(item["id"]);
              channel.bind('notice-event', function(data) {
                i = i+1;

                $("#noticeAlert").css("display", "block");
                $("#noticeMsg").html(data["message"]);

                getLatestNotification(i);

              });
            });
        }
    });

    function getLatestNotification(i){
      $("#noticeCount").html(i);
      $("#noticeStatus").html("You have "+i+" new notices");
      $("#noticeTime").html(i+" minutes ago");
    }
  </script>
  </body>
</html>