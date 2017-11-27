<!DOCTYPE html>
<html>
<title>SMS Vote Portal</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?=base_url();?>/css/w3css.css">
<link rel="stylesheet" href="<?=base_url();?>/css/google-fonts.css">
<link rel="stylesheet" href="<?=base_url();?>/css/fa/font-awesome.min.css">
<link rel="stylesheet" href="<?=base_url();?>/css/bootstrap.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey w3-content" style="max-width:1600px">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container">
    <a href="#" onclick="w3_close()" class="w3-hide-large w3-right w3-jumbo w3-padding w3-hover-grey" title="close menu">
      <i class="fa fa-remove"></i>
    </a>
    <img src="/w3images/avatar_g2.jpg" style="width:45%;" class="w3-round"><br><br>
    <h4><b>SMS VOTING PORTAL</b></h4>
    <p class="w3-text-grey">MAIN MENU</p>
  </div>
  <div class="w3-bar-block">
    <a href="<?=site_url("home")?>" class="w3-bar-item w3-button w3-padding <?php echo $flag == 0 ? "w3-text-teal" : ""; ?>"><i class="fa fa-users fa-fw w3-margin-right"></i>MANAGE CANDIDATES</a>
    <a href="<?php echo site_url("home/showManageCategories");?>" class="w3-bar-item w3-button w3-padding <?php echo $flag == 1 ? "w3-text-teal" : ""; ?>"><i class="fa fa-th fa-fw w3-margin-right"></i>MANAGE CATEGORIES</a>
    <a href="#contact" onclick="w3_close()" class="w3-bar-item w3-button w3-padding <?php echo $flag == 2 ? "w3-text-teal" : ""; ?>"><i class="fa fa-terminal fa-fw w3-margin-right"></i>CONSOLE</a>
    <a href="<?php echo site_url("home/showLiveResults");?>" class="w3-bar-item w3-button w3-padding <?php echo $flag == 3 ? "w3-text-teal" : ""; ?>"><i class="fa fa-flag fa-fw w3-margin-right"></i>VIEW LIVE RESULTS</a>
    <a href="#contact" onclick="w3_close()" class="w3-bar-item w3-button w3-padding <?php echo $flag == 3 ? "w3-text-teal" : ""; ?>"><i class="fa fa-flag fa-fw w3-margin-right"></i>MANAGE ELIGIBLE VOTERS</a>
  </div>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px">

  <!-- Header -->
  <header id="portfolio">
    <a href="#"><img src="/w3images/avatar_g2.jpg" style="width:65px;" class="w3-circle w3-right w3-margin w3-hide-large w3-hover-opacity"></a>
    <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
    <div class="w3-container">
    <h1><b><?=$title?></b></h1>
    <div class="w3-section w3-bottombar w3-padding-16">
      <?php
      $c = count($menu);
      for ($x = 0; $x < $c; $x++) {
        echo "<a href=\"" . $menu[$x][2] . "\" class=\"w3-button w3-white\"><i class=\"fa " . $menu[$x][0] . " w3-margin-right\"></i>" . $menu[$x][1] . "</a>";
      }
      ?>
    </div>
    </div>
  </header>
  <p class="w3-padding"><?=$message?></p>
