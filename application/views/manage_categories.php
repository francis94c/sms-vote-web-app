<?php echo form_open("Home/addCategory");?>
  <div class="input-group w3-margin margin-bottom-sm">
    <span class="input-group-addon"><i class="fa fa-camera-o fa-fw"></i></span>
    <input class="form-control" name="category" type="text" placeholder="Name">
  </div>
</form>
<ul class="w3-ul">
  <?php
  $ci =& get_instance();
  $ci->load->model("categories");
  $categories = $ci->categories->getCategories();
  $c = count($categories);
  for($x = 0; $x < $c; $x++) {
    echo "<li class=\"w3-display-container\">" . $categories[$x]["name"] . "<a class=\"w3-button w3-display-right\" href=\"" . site_url("home/deleteCategory/" . $categories[$x]["id"]) . "\">&times;</a></li>";
  }
  ?>
</ul>
