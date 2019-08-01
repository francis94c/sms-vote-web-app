<?php echo form_open_multipart("home/addCandidate");?>
<form class="input-form" action="" method="">
  <div class="input-group w3-margin margin-bottom-sm">
    <span class="input-group-addon"><i class="fa fa-camera-o fa-fw"></i></span>
    <input class="form-control" name="passport" type="file" placeholder="Name">
  </div>
  <div class="input-group w3-margin margin-bottom-sm">
    <span class="input-group-addon"><i class="fa fa-user-o fa-fw"></i></span>
    <input class="form-control" name="first_name" value="<?=$params["first_name"]?>" type="text" placeholder="First Name">
  </div>
  <div class="input-group w3-margin margin-bottom-sm">
    <span class="input-group-addon"><i class="fa fa-user-o fa-fw"></i></span>
    <input class="form-control" name="middle_name" type="text" value="<?=$params["middle_name"]?>" placeholder="Middle Name">
  </div>
  <div class="input-group w3-margin margin-bottom-sm">
    <span class="input-group-addon"><i class="fa fa-user-o fa-fw"></i></span>
    <input class="form-control" name="last_name" value="<?=$params["last_name"]?>" type="text" placeholder="Last Name">
  </div>
  <div class="input-group w3-margin margin-bottom-sm">
    <span class="input-group-addon"><i class="fa fa-user-o fa-fw"></i></span>
    <select class="form-control" name="category">
      <option value="0">Category</option>
      <?php
      $ci =& get_instance();
      $ci->load->model("categories");
      $categories = $ci->categories->getCategories();
      $c = count($categories);
      for($x = 0; $x < $c; $x++) {
        if ($params["category"] == $categories[$x]["id"]) {
          echo "<option value=\"" . $categories[$x]["id"] . "\" selected>" . $categories[$x]['name'] . "</option>";
        } else {
          echo "<option value=\"" . $categories[$x]["id"] . "\">" . $categories[$x]['name'] . "</option>";
        }
      }
      ?>
    </select>
  </div>
  <input class="w3-right" name="name" type="submit" value="Add Candidate">
</form>
