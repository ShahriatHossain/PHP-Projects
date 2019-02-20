<?php
  class ManageUsersController {
    public function index() {
      hasAccess(1);

      // for pagination
      $limit = 20;  
      if (isset($_GET["page"])) { $page  = $_GET["page"]; }
      else { $page=1; };  
      $start = ($page-1) * $limit;
      $pageLink = $this->makePagination($limit, $page);

      $users = UserDetails::findByParentByLimit($start, $limit);

      $homeObj = new stdClass;
      $homeObj->title = 'Home';
      $homeObj->url = '?controller=pages&action=home';
      $homeObj->isActive = false;
      $pages[] = $homeObj;

      $userList = new stdClass;
      $userList->title = 'Manage Users';
      $userList->url = '?controller=manageusers&action=index';
      $userList->isActive = true;
      $pages[] = $userList;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/users/index.php');
    }

    public function edit() {
      hasAccess(1);

      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right channel
      $user = User::find($_GET['id']);
      $roles = UserRole::all();

      $validObj = new stdClass;
      $validObj->email = $user->email;
      $validObj->password = $user->password;
      $validObj->role = $user->role_id;
      $validObj->name = $user->name;
      $validObj->address = $user->address;
      $validObj->emailMsg = "";
      $validObj->passwordMsg = "";
      $validObj->roleMsg = "";

      if(isset($_POST['submit'])){
          $user = new User($user->id, $_POST['name'], $_POST['address'], $_POST['email'], $_POST['password'], $user->role_id);

          $validObj->email = $_POST['email'];
          $validObj->password = $_POST['password'];
          $validObj->role = $_POST['role_id'];
          $validObj->name = $_POST['name'];
          $validObj->address = $_POST['address'];

          if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $validObj->emailMsg = "Valid email is required";
          }
          else if(empty($_POST['password'])){
            $validObj->passwordMsg = "Password is required";
          }
          else if(empty($_POST['role_id'])){
            $validObj->roleMsg = "Role is required";
          }
          else{
            User::update($user);
            return redirectCall('?controller=manageusers&action=index');
          }

          
      }

      $homeObj = new stdClass;
      $homeObj->title = 'Home';
      $homeObj->url = '?controller=pages&action=home';
      $homeObj->isActive = false;
      $pages[] = $homeObj;

      $userList = new stdClass;
      $userList->title = 'Manage Users';
      $userList->url = '?controller=manageusers&action=index';
      $userList->isActive = false;
      $pages[] = $userList;

      $editUserObj = new stdClass;
      $editUserObj->title = 'Edit User';
      $editUserObj->url = '?controller=manageusers&action=edit&id='.$_GET['id'];
      $editUserObj->isActive = true;
      $pages[] = $editUserObj;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/users/edit.php');
    } 

    public function create() {
      hasAccess(1);

      $roles = UserRole::all();

      $validObj = new stdClass;
      $validObj->email = "";
      $validObj->password = "";
      $validObj->role = "";
      $validObj->name = "";
      $validObj->address = "";
      $validObj->emailMsg = "";
      $validObj->passwordMsg = "";
      $validObj->roleMsg = "";

      if(isset($_POST['submit'])){
          $user = new User(0, $_POST['name'], $_POST['address'], $_POST['email'], $_POST['password'], $_POST['role_id']);

          $validObj->email = $_POST['email'];
          $validObj->password = $_POST['password'];
          $validObj->role = $_POST['role_id'];
          $validObj->name = $_POST['name'];
          $validObj->address = $_POST['address'];

          if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $validObj->emailMsg = "Valid email is required";
          }
          else if(empty($_POST['password'])){
            $validObj->passwordMsg = "Password is required";
          }
          else if(empty($_POST['role_id'])){
            $validObj->roleMsg = "Role is required";
          }
          else{
            User::save($user);
            return redirectCall('?controller=manageusers&action=index');
          }

          
      }

      $homeObj = new stdClass;
      $homeObj->title = 'Home';
      $homeObj->url = '?controller=pages&action=home';
      $homeObj->isActive = false;
      $pages[] = $homeObj;

      $userList = new stdClass;
      $userList->title = 'Manage Users';
      $userList->url = '?controller=manageusers&action=index';
      $userList->isActive = false;
      $pages[] = $userList;

      $createUserObj = new stdClass;
      $createUserObj->title = 'Create User';
      $createUserObj->url = '?controller=manageusers&action=create';
      $createUserObj->isActive = true;
      $pages[] = $createUserObj;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/users/create.php');
    } 

    public function delete() {
      hasAccess(1);

      if (!isset($_GET['id']))
        return call('pages', 'error');
      // we use the given id to get the right channel
      $user = User::find($_GET['id']);

      User::delete($user);
      return redirectCall('?controller=manageusers&action=index');
    }

    private function makePagination($limit, $defaultPage) {
      $users = UserDetails::all();
      $pages = ceil(count($users)/$limit);
      $pagLink = '';

      if($defaultPage > 1){
        $prev_page = $defaultPage-1;
        $pagLink .= '<li class="page-item"><a class="page-link" href="?controller=manageusers&action=index&page='.$prev_page.'">Previous</a></li>';  
      }

      for ($i=1; $i<=$pages; $i++) {  
        $active = '';
        if($defaultPage == $i)
          $active = 'active';

        $pagLink .= '<li class="page-item '.$active.'"><a class="page-link" href="?controller=manageusers&action=index&page='.$i.'">'.$i.'</a></li>';  
      };  

      if($defaultPage < $pages){
        $next_page = $defaultPage+1;
        $pagLink .=  '<li class="page-item"><a class="page-link" href="?controller=manageusers&action=index&page='.$next_page.'">Next</a></li>'; 
      }

      return $pagLink;
    }
  }
  
?>