<?php
class Login extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->load->helper("url");
  }

  function index() {
    $data = array("message"=>"");
    if (func_num_args() == 1) {
      $data["message"] = func_get_arg(0);
    }
    $this->load->view("login", $data);
  }

  function process() {
    $this->load->model('authenticator');
    $result = $this->authenticator->authenticate();
    if(!$result) {
      $message = '<font color=red>Invalid Username or Password.</font><br />';
      $this->index($message);
    } else {
      redirect('home');
    }
  }

}
?>
