<p>Here is a list of all contacts:</p>

<?php foreach($contacts as $contact) { ?>
  <p>
    <?php echo $contact->subject; ?>
    <a href='?controller=contacts&action=show&id=<?php echo $contact->id; ?>'>See content</a>
  </p>
<?php } ?>