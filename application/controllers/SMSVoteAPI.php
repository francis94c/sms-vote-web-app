<?php
class SMSVoteAPI extends CI_Controller {
  function __construct() {
    parent::__construct();
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
  function vote() {
    $this->load->model("console");
    if ($this->console->checkElectionState()) {
      $voter = $this->uri->segment(3);
      $codes = array();
      $index = 4;
      $buffer = $this->uri->segment($index);
      while ($buffer != "") {
        $codes[] = $buffer;
        ++$index;
        $buffer = $this->uri->segment($index);
      }
      $this->load->model("BallotBox");
      echo json_encode($this->BallotBox->vote($voter, $codes));
    } else {
      echo json_encode(array("fraud"=>-1, "errors"=>-1));
    }
  }

}
?>
