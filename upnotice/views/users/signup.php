<div class="form-outer text-center d-flex align-items-center">
          <div class="form-inner">
            <div class="logo text-uppercase"><span>Sign Up</span><strong class="text-primary"></strong></div>
            <p>This is the registration form to register through this site.</p>
            <form id="register-form">
              <div class="form-group">
                <label for="email" class="label-custom">Email</label>
                <input id="email" type="email" name="email" value="<?php echo $validObj->email?>" required>
                <p class="help-block" style="color:red"><?php echo $validObj->emailMsg?></p>
              </div>
              <div class="form-group">
                <label for="password" class="label-custom">Password</label>
                <input id="password" type="password" name="password" value="<?php echo $validObj->password?>" required>
                <p class="help-block" style="color:red"><?php echo $validObj->passwordMsg?></p>
              </div>
              <div class="form-group">
                <label for="cpassword" class="label-custom">Confirm Password</label>
                <input id="cpassword" type="password" name="cpassword" value="<?php echo $validObj->cpassword?>" required>
                <p class="help-block" style="color:red"><?php echo $validObj->passwordMatchMsg?></p>
              </div>
              <div class="terms-conditions d-flex justify-content-center">
                <input id="license" type="checkbox" class="form-control-custom">
                <label for="license">Agree the terms and policy</label>
              </div>
              <input type="hidden" name="submit" value="1">
              <input id="register" type="submit" value="Register" class="btn btn-primary">
            </form><small>Already have an account? </small><a href="?controller=users&action=signin" class="signup">Login</a>
          </div>
          <div class="copyrights text-center">
            <p>AppBestir &copy; <?php echo date("Y")?></p>
          </div>
        </div>
