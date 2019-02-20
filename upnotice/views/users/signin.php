<div class="form-outer text-center d-flex align-items-center">
          <div class="form-inner">
            <div class="logo text-uppercase"><span>Sign In</span><strong class="text-primary"></strong></div>
            <p>This is the sign in form to login through this site</p>
            <form id="login-form" method="post" action="?controller=users&action=signin">
              <div class="form-group">
                <label for="email" class="label-custom">Email</label>
                <input id="email" type="email" name="email" value="<?php echo $validObj->email?>" required="">
                <p class="help-block" style="color:red"><?php echo $validObj->emailMsg?></p>
              </div>
              <div class="form-group">
                <label for="password" class="label-custom">Password</label>
                <input id="password" type="password" name="password" required=""value="<?php echo $validObj->password?>">
                <p class="help-block" style="color:red"><?php echo $validObj->passwordMsg?></p>
              </div>
              <input type="hidden" name="submit" value="1">
              <button type="submit" class="btn btn-primary">Login</button>
              <!-- This should be submit button but I replaced it with <a> for demo purposes-->
            </form><a href="?controller=users&action=forgotpassword" class="forgot-pass">Forgot Password?</a><small>Do not have an account? </small><a href="?controller=users&action=signup" class="signup">Signup</a>
          </div>
          <div class="copyrights text-center">
            <p>AppBestir &copy; <?php echo date("Y")?></p>
          </div>
        </div>
