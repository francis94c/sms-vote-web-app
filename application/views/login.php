<!doctype html>
<html>
<head>
  <title>SMS Voting Portal</title>
  <link rel="stylesheet" href="<?=base_url()?>css/style.css">
</head>
<body>
  <div class="login-page">
    <div class="form">
      <form class="login-form" action="<?php echo base_url(); ?>index.php/login/process" method="post">
        <input name="username" type="text" placeholder="username"/>
        <input name="password" type="password" placeholder="password"/>
        <button>login</button>
        <p class="message"><?=$message?></p>
      </form>
    </div>
  </div>
</body>
</html>
