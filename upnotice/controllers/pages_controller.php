<?php
  class PagesController {
    public function home() {
      if(!$_SESSION["isLoggedIn"]){
        return redirectCall('?controller=users&action=signup');
        exit(); 
      }

      $obj = new stdClass;
      $obj->title = 'Home';
      $obj->url = '?controller=pages&action=home';
      $obj->isActive = true;

      $pages[] = $obj;

      $breadcrumb = genBreadCrumb($pages);
      
      require_once('views/pages/home.php');
    }

    public function about() {
      $homeObj = new stdClass;
      $homeObj->title = 'Home';
      $homeObj->url = '?controller=pages&action=home';
      $homeObj->isActive = false;
      $pages[] = $homeObj;

      $aboutObj = new stdClass;
      $aboutObj->title = 'About';
      $aboutObj->url = '?controller=pages&action=about';
      $aboutObj->isActive = true;
      $pages[] = $aboutObj;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/pages/about.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }
  }
?>