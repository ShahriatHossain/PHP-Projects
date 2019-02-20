<?php
  class ManageRolesController {
    public function index() {
      hasAccess(1);

      // for pagination
      $limit = 20;  
      if (isset($_GET["page"])) { $page  = $_GET["page"]; }
      else { $page=1; };  
      $start = ($page-1) * $limit;
      $pageLink = $this->makePagination($limit, $page);

      $roles = UserRole::findByParentByLimit($start, $limit);

      $homeObj = new stdClass;
      $homeObj->title = 'Home';
      $homeObj->url = '?controller=pages&action=home';
      $homeObj->isActive = false;
      $pages[] = $homeObj;

      $roleList = new stdClass;
      $roleList->title = 'Manage Roles';
      $roleList->url = '?controller=manageroles&action=index';
      $roleList->isActive = true;
      $pages[] = $roleList;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/roles/index.php');
    }

    public function create() {
      if(isset($_POST['submit'])){
        $role = new UserRole(0, $_POST['name']);
        UserRole::save($role);

        return redirectCall('?controller=manageroles&action=index');
      }
    }

    public function edit() {
      hasAccess(1);

      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right channel
      $role = UserRole::find($_GET['id']);

      if(isset($_POST['submit'])){
          $role = new UserRole($role->id, $_POST['name']);
          UserRole::update($role);
          return redirectCall('?controller=manageroles&action=index');
      }

      $homeObj = new stdClass;
      $homeObj->title = 'Home';
      $homeObj->url = '?controller=pages&action=home';
      $homeObj->isActive = false;
      $pages[] = $homeObj;

      $roleList = new stdClass;
      $roleList->title = 'Manage Roles';
      $roleList->url = '?controller=manageroles&action=index';
      $roleList->isActive = false;
      $pages[] = $roleList;

      $editRoleObj = new stdClass;
      $editRoleObj->title = 'Edit Role';
      $editRoleObj->url = '?controller=manageroles&action=edit&id='.$_GET['id'];
      $editRoleObj->isActive = true;
      $pages[] = $editRoleObj;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/roles/edit.php');
    } 

    public function delete() {
      hasAccess(1);

      if (!isset($_GET['id']))
        return call('pages', 'error');
      // we use the given id to get the right channel
      $role = UserRole::find($_GET['id']);

      UserRole::delete($role);
      return redirectCall('?controller=manageroles&action=index');
    }

    private function makePagination($limit, $defaultPage) {
      $roles = UserRole::all();
      $pages = ceil(count($roles)/$limit);
      $pagLink = '';

      if($defaultPage > 1){
        $prev_page = $defaultPage-1;
        $pagLink .= '<li class="page-item"><a class="page-link" href="?controller=manageroles&action=index&page='.$prev_page.'">Previous</a></li>';  
      }

      for ($i=1; $i<=$pages; $i++) {  
        $active = '';
        if($defaultPage == $i)
          $active = 'active';

        $pagLink .= '<li class="page-item '.$active.'"><a class="page-link" href="?controller=manageroles&action=index&page='.$i.'">'.$i.'</a></li>';  
      };  

      if($defaultPage < $pages){
        $next_page = $defaultPage+1;
        $pagLink .=  '<li class="page-item"><a class="page-link" href="?controller=manageroles&action=index&page='.$next_page.'">Next</a></li>'; 
      }

      return $pagLink;
    }
  }
  
?>