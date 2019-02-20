<?php echo $breadcrumb;?>
<section class="charts">
    <div class="container-fluid">
        <form method="post" action="?controller=manageusers&action=edit&id=<?php echo $user->id?>">
  
          <div class="form-group">
              <label for="email" class="col-form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo $validObj->email?>">
              <p class="help-block" style="color:red"><?php echo $validObj->emailMsg?></p>
            </div>
            <div class="form-group">
              <label for="password" class="col-form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Password" value="<?php echo $validObj->password?>">
              <p class="help-block" style="color:red"><?php echo $validObj->passwordMsg?></p>
            </div>
            <div class="form-group">
              <label for="name" class="col-form-label">Role</label>
              <select class="form-control" id="role_id" name="role_id">
                <?php foreach($roles as $role){?>
                  <option value="<?php echo $role->id?>" <?php if($role->id == $validObj->role)echo'selected="selected"'?>><?php echo $role->name?></option>
                <?php }?>
              </select>
              <p class="help-block" style="color:red"><?php echo $validObj->roleMsg?></p>
            </div>
            <div class="form-group">
              <label for="name" class="col-form-label">Name</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="<?php echo $validObj->name?>">
            </div>
            <div class="form-group">
              <label for="address" class="col-form-label">Address</label>
              <input type="text" name="address" class="form-control" id="address" placeholder="Address" value="<?php echo $validObj->address?>">
            </div>
          <input type="hidden" name="submit" value="1">
          <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
</section>
