<?php
class SMSVoteAPI extends CI_Controller {
  function __construct() {
    $this->load->model("preferences");
  }
  function flagModuleConnection() {
    $flag = $this->uri->segment(3) == 1 ? "true" : "false";
    if ($this->preferences->setPreference("module_connected", $flag)) {
      echo "1";
    } else {
      echo "0";
    }
  }
  function flagModuleReady() {
    $flag = $this->uri->segment(3) == 1 ? "true" : "false";
    if ($this->preferences->setPreference("module_ready", $flag)) {
      echo "1";
    } else {
      echo "0";
    }
  }
}
?>
