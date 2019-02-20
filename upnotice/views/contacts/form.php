<form method="post" action="?controller=contacts&action=post">
  <div class="form-group">
    <label for="inputSubject" class="col-form-label">Subject</label>
    <input type="text" name="subject" class="form-control" id="inputSubject" placeholder="Subject for">
  </div>
  <div class="form-group">
    <label for="inputEmail" class="col-form-label">Email</label>
    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email">
  </div>
  <div class="form-group">
    <label for="inputBody" class="col-form-label">Body</label>
    <textarea name="body" id="inputBody" class="form-control"></textarea>
  </div>

  <input type="hidden" name="submit" value="1">
  <button type="submit" class="btn btn-primary">Send</button>
</form>