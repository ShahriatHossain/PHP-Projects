<?php
  require_once('persistence/connection.php');

  if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action     = $_GET['action'];
  } else {
    $controller = 'pages';
    $action     = 'home';
  }

  if(($controller=='users' && $action=='signin') || ($controller=='users' && $action=='signup') || ($controller=='users' && $action=='forgotpassword') || ($controller=='pages' && $action=='error')) {
      require_once('views/layout.php');
    }
  		
    else if($controller=='channels' && $action=='getsubscribedchannels'){
      require_once('views/layout3.php');
    }
  	else {
      switch($controller){
        case 'manageusers':
          $activePage = 'manageusers';
        break;
        case 'manageroles':
          $activePage = 'manageroles';
        break;
        case 'managechannels':
          $activePage = 'managechannels';
        break;
        case 'channels':
          $activePage = 'channels';
        break;
        case 'pages':
          $activePage = ($action=='about')?'about':'home';
        break;
        default:
          $activePage = 'home';
      }
  		require_once('views/layout2.php');
    }
?>