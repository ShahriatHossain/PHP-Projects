<?php
  function call($controller, $action) {
    require_once('controllers/' . $controller . '_controller.php');

    switch($controller) {
      case 'pages':
        $controller = new PagesController();
      break;
      case 'contacts':
        // we need the model to query the database later in the controller
        require_once('core/models/contact.php');
        $controller = new ContactsController();
      break;
      case 'users':
        // we need the model to query the database later in the controller
        require_once('core/models/user.php');
        $controller = new UsersController();
      break;
      case 'channels':
        require_once('core/models/channel.php');
        require_once('core/models/notice.php');
        require_once('core/models/user.php');
        require_once('core/models/voting.php');
        require_once('core/models/notice_details.php');
        require_once('core/models/channel_details.php');
        $controller = new ChannelsController();
      break;
      case 'managechannels':
        require_once('core/models/channel.php');
        require_once('core/models/channel_details.php');
        $controller = new ManageChannelsController();
      break;
      case 'manageusers':
        require_once('core/models/user.php');
        require_once('core/models/user_details.php');
        require_once('core/models/user_role.php');
        $controller = new ManageUsersController();
      break;
      case 'manageroles':
        require_once('core/models/user_role.php');
        $controller = new ManageRolesController();
      break;
      case 'managenotices':
        require_once('core/models/channel.php');
        require_once('core/models/notice.php');
        require_once('core/models/notice_details.php');
        $controller = new ManageNoticesController();
      break;
    }

    $controller->{ $action }();
  }


  function genBreadCrumb(Array $pages) {
    $breadcrumb = '<div class="breadcrumb-holder">';
    $breadcrumb .= '<div class="container-fluid">';
    $breadcrumb.= '<ul class="breadcrumb">';
    foreach ($pages as $page) {
      if(!$page->isActive) {
          $breadcrumb.= '<li class="breadcrumb-item"><a href="'.$page->url.'">'.$page->title.'</a></li>';
      }
      else {
          $breadcrumb.= '<li class="breadcrumb-item active" aria-current="page">'.$page->title.'</li>';
      }  
    }
    $breadcrumb.= '</ul>';
    $breadcrumb.= '</div>';
    $breadcrumb.= '</div>';

    return $breadcrumb;
  }
  
  function redirectCall($url) {
     echo "<script type='text/javascript'>  window.location='".$url."'; </script>";
  }

  function hasAccess($roleId) {
    if($_SESSION["loggedInUserRole"] != $roleId) {
      return redirectCall('?controller=pages&action=error');
      exit();  
    }
  }

  function hasLoggedIn() {
    if($_SESSION["loggedInUserRole"] <= 0) {
      return redirectCall('?controller=pages&action=error');
      exit();  
    }
  }

  function randomString($length = 6) {
    $str = "";
    $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
      $rand = mt_rand(0, $max);
      $str .= $characters[$rand];
    }
    return $str;
  }

  function getBaseUrl() {
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
    // Complete the URL
    $url .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    return $url;
  }

  function sendHtmlEmail($title, $description, $to, $subject) {
      $message = "
      <html>
      <head>
      <title>".$title."</title>
      </head>
      <body>
      <p>".$description."</p>
      </body>
      </html>
      ";

      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // More headers
      $headers .= 'From: <info@appbestir.com>' . "\r\n";
      $headers .= 'Cc: info@appbestir.com' . "\r\n";

      mail($to,$subject,$message,$headers);
    }

  // we're adding an entry for the new controller and its actions
  $controllers = array('pages' => ['home', 'error', 'about'],
                      'contacts' => ['index', 'show', 'post'],
                      'users' => ['index', 'signup', 'signin', 'logout', 'forgotpassword', 'changepassword'],
                      'channels' => ['index', 'show', 'post', 'subscribe', 'postnotice', 'postvoting', 'noticedetails', 'getsubscribedchannels'],
                      'managechannels' => ['index', 'edit', 'delete'],
                      'manageusers' => ['index', 'edit', 'delete', 'create'],
                      'manageroles' => ['index', 'edit', 'delete', 'create'],
                      'managenotices' => ['index', 'edit', 'delete', 'create']
                    );

  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      return redirectCall('?controller=pages&action=error');
    }
  } else {
      return redirectCall('?controller=pages&action=error');
  }
?>