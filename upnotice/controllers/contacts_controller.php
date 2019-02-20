<?php
  class ContactsController {
    public function index() {
      // we store all the contacts in a variable
      $contacts = Contact::all();
      require_once('views/contacts/index.php');
    }

    public function show() {
      // we expect a url of form ?controller=contacts&action=show&id=x
      // without an id we just redirect to the error page as we need the contact id to find it in the database
      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right contact
      $contact = Contact::find($_GET['id']);
      require_once('views/contacts/show.php');
    }

    public function post() {
      // we expect a url of form ?controller=contacts&action=post
      if(isset($_POST['submit'])){
        $contact = new Contact(0, $_POST['email'], $_POST['subject'], $_POST['body']);
        Contact::save($contact);
        $this->sendEmail($contact);
      }

      require_once('views/contacts/form.php');
    }

    private function sendEmail(Contact $contact){
      var_dump($contact);
      // use wordwrap() if lines are longer than 70 characters
      $msg = wordwrap($contact->body,70);
      // send email
      mail($contact->email, $contact->subject, $msg);
    }
  }
?>