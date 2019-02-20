<?php
  class NoticeDetails {
    public $notice_id;
    public $notice;
    public $description;
    public $channel_id;
    public $channel_name;
    public $user_id;
    public $filename;
    public $file_displayname;
    public $response;
    public $created_date;

    public function __construct($notice_id, $notice, $description, $channel_id, $channel_name, $user_id, $filename, $file_displayname, $response, $created_date) {
      $this->notice_id = $notice_id;
      $this->notice  = $notice;
      $this->description = $description;
      $this->channel_id = $channel_id;
      $this->channel_name = $channel_name;
      $this->user_id = $user_id;
      $this->filename = $filename;
      $this->file_displayname = $file_displayname;
      $this->response = $response;
      $this->created_date = $created_date;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT nt.id as notice_id, nt.notice, nt.description, nt.created_date, nt.filename, nt.file_displayname, nt.channel_id, ch.name AS channel_name, ntv.user_id, ntv.response FROM notices nt 
        LEFT JOIN channels ch ON nt.channel_id=ch.id
        LEFT JOIN notice_voting ntv ON nt.id=ntv.notice_id');

      // we create a list of notice objects from the database results
      foreach($req->fetchAll() as $notice) {
        $list[] = new NoticeDetails($notice['notice_id'], $notice['notice'], $notice['description'], $notice['channel_id'], $notice['channel_name'], $notice['user_id'], $notice['filename'], $notice['file_displayname'], $notice['response'], self::time_elapsed_string($notice['created_date']));
      }

      return $list;
    }

    public static function find($noticeId) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $noticeId = intval($noticeId);
      $req = $db->prepare('SELECT nt.id as notice_id, nt.notice, nt.description, nt.created_date, nt.filename, nt.file_displayname, nt.channel_id, ch.name AS channel_name, ntv.user_id, ntv.response FROM notices nt 
        LEFT JOIN channels ch ON nt.channel_id=ch.id AND nt.id = :notice_id
        LEFT JOIN notice_voting ntv ON nt.id=ntv.notice_id');
      // the query was prepared, now we replace :notice_id with our actual $noticeId value
      $req->execute(array('notice_id' => $noticeId));
      $notice = $req->fetch();

      return new NoticeDetails($notice['notice_id'], $notice['notice'], $notice['description'], $notice['channel_id'], $notice['channel_name'], $notice['user_id'], $notice['filename'], $notice['file_displayname'], $notice['response'], self::time_elapsed_string($notice['created_date']));
    }

    public static function findByParent($parentId) {
      $list = [];
      $db = Db::getInstance();
      $parentId = intval($parentId);

      $req = $db->prepare('SELECT nt.id as notice_id, nt.notice, nt.description, nt.created_date, nt.filename, nt.file_displayname, nt.channel_id, ch.name AS channel_name, ntv.user_id, ntv.response FROM notices nt 
        LEFT JOIN channels ch ON nt.channel_id=ch.id
        LEFT JOIN notice_voting ntv ON nt.id=ntv.notice_id WHERE ch.id = :channel_id');

      $req->execute(array('channel_id' => $parentId));

      // we create a list of notice objects from the database results
      foreach($req->fetchAll() as $notice) {
        $list[] = new NoticeDetails($notice['notice_id'], $notice['notice'], $notice['description'], $notice['channel_id'], $notice['channel_name'], $notice['user_id'], $notice['filename'], $notice['file_displayname'], $notice['response'], self::time_elapsed_string($notice['created_date']));
      }
      return $list;
    }

    public static function findByParentByLimit($parentId, $start, $limit) {
      $list = [];
      $db = Db::getInstance();
      $parentId = intval($parentId);

      $req = $db->prepare('SELECT nt.id as notice_id, nt.notice, nt.description, nt.created_date, nt.filename, nt.file_displayname, nt.channel_id, ch.name AS channel_name, ntv.user_id, ntv.response FROM notices nt 
        LEFT JOIN channels ch ON nt.channel_id=ch.id
        LEFT JOIN notice_voting ntv ON nt.id=ntv.notice_id WHERE ch.id = :channel_id ORDER BY created_date DESC LIMIT :start OFFSET :offset');

      $req->bindValue(':channel_id', $parentId);
      $req->bindValue(':start', (int) $limit, PDO::PARAM_INT);
      $req->bindValue(':offset', (int) $start, PDO::PARAM_INT);
      $req->execute();

      // we create a list of notice objects from the database results
      foreach($req->fetchAll() as $notice) {
        $list[] = new NoticeDetails($notice['notice_id'], $notice['notice'], $notice['description'], $notice['channel_id'], $notice['channel_name'], $notice['user_id'], $notice['filename'], $notice['file_displayname'], $notice['response'], self::time_elapsed_string($notice['created_date']));
      }
      return $list;
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