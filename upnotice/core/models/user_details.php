<?php
  class UserDetails {
    // they are public so that we can access them using $user->name directly
    public $id;
    public $name;
    public $address;
    public $email;
    public $password;
    public $role_id;
    public $role_name;

    public function __construct($id, $name, $address, $email, $password, $role_id, $role_name) {
      $this->id      = $id;
      $this->name  = $name;
      $this->address = $address;
      $this->email = $email;
      $this->password = $password;
      $this->role_id = $role_id;
      $this->role_name = $role_name;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT u.id, u.name, u.address, u.email, u.password, u.role_id, ul.name AS role_name FROM users u LEFT JOIN user_roles ul ON u.role_id=ul.id');

      // we create a list of User objects from the database results
      foreach($req->fetchAll() as $user) {
        $list[] = new UserDetails($user['id'], $user['name'], $user['address'], $user['email'], $user['password'], $user['role_id'], $user['role_name']);
      }

      return $list;
    }

    public static function findByParentByLimit($start, $limit) {
      $list = [];
      $db = Db::getInstance();
      
      $req = $db->prepare('SELECT u.id, u.name, u.address, u.email, u.password, u.role_id, ul.name AS role_name FROM users u LEFT JOIN user_roles ul ON u.role_id=ul.id ORDER BY u.id DESC LIMIT :start OFFSET :offset');

      $req->bindValue(':start', (int) $limit, PDO::PARAM_INT);
      $req->bindValue(':offset', (int) $start, PDO::PARAM_INT);
      $req->execute();
      
      foreach($req->fetchAll() as $user) {
        $list[] = new UserDetails($user['id'], $user['name'], $user['address'], $user['email'], $user['password'], $user['role_id'], $user['role_name']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT u.id, u.name, u.address, u.email, u.password, u.role_id, ul.name role_name FROM users u LEFT JOIN user_roles ul ON u.role_id=ul.id WHERE u.id = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $user = $req->fetch();

      return new UserDetails($user['id'], $user['name'], $user['address'], $user['email'], $user['password'], $user['role_id'], $user['role_name']);
    }
  }
?>