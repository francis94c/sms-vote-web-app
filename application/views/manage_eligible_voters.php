<?php echo form_open("Home/addVoter");?>
  <div class="input-group w3-margin margin-bottom-sm">
    <span class="input-group-addon"><i class="fa fa-camera-o fa-fw"></i></span>
    <input class="form-control" name="voter" type="text" placeholder="Phone Number">
  </div>
</form>
<ul class="w3-ul">
  <?php
  $v = count($voters);
  for($x = 0; $x < $v; $x++) {
    echo "<li class=\"w3-display-container\">" . $voters[$x]["identity_key"] . "<a class=\"w3-button w3-display-right\" href=\"" . site_url("home/deleteVoter/" . $voters[$x]["id"]) . "\">&times;</a></li>";
  }
  ?>
</ul>
