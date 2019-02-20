<?php
  class UserRole {
    // they are public so that we can access them using $user->name directly
    public $id;
    public $name;

    public function __construct($id, $name) {
      $this->id      = $id;
      $this->name  = $name;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM user_roles');

      foreach($req->fetchAll() as $role) {
        $list[] = new UserRole($role['id'], $role['name']);
      }

      return $list;
    }

    public static function findByParentByLimit($start, $limit) {
      $list = [];
      $db = Db::getInstance();
      
      $req = $db->prepare('SELECT * FROM user_roles ORDER BY id ASC LIMIT :start OFFSET :offset');

      $req->bindValue(':start', (int) $limit, PDO::PARAM_INT);
      $req->bindValue(':offset', (int) $start, PDO::PARAM_INT);
      $req->execute();
      
      foreach($req->fetchAll() as $role) {
        $list[] = new UserRole($role['id'], $role['name']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM user_roles WHERE id = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $role = $req->fetch();

      return new UserRole($role['id'], $role['name']);
    }

    public static function save(UserRole $role) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO user_roles(name) VALUES(:name)');
      $req->execute(array('name' => $role->name));
    }

    public static function update(UserRole $role) {
      $db = Db::getInstance();      
       $req = $db->prepare('UPDATE user_roles  SET name = :name WHERE id = :id');
      $req->execute(array('id'=> $role->id, 'name' => $role->name));
    }

    public static function delete(UserRole $role) {
      $db = Db::getInstance();      
      $req = $db->prepare('DELETE FROM user_roles WHERE id = :id');
      $req->execute(array('id'=> $role->id));
    }

  }
?>