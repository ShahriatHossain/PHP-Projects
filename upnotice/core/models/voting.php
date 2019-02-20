<?php
  class Voting {
    public $id;
    public $notice_id;
    public $user_id;
    public $response;

    public function __construct($id, $notice_id, $user_id, $response) {
      $this->id      = $id;
      $this->notice_id  = $notice_id;
      $this->user_id = $user_id;
      $this->response = $response;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM notice_voting');

      // we create a list of vote objects from the database results
      foreach($req->fetchAll() as $voting) {
        $list[] = new Voting($voting['id'], $voting['notice_id'], $voting['user_id'], 
          $voting['response']);
      }

      return $list;
    }

    public static function findByParent($parentId) {
      $list = [];
      $db = Db::getInstance();
      $parentId = intval($parentId);
      $req = $db->prepare('SELECT * FROM notice_voting WHERE notice_id = :notice_id');
      // the query was prepared, now we replace :channel_id with our actual $parentId value
      $req->execute(array('notice_id' => $parentId));

      // we create a list of vote objects from the database results
      foreach($req->fetchAll() as $voting) {
        $list[] = new Voting($voting['id'], $voting['notice_id'], $voting['user_id'], 
          $voting['response']);
      }

      return $list;
    }

    public static function countResponseByParent($parentId) {
      $list = [];
      $db = Db::getInstance();
      $parentId = intval($parentId);
      $req = $db->prepare('SELECT (SELECT COUNT(id) FROM notice_voting WHERE response=1 AND notice_id=:notice_id) AS Yes, (SELECT COUNT(id) FROM notice_voting WHERE response=0 AND notice_id=:notice_id) AS No FROM notice_voting WHERE notice_id=:notice_id');
      // the query was prepared, now we replace :channel_id with our actual $parentId value
      $req->execute(array('notice_id' => $parentId));

      $notice = $req->fetch();
      return $notice;
    }

    public static function save(Voting $voting) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO notice_voting(notice_id, user_id, response) 
        VALUES(:notice_id, :user_id, :response)');

      $req->execute(array('notice_id' => $voting->notice_id, 'user_id'=> $voting->user_id, 'response'=> $voting->response));
    }
  }
?>