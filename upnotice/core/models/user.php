<?php
  class User {
    // they are public so that we can access them using $user->name directly
    public $id;
    public $name;
    public $address;
    public $email;
    public $password;
    public $role_id;

    public function __construct($id, $name, $address, $email, $password, $role_id) {
      $this->id      = $id;
      $this->name  = $name;
      $this->address = $address;
      $this->email = $email;
      $this->password = $password;
      $this->role_id = $role_id;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM users');

      // we create a list of User objects from the database results
      foreach($req->fetchAll() as $user) {
        $list[] = new User($user['id'], $user['name'], $user['address'], $user['email'], $user['password'], $user['role_id']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM users WHERE id = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $user = $req->fetch();

      return new User($user['id'], $user['name'], $user['address'], $user['email'], $user['password'], $user['role_id']);
    }

    public static function save(User $user) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO users(name, address, email, password, role_id) VALUES(:name, :address, :email, :password, :role_id)');
      $req->execute(array('name' => $user->name, 'address' => $user->address, 'email' => $user->email, 'password' => md5($user->password), 'role_id' => $user->role_id));
    }

    public static function verify(User $user) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
      // the query was prepared, now we replace :email and :password with our actual $email and $password value
      $req->execute(array('email' => $user->email, 'password' => md5($user->password)));
      $user = $req->fetch();
      
      if($user['id'] > 0)
        return true;
      else 
        return false;
    }

    public static function isUserExist(User $user) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM users WHERE email = :email');
      // the query was prepared, now we replace :email and :password with our actual $email and $password value
      $req->execute(array('email' => $user->email));
      $user = $req->fetch();
      
      if($user['id'] > 0)
        return true;
      else 
        return false;
    }

    public static function findByObject(User $user) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
      // the query was prepared, now we replace :email and :password with our actual $email and $password value
      $req->execute(array('email' => $user->email, 'password' => md5($user->password)));
      $user = $req->fetch();
      
      return new User($user['id'], $user['name'], $user['address'], $user['email'], $user['password'], $user['role_id']);
    }

    public static function findByEmail(User $user) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM users WHERE email = :email');
      $req->execute(array('email' => $user->email));
      $user = $req->fetch();
      
      return new User($user['id'], $user['name'], $user['address'], $user['email'], $user['password'], $user['role_id']);
    }

    public static function findSubscribers($channelId) {
      $list = [];
      $db = Db::getInstance();
      $req = $db->prepare('SELECT DISTINCT u.id, u.name, u.address, u.email FROM users u 
        LEFT JOIN channel_subscribers chs ON u.id=chs.user_id WHERE chs.channel_id = :channel_id');

      $req->execute(array('channel_id' => $channelId));

      // we create a list of User objects from the database results
      foreach($req->fetchAll() as $user) {
        $list[] = new User($user['id'], $user['name'], $user['address'], $user['email'], $user['password'], $user['role_id']);
      }

      return $list;
    }

    public static function update(User $user) {
      $db = Db::getInstance();      
       $req = $db->prepare('UPDATE users  SET name = :name, address = :address, email = :email, password = :password, role_id = :role_id WHERE id = :id');
      $req->execute(array('id'=> $user->id, 'name' => $user->name, 'address' => $user->address, 'email'=> $user->email , 'password'=> $user->password, 'role_id'=> $user->role_id));
    }

    public static function updatePassword(User $user) {
      $db = Db::getInstance();      
      $req = $db->prepare('UPDATE users  SET password = :password WHERE id = :id');
      $req->execute(array('id'=> $user->id, 'password' => md5($user->password)));
    }

    public static function delete(User $user) {
      $db = Db::getInstance();      
      $req = $db->prepare('DELETE FROM users WHERE id = :id');
      $req->execute(array('id'=> $user->id));
    }

  }
?>