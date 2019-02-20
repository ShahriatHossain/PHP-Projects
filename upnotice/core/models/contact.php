<?php
  class Contact {
    // we define 3 attributes
    
    public $id;
    public $email;
    public $subject;
    public $body;

    public function __construct($id, $email, $subject, $body) {
      $this->id      = $id;
      $this->email  = $email;
      $this->subject = $subject;
      $this->body = $body;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM contacts');

      // we create a list of Contact objects from the database results
      foreach($req->fetchAll() as $contact) {
        $list[] = new Contact($contact['id'], $contact['subject'], $contact['body']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM contacts WHERE id = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $contact = $req->fetch();

      return new Contact($contact['id'], $contact['subject'], $contact['body']);
    }

    public static function save(Contact $contact) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO contacts(email, subject, body) VALUES(:email, :subject, :body)');
      $req->execute(array('email' => $contact->email, 'subject' => $contact->subject, 'body' => $contact->body));
    }

  }
?>