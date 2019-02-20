<?php
  class UsersController {
    public function index() {
      // we store all the users in a variable
      $users = User::all();
      require_once('views/users/index.php');
    }

    public function show() {
      // we expect a url of form ?controller=users&action=show&id=x
      // without an id we just redirect to the error page as we need the post id to find it in the database
      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $user = User::find($_GET['id']);
      require_once('views/users/show.php');
    }

    public function signup() {
      // we expect a url of form ?controller=users&action=signup
      $validObj = new stdClass;
      $validObj->email = "";
      $validObj->password = "";
      $validObj->cpassword = "";
      $validObj->emailMsg = "";
      $validObj->passwordMsg = "";
      $validObj->passwordMatchMsg = "";

      if(isset($_POST['submit'])){
          $user = new User(0, '', '', $_POST['email'], $_POST['password'], 2);

          $validObj->email = $_POST['email'];
          $validObj->password = $_POST['password'];
          $validObj->cpassword = $_POST['cpassword'];

          if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $validObj->emailMsg = "Valid email is required";
          }
          else if(empty($_POST['password'])){
            $validObj->passwordMsg = "Password is required";
          }
          else if($_POST['password'] != $_POST['cpassword']){
            $validObj->passwordMatchMsg = "Password doesn't match";
          }
          else {
            $isUserExist = User::isUserExist($user);
            if($isUserExist) {
              $validObj->emailMsg = "Email is exist, please choose different one.";
            }
            else {
              User::save($user);
              return redirectCall('?controller=users&action=signin');
            }
          }

          
      }

      require_once('views/users/signup.php');
    }

    public function signin() {
        // we expect a url of form ?controller=users&action=signin
        $validObj = new stdClass;
        $validObj->email = "";
        $validObj->password = "";
        $validObj->emailMsg = "";
        $validObj->passwordMsg = "";

        if(isset($_POST['submit'])){
          $validObj->email = $_POST['email'];
          $validObj->password = $_POST['password'];

            if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
              $validObj->emailMsg = "Valid email is required";
            }
            else if(empty($_POST['password'])){
              $validObj->passwordMsg = "Password is required";
            }
            else {
              $user = new User(0, '', '', $_POST['email'], $_POST['password']);
              $isVerifiedUser = User::verify($user);
              $userDetails = User::findByObject($user);

              if($isVerifiedUser) {
                $_SESSION["isLoggedIn"] = true;
                $_SESSION["loggedInUserId"] = $userDetails->id;
                $_SESSION["loggedInUserRole"] = $userDetails->role_id;
                return redirectCall('?controller=pages&action=home');
                exit();          
              }
              else {
                $_SESSION["isLoggedIn"] = false;
                $_SESSION["loggedInUserId"] = 0;
                $_SESSION["loggedInUserRole"] = '';
                return redirectCall('?controller=pages&action=error');
                exit();     
              }
          }

        }

        require_once('views/users/signin.php');
      }

      public function forgotpassword() {

        $validObj = new stdClass;
        $validObj->email = "";
        $validObj->emailMsg = "";

        $successMsg = '';

        if(isset($_POST['submit'])){
          $validObj->email = $_POST['email'];

            if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
              $validObj->emailMsg = "Valid email is required";
            }
            else {
              $user = new User(0, '', '', $_POST['email']);
              $isUserExist = User::isUserExist($user);
              if(!$isUserExist) {
                $validObj->emailMsg = "This user doesn't exist in our system.";
              }
              else {
                $title = "Please click on this below link to change your password: ";
                $description = getBaseUrl()+"?controller=users&action=changepassword";
                $to = $userDetails->email;
                $subject = "You have requested to change your password";

                sendHtmlEmail($title, $description, $to, $subject);

                $successMsg = "An email has been sent to your email address to change your password.";
              }
          }

        }

        require_once('views/users/forgotpassword.php');
      }

      public function changepassword() {

        $validObj = new stdClass;
        $validObj->email = "";
        $validObj->password = "";
        $validObj->emailMsg = "";
        $validObj->passwordMsg = "";

        $successMsg = '';

        if(isset($_POST['submit'])){
            $validObj->email = $_POST['email'];
            $validObj->password = $_POST['password'];

            if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
              $validObj->emailMsg = "Valid email is required";
            }
            else if(empty($_POST['password'])){
              $validObj->passwordMsg = "Password is required";
            }
            else {
              $user = new User(0, '', '', $_POST['email']);
              $isUserExist = User::isUserExist($user);
              if(!$isUserExist) {
                $validObj->emailMsg = "This user doesn't exist in our system.";
              }
              else {
                $userDetails = User::findByEmail($user);
                $userDetails->password = $_POST['password'];

                User::updatePassword($userDetails);

                $successMsg = 'Your password has been changed successfully';

                return redirectCall('?controller=users&action=signin');
                exit();
              }
          }

        }

        require_once('views/users/changepassword.php');
      }

      public function logout(){
        $_SESSION["isLoggedIn"] = false;
        $_SESSION["loggedInUserId"] = 0;
        $_SESSION["loggedInUserRole"] = '';
        return redirectCall('?controller=users&action=signin');
        exit();
      }
  }
  
?>