<?php echo form_open("home/changeLoginPassword");?>
  <div class="input-group w3-margin margin-bottom-sm">
    <span class="input-group-addon"><i class="fa fa-camera-o fa-fw"></i></span>
    <input class="form-control" name="old-password" type="password" placeholder="Old Password">
  </div>
  <div class="input-group w3-margin margin-bottom-sm">
    <span class="input-group-addon"><i class="fa fa-camera-o fa-fw"></i></span>
    <input class="form-control" name="new-password" type="password" placeholder="New Password">
  </div>
  <div class="input-group w3-margin margin-bottom-sm">
    <span class="input-group-addon"><i class="fa fa-camera-o fa-fw"></i></span>
    <input class="form-control" name="new-password-again" type="password" placeholder="Re-Type New Password">
  </div>
  <input class="w3-right" name="name" type="submit" value="Change Password">
</form>
