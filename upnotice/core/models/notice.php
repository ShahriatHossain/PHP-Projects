<?php
  class Notice {
    public $id;
    public $channel_id;
    public $notice;
    public $description;
    public $filename;
    public $file_displayname;
    public $created_date;

    public function __construct($id, $channel_id, $notice, $description, $filename, $file_displayname, $created_date) {
      $this->id      = $id;
      $this->channel_id  = $channel_id;
      $this->notice = $notice;
      $this->description = $description;
      $this->filename      = $filename;
      $this->file_displayname  = $file_displayname;
      $this->created_date = $created_date;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM notices');

      // we create a list of notice objects from the database results
      foreach($req->fetchAll() as $notice) {
        $list[] = new Notice($notice['id'], $notice['channel_id'], $notice['notice'], 
          $notice['description'], $notice['filename'], $notice['file_displayname'], $notice['created_date']);
      }

      return $list;
    }

    public static function findByParent($parentId) {
      $list = [];
      $db = Db::getInstance();
      $parentId = intval($parentId);
      $req = $db->prepare('SELECT * FROM notices WHERE channel_id = :channel_id');
      // the query was prepared, now we replace :channel_id with our actual $parentId value
      $req->execute(array('channel_id' => $parentId));

      // we create a list of notice objects from the database results
      foreach($req->fetchAll() as $notice) {
        $list[] = new Notice($notice['id'], $notice['channel_id'], $notice['notice'], 
          $notice['description'], $notice['filename'], $notice['file_displayname'], self::time_elapsed_string($notice['created_date']));
      }

      return $list;
    }

    public static function findByParentByLimit($parentId, $start, $limit) {
      $list = [];
      $db = Db::getInstance();
      $parentId = intval($parentId);
      $req = $db->prepare('SELECT * FROM notices WHERE channel_id = :channel_id ORDER BY created_date ASC LIMIT :start OFFSET :offset');
      $req->bindValue(':channel_id', $parentId);
      $req->bindValue(':start', (int) $limit, PDO::PARAM_INT);
      $req->bindValue(':offset', (int) $start, PDO::PARAM_INT);
      $req->execute();
      
      // we create a list of notice objects from the database results
      foreach($req->fetchAll() as $notice) {
        $list[] = new Notice($notice['id'], $notice['channel_id'], $notice['notice'], 
          $notice['description'], $notice['filename'], $notice['file_displayname'], self::time_elapsed_string($notice['created_date']));
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM notices WHERE id = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $notice = $req->fetch();

      return new Notice($notice['id'], $notice['channel_id'], $notice['notice'], 
          $notice['description'], $notice['filename'], $notice['file_displayname'], $notice['created_date']);
    }

    public static function save(Notice $notice) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO notices(channel_id, notice, description, filename, file_displayname, created_date) VALUES(:channel_id, :notice, :description, :filename, :file_displayname, :created_date)');

      $req->execute(array('channel_id' => $notice->channel_id, 'notice'=> $notice->notice, 'description'=> $notice->description, 'filename' => $notice->filename, 'file_displayname'=> $notice->file_displayname, 'created_date'=> $notice->created_date));
    }

    public static function update(Notice $notice) {
      $db = Db::getInstance();      
       $req = $db->prepare('UPDATE notices  SET notice = :notice, description = :description, filename = :filename, file_displayname = :file_displayname WHERE id = :id');
      $req->execute(array('id'=> $notice->id, 'notice' => $notice->notice, 'description' => $notice->description, 'filename'=> $notice->filename , 'file_displayname'=> $notice->file_displayname));
    }

    public static function delete(Notice $notice) {
      $db = Db::getInstance();      
      $req = $db->prepare('DELETE FROM notices WHERE id = :id');
      $req->execute(array('id'=> $notice->id));
    }

    private static function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

  }
?>