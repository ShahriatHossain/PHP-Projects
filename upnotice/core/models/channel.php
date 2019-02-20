<?php
  class Channel {
    public $id;
    public $name;
    public $created_by;
    public $notice_count;

    public function __construct($id, $name, $created_by, $notice_count) {
      $this->id      = $id;
      $this->name  = $name;
      $this->created_by = $created_by;
      $this->notice_count = $notice_count;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM channels');

      // we create a list of channel objects from the database results
      foreach($req->fetchAll() as $channel) {
        $list[] = new Channel($channel['id'], $channel['name'], $channel['created_by'], self::countNotices($channel['id']));
      }

      return $list;
    }

    public static function findByCreator($createdBy) {
      $list = [];
      $db = Db::getInstance();
      $createdBy = intval($createdBy);
      $req = $db->prepare('SELECT * FROM channels WHERE created_by = :created_by');
      // the query was prepared, now we replace :createdBy with our actual $createdBy value
      $req->execute(array('created_by' => $createdBy));

      // we create a list of channel objects from the database results
      foreach($req->fetchAll() as $channel) {
        $list[] = new Channel($channel['id'], $channel['name'], $channel['created_by'], self::countNotices($channel['id']));
      }

      return $list;
    }

    public static function findBySubscriber($subscribedBy) {
      $list = [];
      $db = Db::getInstance();
      $subscribedBy = intval($subscribedBy);
      $req = $db->prepare('SELECT DISTINCT ch.id, ch.name, ch.created_by FROM channels ch 
        LEFT JOIN channel_subscribers chs ON ch.id=chs.channel_id WHERE chs.user_id = :subscribed_by');
      // the query was prepared, now we replace :subscribed_by with our actual $subscribedBy value
      $req->execute(array('subscribed_by' => $subscribedBy));
      
      // we create a list of channel objects from the database results
      foreach($req->fetchAll() as $channel) {
        $list[] = new Channel($channel['id'], $channel['name'], $channel['created_by'], self::countNotices($channel['id']));
      }

      return $list;
    }

    public static function findByNotSubscribedOrOwned($userId) {
      $list = [];
      $db = Db::getInstance();
      $userId = intval($userId);
      $req = $db->prepare('
        SELECT * FROM channels WHERE id NOT IN (SELECT DISTINCT ch.id FROM channels ch
          INNER JOIN channel_subscribers chs ON ch.id=chs.channel_id
          UNION 
          SELECT id FROM channels WHERE created_by = :user_id)
        ');
      // the query was prepared, now we replace :subscribed_by with our actual $subscribedBy value
      $req->execute(array('user_id' => $userId));
      
      // we create a list of channel objects from the database results
      foreach($req->fetchAll() as $channel) {
        $list[] = new Channel($channel['id'], $channel['name'], $channel['created_by'], self::countNotices($channel['id']));
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM channels WHERE id = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $channel = $req->fetch();

      return new Channel($channel['id'], $channel['name'], $channel['created_by'], self::countNotices($channel['id']));
    }

    public static function subscribe($channelId, $userId) {
        $db = Db::getInstance();
        $channelId = intval($channelId);
        $userId = intval($userId);

        $req = $db->prepare('INSERT INTO channel_subscribers(user_id,channel_id) VALUES(:user_id, :channel_id)');
        $req->execute(array('channel_id' => $channelId, 'user_id'=> $userId));
    }

    public static function save(Channel $channel) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO channels(name,created_by) VALUES(:name, :created_by)');
      $req->execute(array('name' => $channel->name, 'created_by'=> $channel->created_by));
    }

    public static function update(Channel $channel) {
      $db = Db::getInstance();      
      $req = $db->prepare('UPDATE channels SET name = :name WHERE id = :id');
      $req->execute(array('name' => $channel->name, 'id'=> $channel->id));
    }

    public static function delete(Channel $channel) {
      $db = Db::getInstance();      
      $req = $db->prepare('DELETE FROM channels WHERE id = :id');
      $req->execute(array('id'=> $channel->id));
    }

    private static function countNotices($parentId) {
      $list = [];
      $db = Db::getInstance();
      $parentId = intval($parentId);
      $req = $db->prepare('SELECT COUNT(*) FROM notices WHERE channel_id = :channel_id');
      // the query was prepared, now we replace :channel_id with our actual $parentId value
      $req->execute(array('channel_id' => $parentId));

      return $req->fetchColumn();     
    }


  }
?>